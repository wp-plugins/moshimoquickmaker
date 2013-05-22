<?php
ini_set( 'display_errors', 1 );

require_once( UC_MSM_FUNCTIONPATH.'func_common.php');
require_once( UC_MSM_FUNCTIONPATH.'func_Judge.php');

require_once( UC_MSM_CLASSPATH.'class_DB.php');
require_once( UC_MSM_CLASSPATH.'class_XMLLoad.php');


class UcDsMoshimo{
	
	var $myplugintitle = UC_MSM_TITLE;
	var $myversion = UC_MSM_VERSION;
	var $db_option_version_name = UC_MSM_VALNAME_VERSION;
	
	var $table_name_conf = UC_MSM_TABLECONF;
	var $table_name_junle = UC_MSM_TABLEJUNLE;
	var $table_name_item = UC_MSM_TABLEITEM;
	
	var $table_name_conf_array;
	var $table_name_junle_array;
	var $table_name_item_array;
	
	var $item_slug = UC_MSM_ITEMSLUG;
	var $detail_slug = UC_MSM_DETAILSLUG;
	
	var $topimg_filename = UC_MSM_TOPIMG;
	var $topimg_dir = UC_MSM_TOPIMG_PATH;
	var $topimg_wmax = 740;
	var $topimg_hmax = 10000;
	var $topimgfix_flag = "unfix";
	
	var $img_path = UC_MSM_IMGDIR_URL;
	var $category_addmax = UC_MSM_CATEGORY_ADDMAX;
	
	function __construct(){
		
		global $wpdb;
		
		$this->table_name_conf_array = DefineArray("UC_MSM_TABLECONF_MARRAY");
		$this->table_name_junle_array = DefineArray("UC_MSM_TABLEJUNLE_MARRAY");
		$this->table_name_item_array = DefineArray("UC_MSM_TABLEITEM_MARRAY");
		$this->table_update_array = DefineArray("UC_UPDATE_RARRAY");
		add_action('admin_menu', array($this, 'add_pages'));
		add_filter('cron_schedules', array($this,'filter_cron_schedules'));
		add_action('item_update_action', array($this, 'item_update'));
		
		
	}
	
	function uc_moshimo_activationhook(){
		$this->MakePublishPage();
		$dbcleate_obj = new uc_MoshimoDB;
		$dbcleate_obj->CleateTable();
		$srcdir = dirname(__FILE__)."/../theme/quickmaker-theme01";
		$dstdir = dirname(__FILE__)."/../../../themes/quickmaker-theme01";
		DirCopy($srcdir, $dstdir);
	}
	function uc_moshimo_deactivationhook(){
		$this->DeletePublishPage();
	}
	/*
	function uc_moshimo_uninstallhook(){
		$dbcleate_obj = new uc_MoshimoDB;
		$dbcleate_obj->DeleteTable();
		$this->DeletePublishPage();
	}
	*/
	/*
	function ExtractZip(){
		$zip_path = dirname(__FILE__)."/../theme/quickmaker-theme01.zip";
		$dest_dir = dirname(__FILE__)."/../../../themes/";
		$ex_dirname = $dest_dir."quickmaker-theme01/";

		$zip = new ZipArchive();
		$res = $zip->open($zip_path);
		
		if($res === true){
			$zip->extractTo($dest_dir);
			$zip->close();
		}
		
	}
	*/
	
	
	function JSinclude(){
		$script = file_get_contents(UC_MSM_JSPATH."admin_func.js");
		$html = "<script type='text/javascript'>".$script."</script>";
		$html .= "<script src='".UC_MSM_PARENT_URL."js/uc_msm_parent.js?flag=admin'></script>";
		echo $html;
	}
	
	function MakePublishPage(){
		
		$itemlist_slagname = $this->item_slug;
		$itemlist_slagid = get_page_by_path($itemlist_slagname)->ID;
		$itemlist_slagstatus = get_page_by_path($itemlist_slagname)->post_status;
		
		if(!$itemlist_slagid){
			$my_itemlist = array(
				'post_author' => '1',
				'post_title' => 'UC_アイテムリスト',
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_name' => $itemlist_slagname,
				'post_type' => 'page',
				'post_content' => ''
			);
			wp_insert_post($my_itemlist);
		}
		
		$itemdetail_slagname = $this->detail_slug;
		$itemdetail_slagid = get_page_by_path($itemdetail_slagname)->ID;
		$itemdetail_slagstatus = get_page_by_path($itemdetail_slagname)->post_status;
		
		if(!$itemdetail_slagid){
			$my_itemdetail = array(
				'post_author' => '1',
				'post_title' => 'UC_アイテム詳細',
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_name' => $itemdetail_slagname,
				'post_type' => 'page',
				'post_content' => ''
			);
			wp_insert_post($my_itemdetail);
		}
	}
	
	function DeletePublishPage(){
		$itemlist_slagid = get_page_by_path($this->item_slug)->ID;
		wp_delete_post( $itemlist_slagid, $force_delete = true);
		$itemdetail_slagid = get_page_by_path($this->detail_slug)->ID;
		wp_delete_post( $itemdetail_slagid, $force_delete = true);
	}
	
	
	function add_pages() {
		add_menu_page('QuickMaker', 'QuickMaker', 10, UC_MSM_PLUGINPATH, array($this,'menu_toplevel_page'));
		add_submenu_page(UC_MSM_PLUGINPATH, '初期設定', '初期設定', 10, UC_MSM_PLUGINPATH, array($this,'menu_toplevel_page'));
		add_submenu_page(UC_MSM_PLUGINPATH, 'カテゴリー設定', 'カテゴリー設定', 10, 'junle-page', array($this,'menu_junle_page'));
	}
	
	function menu_toplevel_page() {
		
		$dbresult_obj = new uc_MoshimoDB;
		$css_path = UC_MSM_CSSDIR_URL.'adminlayout.css';
		wp_enqueue_style('uc_msm_css', $css_path, false, '1.0', 'all');
		
		if($_POST['posted'] == 'Y'){
			
			$error_cont = 0;
			$upload_flag = false;
			
			foreach($this->table_name_conf_array as $key=>$value){
				
				if($key == "conf_shopimg"){
					
					if(file_exists($_FILES[$key]['tmp_name'])){
						
						$upload_array = $this->UpLoadImg($_FILES[$key]);
						
						$this->{$key}['data'] = HTML_encode($upload_array['msg']);
						$this->{$key}['name'] = "";
						$this->{$key}['error'] = $upload_array['upflag'];
						
						if($this->{$key}['error'] !== true){
							$this->{$key}['error'] = $upload_array['msg'];
						}
						
						$upload_flag = true;
					}
					
				}else{
					$this->{$key}['data'] = HTML_encode($_POST[$key]);
					$this->{$key}['name'] = $value['name'];
					$this->{$key}['error'] = $value['judge']($this->{$key}['data'],$value['name']);
					if($this->{$key}['error'] !== true){
						$error_cont++;
					}
				}
				
			}
			
			
			if($error_cont <= 0){
				
				$db_set_array = array();
				foreach($this->table_name_conf_array as $key=>$value){
					if($key == "conf_shopimg"){
						if($upload_flag){
							$db_set_array[$key] = $this->{$key}['data'];
						}else{
							unset($db_set_array[$key]);
						}
					}elseif($key == "conf_shopupdate_time" || $key == "conf_shopupdate_lasttime"){
						unset($db_set_array[$key]);
					}elseif($key !== "conf_confid"){
						$db_set_array[$key] = $this->{$key}['data'];
					}
				}
				
				$update_table = $this->table_name_conf;
				$up_date_id = "conf_confid";
				$up_date_id_val = $this->conf_confid['data'];
				$update_set_array = $db_set_array;
				
				$dbresult_obj->UpdateForID($update_table,$up_date_id,$up_date_id_val,$update_set_array);
				
				$this->CronUpdate($this->{'conf_shopupdate'}['data']);
				
				$html = "<div class='updated'><p><strong>設定を保存しました</strong></p></div>";
				
			}else{
				
				$js_error = array();
				foreach($this->table_name_conf_array as $key=>$value){
					if($this->{$key}['error'] !== true){
						$js_error["error_".$key] = $this->{$key}['error'];
					}
				}
				$html = "<script type='text/javascript'>Un_msm_ErrorResult(".json_encode($js_error).")</script>";
				
			}
		}elseif($_POST['posted'] == 'K'){
			$this->item_update();
		}

		$now_setval_array = $dbresult_obj->KeyIDSearch($this->table_name_conf,"conf_confid",UC_MSM_CONFID,DefineArrayCngArray($this->table_name_conf_array));
		
		$ht_conf_apicode = HTML_decode($now_setval_array[0]['conf_apicode']);
		$ht_conf_salecode = HTML_decode($now_setval_array[0]['conf_salecode']);
		$ht_conf_pattern = HTML_decode($now_setval_array[0]['conf_pattern']);
		$ht_conf_shopname = HTML_decode($now_setval_array[0]['conf_shopname']);
		$ht_conf_shopcatch = HTML_decode($now_setval_array[0]['conf_shopcatch']);
		$ht_conf_shopdescript = HTML_decode($now_setval_array[0]['conf_shopdescript']);
		$ht_conf_shopkeyword = HTML_decode($now_setval_array[0]['conf_shopkeyword']);
		$ht_conf_shopimg = HTML_decode($now_setval_array[0]['conf_shopimg']);
		$ht_conf_shopimg_flag = HTML_decode($now_setval_array[0]['conf_shopimg_flag']);
		$ht_conf_shopimglink = HTML_decode($now_setval_array[0]['conf_shopimglink']);
		$ht_conf_shopupdate = HTML_decode($now_setval_array[0]['conf_shopupdate']);
		$ht_conf_shopupdate_time = HTML_decode($now_setval_array[0]['conf_shopupdate_time']);
		$ht_conf_shopupdate_lasttime = HTML_decode($now_setval_array[0]['conf_shopupdate_lasttime']);
		
		$ht_conf_analytics = HTML_decode($now_setval_array[0]['conf_analytics']);
		$ht_conf_analytics_flag = HTML_decode($now_setval_array[0]['conf_analytics_flag']);
		
		$img_uniq = uniqid();
		
		if($ht_conf_shopimg){
			$topimg_tag = "<img src='".$this->img_path.$ht_conf_shopimg."?id=".$img_uniq."' width='100' />";
		}else{
			$topimg_tag = "";
		}
		if($ht_conf_shopimg_flag == "true"){
			$shopimg_flag = "checked";
		}else{
			$shopimg_flag = "";
		}
		$conf_update_select = "<select name='conf_shopupdate'>";
		foreach($this->table_update_array as $key=>$value){
			if($ht_conf_shopupdate == $key){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$conf_update_select .= "<option value='".$key."' ".$selected.">".$value."</option>";
		}
		$conf_update_select .= "</select>";
		if($ht_conf_analytics_flag == "true"){
			$analytics_flag = "checked";
		}else{
			$analytics_flag = "";
		}
		if($ht_conf_shopupdate_lasttime == ""){
			$ht_conf_shopupdate_lasttime = "更新履歴なし";
		}
		
		echo $html;
		
echo <<<HERE
		<div id="uc_msm_admintop">
		<div id="icon-plugins" class="icon32"><br /></div><h2>$this->myplugintitle</h2>
		<p>プラグインバージョン: $this->myversion</p>
		<p class="update_time">前回商品更新：$ht_conf_shopupdate_lasttime</p>
		<form name="conf" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="posted" value="Y">
		<input type="hidden" name="conf_confid" value="1">
		<p>※は必須項目になります。</p>
		<table class="form-table">
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">もしもAPI認証コード ※</label></th>
			   <td>
			   <input name="conf_apicode" type="text" id="inputtext" value="$ht_conf_apicode" class="regular-text" />
			   <p><a href="https://www.moshimo.com/shop/service/api" target="_blank">※「もしも」にログイン後、もしもAPIより認証コードを入手してください。</a></p>
			   <div id="error_conf_apicode"></div>
			   </td>
			   <td rowspan="8">
			   	<div id="option_area" align="left"></div>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">もしもショップID ※</label></th>
			   <td>
			   <input name="conf_salecode" type="text" id="inputtext" value="$ht_conf_salecode" class="regular-text" />
			   <div id="error_conf_salecode"></div>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">ショップ名 ※</label></th>
			   <td>
			   <input name="conf_shopname" type="text" id="inputtext" value="$ht_conf_shopname" class="regular-text" />
			   <div id="error_conf_shopname"></div>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">ショップ説明テキスト</label></th>
			   <td>
			   <textarea name="conf_shopcatch" class="regular-textbox" >$ht_conf_shopcatch</textarea>
			   
			   <div id="error_conf_shopcatch"></div>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">HTML内ディスクリプション</label></th>
			   <td>
			   <textarea name="conf_shopdescript" class="midium-textbox" >$ht_conf_shopdescript</textarea>
			   <div id="error_conf_shopdescript"></div>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">HTML内キーワード</label></th>
			   <td>
			   <textarea name="conf_shopkeyword" class="midium-textbox" >$ht_conf_shopkeyword</textarea>
			   <p>※検索希望語句を半角「,」で区切ってください。</p>
			   <div id="error_conf_shopkeyword"></div>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">トップページ画像</label></th>
			   <td>
			   <p>$topimg_tag</p>
			   <input name="conf_shopimg" type="file" id="inputtext" class="regular-file" />
			   <p>※幅740ピクセル推奨</p>
			   <div id="error_conf_shopimg"></div>
			   <p><input type="checkbox" name="conf_shopimg_flag" value="true" $shopimg_flag /> 画像を使用する</p>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">トップページ画像リンク</label></th>
			   <td>
			   <input name="conf_shopimglink" type="text" id="inputtext" value="$ht_conf_shopimglink" class="regular-text" />
			   <p>※使用しない場合は空白</p>
			   <div id="error_conf_shopimglink"></div>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">商品自動更新間隔</label></th>
			   <td>
			   <ul class="conf_update clearfix">
			   	<li>$conf_update_select</li>
				<li><input type="button" name="Submit" onclick="Javascript:document.update.submit()" value="今すぐ商品を更新" /></li>
			   </ul>
			   <div id="error_conf_update"></div>
			   </td>
		   </tr>
		   <tr valign="top">
			   <th scope="row"><label for="inputtext">グーグルアナリティクス<br />トラッキングID</label></th>
			   <td>
			   <input name="conf_analytics" type="text" id="inputtext" value="$ht_conf_analytics" class="regular-text" />
			   <div id="error_conf_analytics"></div>
			   <p><input type="checkbox" name="conf_analytics_flag" value="true" $analytics_flag /> グーグルアナリティクスを使用する</p>
			   </td>
		   </tr>
		</table>
		<p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
		</form>	
		</div>
		<div>
		<form name="update" action="" method="post">
			<input type="hidden" name="posted" value="K">
		</form>
        </div>
		
HERE;
		$this->JSinclude();
		
	}
	
	function menu_junle_page() {
		
		$this->JSinclude();
		$dbresult_obj = new uc_MoshimoDB;
		$justifycss = "admin_category_parent";
		$css_path = UC_MSM_CSSDIR_URL.'adminlayout.css';
		wp_enqueue_style('uc_msm_css', $css_path, false, '1.0', 'all');
		
		$junle_obj = new uc_XMLLoad;
		$category_array = $junle_obj->GetCategory();
		
		if(count($category_array) > 0){
			
			if($_POST['posted'] == 'Y'){
				
				$this->LoadingStart();
				
				$now_junle_array = $dbresult_obj->SelectFieldAllData($this->table_name_junle,"junle_id");
				
				$category_ass_array = array();
				foreach($category_array as $key=>$value){
					foreach($value['data'] as $v_key=>$v_value){
						$category_ass_array[$v_value['Code']]['junle_id'] = $v_value['Code'];
						$category_ass_array[$v_value['Code']]['junle_name'] = $v_value['Name'];
						$category_ass_array[$v_value['Code']]['junle_parentid'] = $key;
						$category_ass_array[$v_value['Code']]['junle_parentname'] = $value['parentname'];
					}
				}
				
				$select_category_array = $_POST['category'];
				
				if(count($select_category_array) > 0 && count($select_category_array) <= $this->category_addmax){
					
					
					
					$new_array = array_diff($select_category_array,$now_junle_array);
					$del_array = array_diff($now_junle_array,$select_category_array);
					
					$add_new_array = array();
					foreach($new_array as $key=>$value){
						if(array_key_exists($value,$category_ass_array)){
							$add_new_array[$value] = $category_ass_array[$value];
						}
					}
					
					$error_array = $junle_obj->NewItemUpdate($new_array);
					
					
					if(count($error_array) <= 0){
						
						$junle_obj->ItemUpdateDelete($del_array);
						foreach($add_new_array as $key=>$value){
							$dbresult_obj->InsertData($this->table_name_junle,$value);
						}
						foreach($del_array as $key=>$value){
							$dbresult_obj->KeyIDDelete($this->table_name_junle,"junle_id",$value);
						}
						
						$html = "<div class='updated'><p><strong>設定を保存しました</strong></p></div>";
					}else{
						$html = "<div class='updated'><p><strong>更新できない項目があったため処理を中止しました。</strong></p></div>";
					}
					
					$this->LoadingEnd();
					
				}else{
					
					$html = "<div class='updated'><p><strong>最低でも１個以上、".$this->category_addmax."個未満のカテゴリーを選択して下さい。</strong></p></div>";
				}
				
			}
			
			$now_junle_array = $dbresult_obj->SelectFieldAllData($this->table_name_junle,"junle_id");
			$category_tag = $junle_obj->CategoryAdminHtml($category_array,$now_junle_array);

echo $html;

echo <<<HERE
	
	<div id="uc_msm_admincategory">
	<h2>カテゴリー設定</h2>
	<p>※もしものデータ制限の関係で選択できる数を $this->category_addmax 個に制限しています。</p>
	<form action="" method="post" name="uc_msm_category">
	<input type="hidden" name="posted" value="Y">
	$category_tag
	<p class="submit"><input type="submit" name="Submit" class="button-primary" value="カテゴリーを設定" /></p>
	<p class="error">※設定ボタンを押した後、データベースに保存するには時間がかかります。保存が完了したメッセージが出るまでお待ち下さい。</p>
	</form>
	</div>
	
HERE;

		}else{
			
echo <<<HERE
	
	<div id="uc_msm_admincategory">
	<h2>カテゴリー設定</h2>
	<p>カテゴリーが取得できません。Authorizationコードが間違っている可能性があります。</p>
	
HERE;
			
		}

	}
	
	function LoadingStart(){
		if(ob_get_level()==0) ob_start();
		ob_flush();
        flush();
	}
	
	function LoadingEnd(){
	}
	
	function UpLoadImg($files){
		
		$install_flag = GDInstall();
			
		if($install_flag == true){
			require_once( UC_MSM_FUNCTIONPATH.'func_image.php');
			$upload_array = UpLoadImg($files,$this->topimg_filename,$this->topimg_dir,$this->topimg_wmax,$this->topimg_hmax,$this->topimgfix_flag);
		}else{
			
		}
		return $upload_array;
	}
	
	
	function item_update(){
		
		$xml_obj = new uc_XMLLoad;
		$xml_obj->ItemUpdate();
		
		date_default_timezone_set('Asia/Tokyo');
		$dbresult_obj = new uc_MoshimoDB;
		$update_table = $this->table_name_conf;
		$up_date_id = "conf_confid";
		$up_date_id_val = "1";
		$update_set_array["conf_shopupdate_lasttime"] = date("Y-m-d H:i:s");

		$dbresult_obj->UpdateForID($update_table,$up_date_id,$up_date_id_val,$update_set_array);

	}
	
	function CronUpdate($settime){
		if($settime !== "noupdate"){
			date_default_timezone_set('Asia/Tokyo');
			$tomorrow = date("Y-m-d", strtotime("+1 day"));
			$random = sprintf("%02d",rand(0,7));
			$utc_stamp_day = $tomorrow." ".$random.":00:00";
			$stamp_day = strtotime($utc_stamp_day);
			
			wp_schedule_event( $stamp_day, $settime, 'item_update_action');
			
			$dbresult_obj = new uc_MoshimoDB;
			$update_table = $this->table_name_conf;
			$up_date_id = "conf_confid";
			$up_date_id_val = "1";
			$update_set_array["conf_shopupdate_time"] = $utc_stamp_day;
	
			$dbresult_obj->UpdateForID($update_table,$up_date_id,$up_date_id_val,$update_set_array);
		}
	}
	
	function filter_cron_schedules( $schedules ) {
		
		$schedules['2day'] = array(
			'interval' => (86400*2),
			'display' => __('2day')
		); 
		
		$schedules['3day'] = array(
			'interval' => (86400*3),
			'display' => __('3day')
		);  
		
		$schedules['1week'] = array(
			'interval' => (86400*7),
			'display' => __('1week')
		);  
		
		$schedules['2week'] = array(
			'interval' => (86400*14),
			'display' => __('2week')
		);  
		
		$schedules['1month'] = array(
			'interval' => (86400*30),
			'display' => __('1month')
		);  
		return $schedules;
	}

}

?>