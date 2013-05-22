<?php

class uc_MoshimoDB{
	var $myversion = UC_MSM_VERSION;
	var $db_option_version_name = UC_MSM_VALNAME_VERSION;
	var $installed_ver;
	var $install_flag_name = UC_MSM_VALNAME_INSTALLFLAG;
	var $install_flag;
	
	var $table_name_conf = UC_MSM_TABLECONF;
	var $table_name_junle = UC_MSM_TABLEJUNLE;
	var $table_name_item = UC_MSM_TABLEITEM;
	
	var $table_name_conf_array;
	var $table_name_junle_array;
	var $table_name_item_array;
	
	function __construct(){
		$this->installed_ver = get_option( $this->db_option_version_name );
		$this->install_flag = get_option( $this->install_flag_name );
		
		$this->table_name_conf_array = DefineArray("UC_MSM_TABLECONF_MARRAY");
		$this->table_name_junle_array = DefineArray("UC_ITEMJUNLE_ARRAY");
		$this->table_name_item_array = DefineArray("UC_ITEMDB_ARRAY");
	}
	
	function CleateTable(){
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		global $wpdb;
		
      	$is_dbconf_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $this->table_name_conf));
		if(!$is_dbconf_exists){
			
			$temp_random_time = rand(0,7);
			$random_time = sprintf("%02d",$temp_random_time) + ":00";
			
			$sql = "CREATE TABLE " . $this->table_name_conf . " (
			  conf_confid int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			  conf_salecode varchar(50) NOT NULL,
			  conf_apicode varchar(50) NOT NULL,
			  conf_pattern varchar(20) NOT NULL,
			  conf_shopname text NOT NULL,
			  conf_shopcatch text NOT NULL,
			  conf_shopdescript text NOT NULL,
			  conf_shopkeyword text NOT NULL,
			  conf_shopimg varchar(50) NOT NULL,
			  conf_shopimg_flag varchar(20) NOT NULL,
			  conf_shopimglink text NOT NULL,
			  conf_shopupdate varchar(20) NOT NULL,
			  conf_shopupdate_time DATETIME NOT NULL,
			  conf_shopupdate_lasttime DATETIME NOT NULL,
			  conf_analytics text NOT NULL,
			  conf_analytics_flag varchar(20) NOT NULL,
			  UNIQUE KEY conf_confid (conf_confid)
			) CHARACTER SET 'utf8';";
			
			$sql .= "INSERT INTO ".$this->table_name_conf."(conf_salecode,conf_apicode,conf_pattern,conf_shopname,conf_shopcatch,conf_shopdescript,conf_shopkeyword,conf_shopimg,conf_shopimg_flag,conf_shopimglink,conf_shopupdate,conf_shopupdate_time,conf_analytics,conf_analytics_flag) VALUES('','','".UC_MSM_CONFID."','MyShop','説明','','','".UC_MSM_TOPIMG.".jpg','true','','1','".$random_time."','','false');";
		
		}
		
		$is_dbjunle_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $this->table_name_junle));
		if(!$is_dbjunle_exists){
			$sql .= "CREATE TABLE " . $this->table_name_junle . " (
			  junle_id text NOT NULL,
			  junle_name text NOT NULL,
			  junle_parentid text NOT NULL,
			  junle_parentname text NOT NULL,
			  junle_item longtext NOT NULL,
			  junle_titleimg text NOT NULL,
			  junle_titletxt text NOT NULL
			) CHARACTER SET 'utf8';";
		}
		
		$is_dbitem_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $this->table_name_item));
		if(!$is_dbitem_exists){
			$sql .= "CREATE TABLE " . $this->table_name_item . " (
			  item_ArticleId int(20) NOT NULL,
			  item_Name text NOT NULL,
			  item_Description longtext NOT NULL,
			  item_SpecialDescription text NOT NULL,
			  item_Spec longtext NOT NULL,
			  item_CatchCopy text NOT NULL,
			  item_MakerName text NOT NULL,
			  item_ModelNumber varchar(20) NOT NULL,
			  item_Tags text NOT NULL,
			  item_IsNewly int(10) NOT NULL,
			  item_HeavySeller int(10) NOT NULL,
			  item_IsDeliverySameday int(10) NOT NULL,
			  item_IsFreeShipping int(10) NOT NULL,
			  item_DodFrom int(10) NOT NULL,
			  item_DodTo int(10) NOT NULL,
			  item_PreorderFlag int(10) NOT NULL,
			  item_PreorderPeriod text NOT NULL,
			  item_Category_Code int(10) NOT NULL,
			  item_Category_Name text NOT NULL,
			  item_Category_Level int(10) NOT NULL,
			  item_Category_Parents text NOT NULL,
			  item_GroupId varchar(20) NOT NULL,
			  item_ImageCode varchar(30) NOT NULL,
			  item_ImageCount int(10) NOT NULL,
			  item_JanCode varchar(20) NOT NULL,
			  item_PaymentType int(10) NOT NULL,
			  item_BundleImpossible int(10) NOT NULL,
			  item_StartDate DATETIME NOT NULL,
			  item_HasMaterial int(10) NOT NULL,
			  item_FixedPrice int(20) NOT NULL,
			  item_DefaultProfitPrice int(20) NOT NULL,
			  item_DefaultProfitRate int(20) NOT NULL,
			  item_RecommendedPrice int(20) NOT NULL,
			  item_MinimumPrice int(20) NOT NULL,
			  item_WholesalePrice int(20) NOT NULL,
			  item_ShopPrice int(20) NOT NULL,
			  item_StockStatus int(10) NOT NULL,
			  item_StockStatusWord text NOT NULL,
			  item_MyParentGroupId varchar(20) NOT NULL,
			  item_MyChildGroupId varchar(20) NOT NULL,
			  item_InsertDate DATETIME NOT NULL,
			  item_Clickcount int(10) NOT NULL,
			  item_ClickcountData longtext NOT NULL
			) CHARACTER SET 'utf8';";
		}
		
		if($sql){
			dbDelta($sql);
		}
		
		if( $this->installed_ver < $this->myversion ){
		}
		
		update_option($this->db_option_version_name, $this->myversion);
		update_option($this->install_flag_name, "true");
			
	}
	
	function DeleteTable(){
		
		global $wpdb;
		
		$sql = "DROP TABLE IF EXISTS ".$this->table_name_conf.";";
		$sql .= "DROP TABLE IF EXISTS ".$this->table_name_junle.";";
		$sql .= "DROP TABLE IF EXISTS ".$this->table_name_item.";";
		$wpdb->query($sql);
		
		delete_option($this->db_option_version_name);
		delete_option($this->install_flag_name);
		
	}
	
	function ConfDataGet(){
		
		$return_array = array();
		
		$now_setval_array = $this->KeyIDSearch($this->table_name_conf,"conf_confid",UC_MSM_CONFID,DefineArrayCngArray($this->table_name_conf_array));
		
		$return_array['conf_apicode'] = HTML_decode($now_setval_array[0]['conf_apicode']);
		$return_array['conf_salecode'] = HTML_decode($now_setval_array[0]['conf_salecode']);
		$return_array['conf_pattern'] = HTML_decode($now_setval_array[0]['conf_pattern']);
		$return_array['conf_shopname'] = HTML_decode($now_setval_array[0]['conf_shopname']);
		$return_array['conf_shopcatch'] = HTML_decode($now_setval_array[0]['conf_shopcatch']);
		$return_array['conf_shopdescript'] = HTML_decode($now_setval_array[0]['conf_shopdescript']);
		$return_array['conf_shopkeyword'] = HTML_decode($now_setval_array[0]['conf_shopkeyword']);
		$return_array['conf_shopimg'] = HTML_decode($now_setval_array[0]['conf_shopimg']);
		$return_array['conf_shopimg_flag'] = HTML_decode($now_setval_array[0]['conf_shopimg_flag']);
		$return_array['conf_shopimglink'] = HTML_decode($now_setval_array[0]['conf_shopimglink']);
		$return_array['conf_shopbackup'] = HTML_decode($now_setval_array[0]['conf_shopbackup']);
		$return_array['conf_shopbackup_time'] = HTML_decode($now_setval_array[0]['conf_shopbackup_time']);
		$return_array['conf_shopbackup_lasttime'] = HTML_decode($now_setval_array[0]['conf_shopbackup_lasttime']);
		$return_array['conf_analytics'] = HTML_decode($now_setval_array[0]['conf_analytics']);
		$return_array['conf_analytics_flag'] = HTML_decode($now_setval_array[0]['conf_analytics_flag']);
		
		
		return $return_array;
	}
	
	function ItemListGet($getID,$sort,$desc,$start_limit,$limit,$aoro,$searchlang,$search_category){
		
		$table_name = $this->table_name_item;
		$request_field_array = $this->table_name_item_array;
		if($getID && $search_category == 'nowcategory'){
			$search_key = "item_MyChildGroupId";
			$search_key_value = $getID;
			$andlang_array[] = $search_key."='".$getID."'";
		}else{
			$andlang_array = "";
		}
		
		$select_data_array = $this->LikeAllSearch($table_name,$request_field_array,$request_field_array,$searchlang,$sort,$desc,$start_limit,$limit,$aoro,$andlang_array);
		
		return $select_data_array;
	}
	
	
	function ItemListTitleGet($getID){
		$mytitle_tag = "";
		$title_table_name = $this->table_name_junle;
		$title_search_key = "junle_id";
		$title_search_key_value = $getID;
		$title_request_field_array = $this->table_name_junle_array;
		
		$select_title_array = $this->KeyIDSearch($title_table_name,$title_search_key,$title_search_key_value,$title_request_field_array);
		
		if(count($select_title_array) > 0){
			$parent_title = $select_title_array[0]["junle_parentname"];
			$junle_title = $select_title_array[0]["junle_name"];
			$mytitle_tag .= $parent_title."/".$junle_title;
		}
		
		return $mytitle_tag;
	}
	
	function ItemDetailGet($getID){
		
		$table_name = $this->table_name_item;
		$search_key = "item_ArticleId";
		$search_key_value = $getID;
		$request_field_array = $this->table_name_item_array;
		
		$select_data_array_temp = $this->KeyIDSearch($table_name,$search_key,$search_key_value,$request_field_array);
		$select_data_array = $select_data_array_temp[0];
		
		return $select_data_array;
	}
	
	function RecommendDataGet($tablename,$more_key,$more_value,$maxselect,$request_field_array){
		
		global $wpdb;
		
		$sql = "SELECT * FROM ".$tablename." WHERE ".$more_key." > " .$more_value. " ORDER BY item_Clickcount DESC LIMIT ".$maxselect;
		$sql_result = $wpdb->get_results($sql);
		
		$count = 0;
		foreach($sql_result as $value){
			foreach($request_field_array as $r_value){
				$return_array[$count][$r_value] = $value->{$r_value};
			}
			$count++;
		}
		
		return $return_array;
		
	}
	
	function InsertData($tablename,$table_set_array){
		
		global $wpdb;
		
		$key_array = array();
		$value_array = array();
		foreach($table_set_array as $key=>$value){
			$key_array[] = $key;
			$value_array[] = $value;
		}
		
		$sql = "INSERT INTO ".$tablename."(".implode(',',$key_array).") VALUES('".implode("','",$value_array)."')";
		$sql_result = $wpdb->get_results($sql);
		
		return $sql_result;
		
	}
	
	function KeyIDSearch($table_name,$search_key,$search_key_value,$request_field_array){
		
		global $wpdb;
		
		$sql = "SELECT * FROM ".$table_name." WHERE ".$search_key." = '" .$search_key_value. "'";
		$sql_result = $wpdb->get_results($sql);
		
		$count = 0;
		foreach($sql_result as $value){
			foreach($request_field_array as $r_value){
				$return_array[$count][$r_value] = $value->{$r_value};
			}
			$count++;
		}
		
		return $return_array;
	}
	
	function KeyIDSearchSort($table_name,$search_key,$search_key_value,$request_field_array,$sort,$desc){
		
		global $wpdb;
		
		if($search_key && $search_key_value){
			$sql = "SELECT * FROM ".$table_name." WHERE ".$search_key." = '" .$search_key_value. "'";
		}
		
		if($sort){
			$sql .= " ORDER BY ".$sort;	
		}
		if($sort && $desc == "desc"){
			$sql .= " DESC";
		}
	
		$sql_result = $wpdb->get_results($sql);
		
		$count = 0;
		foreach($sql_result as $value){
			foreach($request_field_array as $r_value){
				$return_array[$count][$r_value] = $value->{$r_value};
			}
			$count++;
		}
		
		return $return_array;
	}
	
	function LikeAllSearch($tablename,$tablearray,$table_search_array,$searchlang,$sort,$desc,$start_limit,$limit,$aoro,$andlang_array/*,$pager_flag*/){
		
		global $wpdb;
		
	
		
		$where = '';
		
		if(isset($searchlang)){
			
			if(!$aoro){
				$aoro = "OR";
			}
			
			if($searchlang !== ""){
				
				$keywords_array = SpaceArray($searchlang);	
				
				$andcomment = array();
				for($j=0; $j<count($keywords_array); $j++){
					
					$or_array = array();
					for($k=0; $k<count($table_search_array); $k++){
						$or_array[$k] = $table_search_array[$k]." LIKE '%".addsl($keywords_array[$j])."%'";
					}
	
					$andcomment[$j] = "(".implode(" OR ",$or_array).")";
					
				}
		
				$like = implode($aoro,$andcomment);
				
				$where .= "WHERE (".$like.")";
			}
		
			if(count($andlang_array) > 0 && $andlang_array !== ""){
				
				for($j=0; $j<count($andlang_array); $j++){
					$and_array[] = $andlang_array[$j];
				}
				$and = implode(" AND ",$and_array);
				
				if(!$searchlang){
					$where .= "WHERE (".$and.")";
				}else{
					$where .= " AND (".$and.")";
				}
			}
			
			$sql_max = "SELECT COUNT(*) FROM ".$tablename." ".$where.";";
			$data_max_num = $wpdb->get_var($sql_max);
			
			
			if($sort){
				$where .= " ORDER BY ".$sort;	
			}
			
			if($sort && $desc == "desc"){
				$where .= " DESC";	
			}
			
			$sql_csv = "SELECT * FROM ".$tablename." ".$where;
			
			if($start_limit !== "" && $limit !== ""){
				$where .= " LIMIT ".$start_limit." , ".$limit;
			}
	
			$sql = "SELECT * FROM ".$tablename." ".$where;
			
			$sql_result = $wpdb->get_results($sql);
			$count = 0;
			foreach($sql_result as $value){
				foreach($tablearray as $r_value){
					$data[$count][$r_value] = $value->{$r_value};
				}
				$count++;
			}
			
			return array("data"=>$data,"count"=>$data_max_num);
			
		}else{
			
			return false;
			
		}
		
	}
	
	
	function UpdateForID($table_name,$table_ID,$table_ID_value,$table_set_array){
		
		global $wpdb;
		
		$set_txt_array = array();
		foreach($table_set_array as $key=>$value){
			$set_txt_array[] = $key."='".$value."'";
		}
		$set_value = implode(",",$set_txt_array);
		
		$sql = "UPDATE ".$table_name." SET ".$set_value." WHERE ".$table_ID." = '".$table_ID_value."'";
		$sql_result = $wpdb->get_results($sql);
	
		return $sql_result;
	
	}
	
	function UpdateCountUpForID($table_name,$table_ID,$table_ID_value,$table_set_array,$countup_flag){
		
		global $wpdb;
		
		switch($countup_flag){
			case 'minus':
				$count_num = "-";
				break;
			default:
				$count_num = "+";
				break;
		}
		
		$set_txt_array = array();
		foreach($table_set_array as $value){
			$set_txt_array[] = $value." = ".$value." ".$count_num." 1 ";
		}
		$set_value = implode(",",$set_txt_array);
		
		$sql = "UPDATE ".$table_name." SET ".$set_value." WHERE ".$table_ID." = '".$table_ID_value."'";
		$sql_result = $wpdb->get_results($sql);
		
		return $sql_result;
	
	}
	
	function SelectFieldAllData($table_name,$request_field){
	
		global $wpdb;
		
		$sql = "SELECT ".$request_field." FROM ".$table_name;
		$sql_result = $wpdb->get_results($sql);
		
		$return_array = array();
		foreach($sql_result as $key=>$value){
			$return_array[] = $value->{$request_field};
		}
		
		return $return_array;
	}
	
	function SelectFieldAllDataArray($table_name,$request_field_array){
	
		global $wpdb;
		
		$requestfield = implode(",",$request_field_array);
		$sql = "SELECT ".$requestfield." FROM ".$table_name;
		$sql_result = $wpdb->get_results($sql);
		
		$return_array = array();
		$count = 0;
		foreach($sql_result as $key=>$value){
			foreach($request_field_array as $r_key=>$r_value){
				$return_array[$count][$r_value] = $value->{$r_value};
			}
			$count++;
		}
		
		return $return_array;
	}

	function KeyIDDelete($table_name,$search_key,$search_key_value){
		
		global $wpdb;
		
		$sql = "DELETE FROM ".$table_name." WHERE ".$search_key." = '".$search_key_value."'";
		$sql_result = $wpdb->get_results($sql);
		
		
		return $sql_result;
		
	}
	
	


}




?>