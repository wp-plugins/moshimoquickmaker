<?php
ini_set( 'display_errors', 1 );

require_once( UC_MSM_FUNCTIONPATH.'func_common.php');
require_once( UC_MSM_FUNCTIONPATH.'func_Judge.php');
require_once( UC_MSM_CLASSPATH.'class_DB.php');
require_once( UC_MSM_CLASSPATH.'class_XMLLoad.php');
require_once( UC_MSM_CLASSPATH.'class_Paging.php');

class UcDsMoshimoPublic{
	
	var $myplugintitle = UC_MSM_TITLE;
	var $myversion = UC_MSM_VERSION;
	var $db_option_version_name = UC_MSM_VALNAME_VERSION;
	
	var $table_name_conf = UC_MSM_TABLECONF;
	var $table_name_junle = UC_MSM_TABLEJUNLE;
	var $table_name_item = UC_MSM_TABLEITEM;
	
	var $table_name_conf_array;
	var $table_name_junle_array;
	var $table_name_item_array;
	
	var $item_sortID_array;
	var $item_andor_array;
	var $item_searchtarget_array;
	
	var $item_slug = UC_MSM_ITEMSLUG;
	var $item_selectID = UC_MSM_ITEMSELECTID;
	var $item_sortID = UC_MSM_ITEMSORTCATE;
	var $item_sortdesc = UC_MSM_ITEMSORTDESC;
	
	var $item_searchlang = UC_MSM_ITEMSEARCH;
	var $item_pagingID = UC_MSM_PAGINGID;
	var $item_searchandor = UC_MSM_ITEMSEARCHANDOR;
	var $item_searchcategory = UC_MSM_ITEMSEARCHCATEGORY;
	
	var $link_max_num = UC_MSM_ITEMLIST_MAX;
	var $disp_item_num = UC_MSM_ITEMLIST_MAXITEM;
	var $disp_item_column = UC_MSM_ITEMLIST_COLUM;
	
	var $detail_slug = UC_MSM_DETAILSLUG;
	var $item_detailID = UC_MSM_ITEMDETAILID;
	
	var $item_imgpath = UC_MSM_IMAGE_URL;
	
	var $item_cartpath = UC_MSM_CART_URL;
	
	var $fixprice_flag = "true";
	
	function __construct(){
		$this->table_name_conf_array = DefineArray("UC_MSM_TABLECONF_MARRAY");
		$this->table_name_item_array = DefineArray("UC_ITEMDB_ARRAY");
		$this->table_name_junle_array = DefineArray("UC_ITEMJUNLE_ARRAY");
		$this->item_sortID_array = DefineArray("UC_MSM_ITEMSORT_RARRAY");
		$this->item_andor_array = DefineArray("UC_MSM_ITEMANDOR_RARRAY");
		$this->item_searchtarget_array = DefineArray("UC_MSM_ITEMCATEGORY_RARRAY");
	}
	
	function PubJSinclude(){
		$script = file_get_contents(UC_MSM_JSPATH."public_func.js");
		$html = "<script type='text/javascript'>".$script."</script>";
		$html .= "<script src='".UC_MSM_PARENT_URL."js/uc_msm_parent.js?flag=public'></script>";
		echo $html;
	}
	
	
	function getinfo(){
		$dbresult_obj = new uc_MoshimoDB;
		$get_array = $dbresult_obj->ConfDataGet();
		return $get_array;
	}
	
	function getsidemenu(){
		
		$dbresult_obj = new uc_MoshimoDB;
		$junle_obj = new uc_XMLLoad;
		$category_array = $junle_obj->GetCategory();
		$this->PubJSinclude();
		
		if($category_array){
			
			$now_junle_array = $dbresult_obj->SelectFieldAllData($this->table_name_junle,"junle_id");
			$select_array = array();
			$array_count = 0;
			
			foreach($category_array as $key=>$value){
			
				$temp_category_data_array = $value['data'];
				$temp_select_array = array();
				
				for($j=0; $j<count($temp_category_data_array); $j++){
					for($k=0; $k<count($now_junle_array); $k++){
						if($temp_category_data_array[$j]['Code'] == $now_junle_array[$k]){
							$temp_select_array[$temp_category_data_array[$j]['Code']] = $temp_category_data_array[$j]['Name'];
						}
					}
				}
				
				if(count($temp_select_array) > 0){
					$select_array[$array_count]['parentname'] = $value['parentname'];
					$select_array[$array_count]['data'] = $temp_select_array;
					$array_count++;
				}
				
			}
			
			$slagid = get_page_by_path($this->item_slug)->ID;
			$permalink = get_permalink($slagid);
			
			if(count($select_array) > 0){
				
				$output_tag = "<ul class='uc_msm_sidebar'>";
				for($i=0; $i<count($select_array); $i++){
					$output_tag .= "<li class='uc_msm_sideseg'><p class='uc_msm_sidetitle'>".$select_array[$i]['parentname']."</p>";
					$output_tag .= "<ul class='uc_msm_subcategory'>";
					$temp_select_array = $select_array[$i]['data'];
					foreach($temp_select_array as $key=>$value){
						$add_url_array = array( $this->item_selectID => $key, $this->item_searchcategory => 'select' );
						$newlink = add_query_arg($add_url_array,$permalink);
						$output_tag .= "<li><a href='".$newlink."'>".$value."</a></li>";
					}
					$output_tag .= "</li></ul>";
				}
				$output_tag .= "</ul>";
			
			}else{
				$output_tag = "<p class='uc_msm_sidenomenu'>現在商品がありません</p>";
			}
			
			
		}else{
			$output_tag = "<p class='uc_msm_sidenomenu'>現在商品がありません</p>";
		}
		
		return $output_tag;
		
	}
	
	function GetTitle(){
		
		global $uc_msm_message_flag;
		$flag = $uc_msm_message_flag;
		$dbresult_obj = new uc_MoshimoDB;
		$return = "";
		
		switch($flag){
			case 'item_list':
				
				if($_GET['search']){
					$return = "商品検索結果";
				}elseif($_GET[ $this->item_selectID ]){
					$getID = htmlspecialchars($_GET[ $this->item_selectID ]);
					$return = $dbresult_obj->ItemListTitleGet($getID);
				}
				
				break;
			case 'item_detail':
				if($_GET[ $this->item_detailID ]){
					$getID = htmlspecialchars($_GET[ $this->item_detailID ]);
					$detail_array = $dbresult_obj->ItemDetailGet($getID);
					$return = $detail_array['item_Name'];
				}
				break;
		}
		
		return $return;
		
	}
	
	function GetParmalinkArray(){
		
		$search_url_array = array();
		
		$getID = htmlspecialchars($_GET[ $this->item_selectID ]);
		$sortID_temp = htmlspecialchars($_GET[ $this->item_sortID ]);
		$sortdesc_temp = htmlspecialchars($_GET[ $this->item_sortdesc ]);
		$searchlang = htmlspecialchars($_GET[ $this->item_searchlang ]);
		$searchandor = htmlspecialchars($_GET[ $this->item_searchandor ]);
		$searchcategory = htmlspecialchars($_GET[ $this->item_searchcategory ]);
		
		$search_url_array[$this->item_selectID] = $getID;
		
		if(!empty($_GET[ $this->item_pagingID ]) && valid_input_num($_GET[ $this->item_pagingID ],"ページ") === true){
			$page = $_GET[ $this->item_pagingID ];
		}else{
			$page = 1;
		}
		$search_url_array[$this->item_pagingID] = $page;
		
		if(array_key_exists($sortID_temp,$this->item_sortID_array)){
			$sortID = $sortID_temp;
			if($sortdesc_temp == "desc"){
				$sortdesc = "desc";
			}else{
				$sortdesc = "";
			}
		}else{
			$sortID = "";
			$sortdesc = "";
		}
		$search_url_array[$this->item_sortID] = $sortID;
		$search_url_array[$this->item_sortdesc] = $sortdesc;
		
		if($searchlang){
			$search_lang = $searchlang;
		}else{
			$search_lang = "";
		}
		$search_url_array[$this->item_searchlang] = $search_lang;
			
		if(array_key_exists($searchandor,$this->item_andor_array)){
			$search_andor = $searchandor;
		}else{
			$search_andor = "or";
		}
		$search_url_array[$this->item_searchandor] = $search_andor;
		
		if(array_key_exists($searchcategory,$this->item_searchtarget_array)){
			$search_category = $searchcategory;
		}else{
			$search_category = "all";
		}
		$search_url_array[$this->item_searchcategory] = $search_category;
		
		
		
		return $search_url_array;
	}
	
	function PageItemList(){
		
		global $post;
		$dbresult_obj = new uc_MoshimoDB;
		
		
		$pager_obj = new Un_msm_Paging;
		
		$get_array = $this->GetParmalinkArray();
		
		
		$temp_select_data_array = $dbresult_obj->ItemListGet(
			$get_array[$this->item_selectID],
			$this->item_sortID_array[$get_array[$this->item_sortID]],
			$get_array[$this->item_sortdesc],
			"",
			"",
			$this->item_andor_array[$get_array[$this->item_searchandor]],
			$get_array[$this->item_searchlang],
			$this->item_searchtarget_array[$get_array[$this->item_searchcategory]]
		);
		
		$datacount = $temp_select_data_array["count"];
		$disp_tag_array = $pager_obj->DispItem($get_array[$this->item_pagingID],$datacount);

		$select_data_array = $dbresult_obj->ItemListGet(
			$get_array[$this->item_selectID],
			$this->item_sortID_array[$get_array[$this->item_sortID]],
			$get_array[$this->item_sortdesc],
			$disp_tag_array['start'],
			$this->disp_item_num,
			$this->item_andor_array[$get_array[$this->item_searchandor]],
			$get_array[$this->item_searchlang],
			$this->item_searchtarget_array[$get_array[$this->item_searchcategory]]
		);
		
		$data_tag = $this->PageItemListTag($select_data_array['data']);
		
		if($get_array[$this->item_searchlang]){
			$disp_tag_array['title'] = "検索結果:".$datacount."件";
		}else{
			$mytitle_tag = $dbresult_obj->ItemListTitleGet($get_array[$this->item_selectID]);
			$disp_tag_array['title'] = $mytitle_tag;
		}
		$disp_tag_array['item'] = $data_tag;
			
		return $disp_tag_array;
	}
	
	function PageItemListTag($data){
		
		$column_count = 1;
		
		for($i=0; $i<count($data); $i++){
			
			$price_array = $this->ItemPriceReturn($data[$i],"l");
			if($price_array['item_fixprice'] > $price_array['item_price']){
				$sale_fixprice_tag = "<p class='uc_item_fixpricearea'>参考価格：<span class='uc_item_fixpriceborder'>".number_format($price_array['item_fixprice'])."円</span></p>";
			}else{
				$sale_fixprice_tag = "";
			}
			
			$detail_slagid = get_page_by_path($this->detail_slug)->ID;
			$detail_permalink = get_permalink($detail_slagid);
			$item_detailID = $data[$i]['item_ArticleId'];
			$add_url_array = array( $this->item_detailID => $item_detailID );
			$detaillink = add_query_arg($add_url_array,$detail_permalink);
			
			
			if($column_count <= 1){
				$item_tag .= "<ul class='clearfix'>";
			}
			$item_tag .= "<li>";
			$item_tag .= "<p class='uc_item_imgarea clearfix'><a href='".$detaillink."'><img src='".$price_array['item_imgpath']."' class='uc_item_img' /></a></p>";
			
			$item_tag .= "<p class='uc_item_pricearea'>".number_format($price_array['item_price'])."円</p>";
			$item_tag .= $sale_fixprice_tag;
        	$item_tag .= "<p class='uc_item_namearea'>".$price_array['item_name']."</p>";
			
			$item_tag .= "</li>";
			
			if($this->disp_item_column <= $column_count){
				$item_tag .= "</ul>";
				$column_count = 1;
			}else{
				$column_count++;
			}
    	}
		
		return $item_tag;
	}
	
	function ItemPriceReturn($data,$imgsize){
		
		
		$return_array = array();
		
		$return_array['item_name'] = $data['item_Name'];
		$return_array['item_imgpath'] = $this->item_imgpath.$data['item_ImageCode']."/1/".$imgsize.".jpg";
		$return_array['item_minprice'] = $data['item_MinimumPrice'];
		$return_array['item_price'] = $data['item_RecommendedPrice'];
		if($this->fixprice_flag == "true"){
			$return_array['item_fixprice'] = $data['item_FixedPrice'];
		}else{
			$return_array['item_fixprice'] = 0;
		}
		if($return_array['item_fixprice'] > 0){
			$return_array['item_offpercent'] = round(100 - ($return_array['item_price']/$return_array['item_fixprice']*100));
		}else{
			$return_array['item_offpercent'] = 0;
		}
		
		return $return_array;
	}
	
	function PageItemDetail(){
		
		$dbresult_obj = new uc_MoshimoDB;
		
		$detail_tag = "";
		
		
		if($_GET[ $this->item_detailID ]){
			
			$getID = htmlspecialchars($_GET[ $this->item_detailID ]);
			$select_data_array = $dbresult_obj->ItemDetailGet($getID);
			
			
			$now_setval_array = $dbresult_obj->ConfDataGet();
			$ht_conf_apicode = $now_setval_array['conf_salecode'];
			
			if(count($select_data_array)){
				
				$this->ClickCountUp($getID);
				
				
				$sale_fixprice_tag = "";
				$price_array = $this->ItemPriceReturn($select_data_array,"l");
				if($price_array['item_fixprice'] > $price_array['item_price']){
					$sale_fixprice_tag = "<p class='uc_item_fixpricearea'>参考価格：<span class='uc_item_fixpriceborder'>".number_format($price_array['item_fixprice'])."円</span></p>";
				}
				
				$item_tag_imgpath = $price_array['item_imgpath'];
				
				$icon_photo_tag = "";
				$icon_photo_count = $select_data_array['item_ImageCount'];
				$item_tag_cartpath = $this->item_cartpath."shop_id=".$ht_conf_apicode."&article_id=".$getID;
				
				if($icon_photo_count > 0){
					for($i=1; $i<=$icon_photo_count; $i++){
						$temp_item_tag_imgpath = $this->item_imgpath.$select_data_array['item_ImageCode']."/".$i."/l.jpg";
						$icon_photo_tag .= "<li><img src='".$temp_item_tag_imgpath."' class='Itemicon' width='58' /></li>";
					}
				}
				
				$detail_tag .= "<div class='uc_itemdetail'>";
				$detail_tag .= "	<h1 class='uc_itemtitle'>".$select_data_array["item_Name"]."</h1>";
				$detail_tag .= "	<h2 class='uc_itemcatch'>".$select_data_array["item_CatchCopy"]."</h2>";
				$detail_tag .= "	<div class='uc_detailarea clearfix'>";
				
				$detail_tag .= "		<div class='uc_itemleft'>";
				$detail_tag .= "			<div class='uc_itemphoto'><img src='".$item_tag_imgpath."' alt='".$select_data_array["item_Name"]."' id='ItemViewPhoto' /></div>";
				$detail_tag .= "			<ul class='uc_itemicon clearfix'>";
				$detail_tag .= $icon_photo_tag;
				$detail_tag .= "			</ul>";
				$detail_tag .= "		</div>";
				
				$detail_tag .= "		<div class='uc_itemright'>";
				$detail_tag .= "			<div class='uc_itemright_descript'>".$select_data_array["item_Description"]."</div>";
				
				$detail_tag .= "			<div class='uc_item_pricearea'>";
				$detail_tag .= $sale_fixprice_tag;
				$detail_tag .= "				<p class='uc_item_price'>販売価格：<span class='uc_item_bicprice'>".number_format($price_array['item_price'])."</span>円</p>";
				$detail_tag .= "				<div class='uc_item_btcart'><a href='".$item_tag_cartpath."'><img src='".get_template_directory_uri()."/images/item_bt_cart.gif' alt='買い物かごに入れる' /></a></div>";
				$detail_tag .= "			</div>";
				
				$detail_tag .= "		</div>";
				
				$detail_tag .= "	</div>";
				$detail_tag .= "	<div class='uc_itemright_spec'>".$select_data_array["item_Spec"]."</div>";
				$detail_tag .= "</div>";

			}else{
				$detail_tag = false;
			}
			
			
		}else{
			$detail_tag = false;
		}
		
		return $detail_tag;
		
	}
	
	function ClickCountUp($countID){
		$today = date('Y-m-d');
		$dbresult_obj = new uc_MoshimoDB;
		$item_data_array = $dbresult_obj->ItemDetailGet($countID);
		
		if($item_data_array){
			if($item_data_array['item_ClickcountData']){
				$count_up = $item_data_array['item_Clickcount'];
				$count_flag = false;
				$new_array = array();
				$item_countdata_array = explode("|",$item_data_array['item_ClickcountData']);
				for($i=0; $i<count($item_countdata_array); $i++){
					$temp_countdata_array = array();
					$temp_countdata_array = explode("*",$item_countdata_array[$i]);
					
					if($temp_countdata_array[0] == $today){
						$temp_countdata_array[1]++;
						$count_flag = true;
					}
					
					$new_array[$temp_countdata_array[0]] = $temp_countdata_array[1];
				}
				
				if($count_flag == false){
					$new_array[$today] = 1;
				}
				
				$set_txt_array = array();
				foreach($new_array as $key=>$value){
					$set_txt_array[] = $key."*".$value;
				}
				$set_txt = implode("|",$set_txt_array);
				
			}else{
				$set_txt = $today."*1";
			}
			
			$table_set_array["item_ClickcountData"] = $set_txt;
			$table_set_array["item_Clickcount"] = $count_up + 1;
			$dbresult_obj->UpdateForID($this->table_name_item,"item_ArticleId",$countID,$table_set_array);
			
		}
		
	}
	
	function ReccomendList(){
		
		$dbresult_obj = new uc_MoshimoDB;
		$pager_obj = new Un_msm_Paging;
		
		$more_key = "item_StockStatus";
		$more_value = 0;
		$maxselect = 10;
		$select_data_array = $dbresult_obj->RecommendDataGet($this->table_name_item,$more_key,$more_value,$maxselect,$this->table_name_item_array);
		
		if(count($select_data_array) > 0){
			$disp_tag_array = $this->PageItemListTag($select_data_array);
			return $disp_tag_array;
		}else{
			return "リコメンド商品がありません";
		}
	}
	
	function Analytics(){
		
		$dbresult_obj = new uc_MoshimoDB;
		$conf_array = $dbresult_obj->ConfDataGet();
		
		if($conf_array['conf_analytics_flag'] === "true"){
			$ana_tag = "
			<script type='text/javascript'>
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '".$conf_array['conf_analytics']."']);
			_gaq.push(['_trackPageview']);
			
			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			</script>";
		}else{
			$ana_tag = "";
		}
		
		return $ana_tag;
	}

}



?>