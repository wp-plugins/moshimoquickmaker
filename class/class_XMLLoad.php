<?php

class uc_XMLLoad{
	
	var $table_name_conf = UC_MSM_TABLECONF;
	var $table_name_conf_array;
	var $table_name_item = UC_MSM_TABLEITEM;
	var $table_name_item_array;
	var $table_name_itemcategory_array;
	var $table_name_junle = UC_MSM_TABLEJUNLE;
	
	var $category_list_url = "http://api.moshimo.com/category/list2";
	var $item_list_url = "http://api.moshimo.com/article/search2";
	var $item_add_limit = 100;
	var $delete_scoreline = 5;
	var $category_addmax = UC_MSM_CATEGORY_ADDMAX;
	
	function uc_XMLLoad(){
		$this->table_name_conf_array = DefineArray("UC_MSM_TABLECONF_MARRAY");
		$this->table_name_item_array = DefineArray("UC_ITEMDB_ARRAY");
		$this->table_name_itemcategory_array = DefineArray("UC_ITEMCATEGORY_ARRAY");
	}
	
	
	function ItemUpdateDelete($del_array){
		$dbresult_obj = new uc_MoshimoDB;
		foreach($del_array as $key=>$value){
			$dbresult_obj->KeyIDDelete($this->table_name_item,"item_MyChildGroupId",$value);
		}
	}
	function NewItemUpdate($new_array){
		$error_array = array();
		$dbresult_obj = new uc_MoshimoDB;
		foreach($new_array as $value){
			$get_item_array = $this->ItemSearch($value);
			if($get_item_array !== false){
				$set_db_array = $this->SearchItemChgArray($get_item_array);
				for($i=0; $i<count($set_db_array); $i++){
					$dbresult_obj->InsertData($this->table_name_item,$set_db_array[$i]);
				}
			}else{
				$error_array[] = $value;
			}
		}
		
		return $error_array;
	}

	
	function ItemSearch($get_parentID){
		
		$sort_num = "sales";
		$search_count = $this->item_add_limit;
		$dbresult_obj = new uc_MoshimoDB;
		$now_setval_array = $dbresult_obj->KeyIDSearch($this->table_name_conf,"conf_confid",UC_MSM_CONFID,DefineArrayCngArray($this->table_name_conf_array));
		$conf_apicode = $now_setval_array[0]['conf_apicode'];
		
		$categories_array = array();
		$item_url = $this->item_list_url."?authorization_code=".$conf_apicode."&article_category_code=".$get_parentID."&sort_order=".$sort_num."&exists_stock=1&list_per_page=".$search_count;
		
		if($categories_array = XmlReturnArray($item_url)){
			return $categories_array;
		}else{
			return false;
		}
		
	}
	
	function SearchItemChgArray($categories_array){
		
		$categorydata_array = $categories_array['Articles']['Article'];
		

		for($i=0; $i<count($categorydata_array); $i++){
			$set_array = array();
			foreach($categorydata_array[$i] as $key=>$value){
				
				$dbset_key = "item_".$key;
				
				switch($key){
					
					case 'Category':
						
						if(count($value) > 0){
						
							foreach($value as $c_key=>$c_value){
								
								if($c_key == "Parents"){
									
									$dbset_category_key = $dbset_key."_".$c_key;
									$c_value_parent = $c_value['Parent'];
									
									$MyParentGroupId = $c_value_parent[0]['Code'];
									$MyChildGroupId = $c_value_parent[1]['Code'];
									
									if(count($c_value_parent) > 0){
										$set_parent_data = array();
										for($j=0; $j<count($c_value_parent); $j++){
											if(count($c_value_parent[$j]) > 0){
												$parentID = $c_value_parent[$j]['Code'];
												foreach($c_value_parent[$j] as $p_key=>$p_value){
													$set_parent_data[] = $p_key.":".$p_value;
												}
											}
										}
										$set_array[$dbset_category_key] = implode("*",$set_parent_data);
									}
								}else{
									$dbset_category_key = $dbset_key."_".$c_key;
									$set_array[$dbset_category_key] = HTML_encode($c_value);
								}
							}
						}
						
						break;
					
					default:
					
						$set_data = $value;
						if(!$set_data || count($set_data) <= 0){
							$set_data = "";
						}
						$set_array[$dbset_key] = $set_data;
						
						break;
				}
				
				
			}
			
			$set_array["item_MyParentGroupId"] = $MyParentGroupId;
			$set_array["item_MyChildGroupId"] = $MyChildGroupId;
			$set_array["item_InsertDate"] = date('YmdHis');
			$set_array["item_Clickcount"] = 0;
			$set_array["item_ClickcountData"] = "";
			
			$return_array[$i] = $set_array;
		}
		
		return $return_array;
		
	}
	
	
	
	
	function GetParentCategory(){
		return DefineArray("UC_PARENTDIR_RARRAY");
	}
	
	function GetCategory(){
		$dbresult_obj = new uc_MoshimoDB;
		$now_setval_array = $dbresult_obj->KeyIDSearch($this->table_name_conf,"conf_confid",UC_MSM_CONFID,DefineArrayCngArray($this->table_name_conf_array));
		$conf_apicode = $now_setval_array[0]['conf_apicode'];
		$return_category_array = array();
		$parent_category_array = $this->GetParentCategory();
		foreach($parent_category_array as $key=>$value){
			$caterogy_url = $this->category_list_url."?authorization_code=".$conf_apicode."&article_category_code=".$key;
			if($categories_array = XmlReturnArray($caterogy_url)){
				$category_array = $categories_array['Category']['Children']['Child'];
				$return_category_array[$key]["parentname"] = $value;
				$return_category_array[$key]["data"] = $category_array;
			}else{
			}
		}
		
		return $return_category_array;
	}
	
	function CategoryAdminHtml($category_array,$now_junle_array){
		
		$return_html = "<table class='admin_category_parent'>";
		$tr_count = 1;
		$js_name_array = array();
		
		foreach($category_array as $key=>$value){
			if($tr_count <= 1){
				$return_html .= "<tr>";
			}
			$return_html .= "<td><p class='category_title'>".$value['parentname']."</p><ul class='sub_category clearfix'>";
			foreach($value['data'] as $key_v=>$value_v){
				$search_result = array_search($value_v['Code'],$now_junle_array);
				if($search_result === false || $search_result === NULL){
					$selected = "";
				}else{
					$selected = "checked";
				}
				$return_html .= "<li><input type='checkbox' name='category[]' id='".$value_v['Code']."' onClick='SelectCheck(\"".$value_v['Code']."\")' value='".$value_v['Code']."' ".$selected.">&nbsp;".$value_v['Name']."</li>";
				$js_name_array[] = "'".$value_v['Code']."'";
			}
			$return_html .= "</ul></td>";
			if($tr_count >= 3){
				$return_html .= "</tr>";
				$tr_count = 1;
			}else{
				$tr_count++;
			}
		}
		$return_html .= "</table>";
		
		$jstag = "<SCRIPT language='JavaScript'>
		<!--
			checkname_array = new Array(".implode(",",$js_name_array).");
			checkmax = ".$this->category_addmax.";
			function SelectCheck(select_check){
				
				cnt = 0;
				for(i=0; i<checkname_array.length; i++) {
					if(document.getElementById(checkname_array[i]).checked){
						cnt++;
					}
				}

				if(cnt > checkmax) {
					alert('選択可能数は' + checkmax + '個までです');
					document.getElementById(select_check).checked = false;
				}
			}
		//-->
		</SCRIPT>";
		
		$return_html .= $jstag;
		
		return $return_html;
	}
	
	
	function ItemUpdate(){
		$dbresult_obj = new uc_MoshimoDB;
		$request_field = "junle_id";
		$update_array = $dbresult_obj->SelectFieldAllData($this->table_name_junle,$request_field);
		for($i=0; $i<count($update_array); $i++){
			$this->SelectDeleteItem($update_array[$i]);
		}
	}
	
	function SelectDeleteItem($search_code){
		
		
		$dbresult_obj = new uc_MoshimoDB;
		
		$search_key = "item_MyChildGroupId";
		$request_field_array = $this->table_name_item_array;
		$DBsearchArray = $dbresult_obj->KeyIDSearch($this->table_name_item,$search_key,$search_code,$request_field_array);
		$today = date('Ymd');
		
		if(count($DBsearchArray) > 0){
			
			for($i=0; $i<count($DBsearchArray); $i++){
				
				$count_data = explode("|",$DBsearchArray[$i]["item_ClickcountData"]);
				if(count($count_data) > 0){
					for($j=0; $j<count($count_data); $j++){
						$pDate_array = explode("*",$count_data[$j]);
						$diffday = DayDiffTwoDate($pDate_array[0],$today);
						$new_flagnum = -1*($diffday - 5);
						if($new_flagnum < 1){
							$new_flagnum = 1;
						}
						$clickcount = $pDate_array[1];
						$score = $new_flagnum*$clickcount;
						$DBsearchArray[$i]["temp_score"] = $score;
					}
				}else{
					$DBsearchArray[$i]["temp_score"] = 0;
				}
				
			}
			
			$DBsearchArray = MultiSort("temp_score",$DBsearchArray,"desc");
			for($i=0; $i<count($DBsearchArray); $i++){
				if($DBsearchArray[$i]["temp_score"] < $this->delete_scoreline){
					$delete_can_array[] = $DBsearchArray[$i]["item_ArticleId"];
				}
			}
			
			
		}else{
			$DBsearchArray = array();
			$delete_can_array = array();
		}
		
		$dbset_flag = $this->GetItem($search_code,$DBsearchArray,$delete_can_array);
		return $dbset_flag;
		
	}
	
	function GetItem($search_code,$DBsearchArray,$delete_can_array){
		
		$dbresult_obj = new uc_MoshimoDB;
		
		$get_item_array = $this->ItemSearch($search_code);
		if($get_item_array !== false){
			
			$new_data_array = $this->SearchItemChgArray($get_item_array);
			
			if(count($DBsearchArray) > 0){
				
				$db_add_array = array();
				for($i=0; $i<count($new_data_array); $i++){
					for($j=0; $j<count($DBsearchArray); $j++){
						if($DBsearchArray[$j]["item_ArticleId"] == $new_data_array[$i]["item_ArticleId"]){
							unset($new_data_array[$i]);
						}
					}
				}
				$new_data_array = array_merge($new_data_array,array());
				
				$count_delete_can = count($delete_can_array);
				$count_new_can = count($new_data_array);
				if($count_delete_can > $count_new_can){
					
				}else{
					$newdelcount = $count_new_can - $count_delete_can;
					$new_data_array = array_slice($new_data_array,-($newdelcount),$newdelcount);
				}
				
				$DBDeleteArray = array_splice($DBsearchArray,-(count($new_data_array)),count($new_data_array));
				for($i=0; $i<count($DBDeleteArray); $i++){
					$dbresult_obj->KeyIDDelete($this->table_name_item,"item_ArticleId",$DBDeleteArray[$i]["item_ArticleId"]);
				}
				
			}else{
				
			}
			
			for($i=0; $i<count($new_data_array); $i++){
				$table_set_array = array();
				foreach($this->table_name_item_array as $key=>$value){
					$table_set_array[$value] = $new_data_array[$i][$value];
				}
				$dbresult_obj->InsertData($this->table_name_item,$table_set_array);
			}
			
			$return_flag = true;
			
		}else{
			$return_flag = false;
		}
		
		return $return_flag;
	}
	
	
	
	
	
}




?>