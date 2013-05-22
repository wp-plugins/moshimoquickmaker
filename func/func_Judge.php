<?php


/*
$ATTACK_LANG = "[,|'|\"|<|>|%|#|!|&|\$|\\|\n|\t|\.|:|;]|script|SCRIPT|javascript|JAVASCRIPT|where|WHERE|select|SELECT|_session|_SESSION|_cookie|_COOKIE|_server|_SERVER|_env|_ENV|_files|_FILES|_post|_POST|_get|_GET|_globals|_GLOBALS";
&quot;ダブル
&#039;シングル
*/

$ATTACK_LANG = "delete|DELETE|javascript|JAVASCRIPT|_session|_SESSION|_cookie|_COOKIE|_server|_SERVER|_env|_ENV|_files|_FILES|_post|_POST|_get|_GET|_globals|_GLOBALS";

$ATTACK_LANG_HTML = "delete|DELETE|javascript|JAVASCRIPT|_session|_SESSION|_cookie|_COOKIE|_server|_SERVER|_env|_ENV|_files|_FILES|_post|_POST|_get|_GET|_globals|_GLOBALS";

$KEN_LANG = "北海道|青森県|岩手県|宮城県|秋田県|山形県|福島県|茨城県|栃木県|群馬県|埼玉県|千葉県|東京都|神奈川県|新潟県|富山県|石川県|福井県|山梨県|長野県|岐阜県|静岡県|愛知県|三重県|滋賀県|京都府|大阪府|兵庫県|奈良県|和歌山県|鳥取県|島根県|岡山県|広島県|山口県|徳島県|香川県|愛媛県|高知県|福岡県|佐賀県|長崎県|熊本県|大分県|宮崎県|鹿児島県|沖縄県";

function valid_input($valid_rev,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}else{
		return true;
	}
}

function valid_input_if($valid_rev,$void_lang){
	
	if($valid_rev){
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_limitnum($valid_rev,$limitnum,$langcode,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(mb_strlen($valid_rev,$langcode) > $limitnum){
		return $void_lang."が制限文字数を超えています -- ";
	}else{
		return true;
	}
}

function valid_input_limitnum_if($valid_rev,$limitnum,$langcode,$void_lang){
	
	if($valid_rev){
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(mb_strlen($valid_rev,$langcode) > $limitnum){
			return $void_lang."が制限文字数を超えています -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_twitter($valid_rev,$void_lang){
	
		if(!$valid_rev){
			return $void_lang."が入力されていません -- ";
		}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[0-9a-z_]{1,15}$/i", $valid_rev)){
			return $void_lang."は正しいアカウントではありません -- ";
		}else{
			return true;
		}
	
}

function valid_input_html($valid_rev,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG_HTML"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}else{
		return true;
	}
}

function valid_input_html_if($valid_rev,$void_lang){
	
	if($valid_rev){
		if(ereg($GLOBALS["ATTACK_LANG_HTML"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
	
}

function valid_input_kana($valid_rev,$void_lang){

	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"],$valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[ァ-ヴー（）　]+$/u", $valid_rev)){
		return $void_lang."は全角カタカナで入力してください。 -- ";
	}else{
		return true;
	}
}

function valid_input_kana_if($valid_rev,$void_lang){
	if($valid_rev){
		if(!$valid_rev){
			return $void_lang."が入力されていません -- ";
		}elseif(ereg($GLOBALS["ATTACK_LANG"],$valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[ァ-ヴー（）　]+$/u", $valid_rev)){
			return $void_lang."は全角カタカナで入力してください。 -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}



function valid_input_numkana($valid_rev,$void_lang){

	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"],$valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[ァ-ヴー（）　]+$/u", $valid_rev)){
		return $void_lang."は全角カタカナで入力してください。 -- ";
	}else{
		return true;
	}
}

function valid_input_num($valid_rev,$void_lang){
	
	if($valid_rev == ""){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
		return $void_lang."は半角数字のみで入力してください。 -- ";
	}else{
		return true;
	}
}

function valid_input_num_if($valid_rev,$void_lang){
	
	if($valid_rev !== ""){		
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
			return $void_lang."は半角数字のみで入力してください。 -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_numketa($valid_rev,$keta,$void_lang){
	
	if(!$valid_rev || $valid_rev == "-"){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
		return $void_lang."は半角数字のみで入力してください。 -- ";
	}elseif(strlen($valid_rev) !== $keta){
		return $void_lang."は".$keta."桁で入力してください。 -- ";
	}else{
		return true;
	}
}


function valid_input_en($valid_rev,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[a-zA-Z()-_\s,.!]+$/", $valid_rev)){
		return $void_lang."はローマ字で入力してください。 -- ";
	}else{
		return true;
	}
}

function valid_input_en_if($valid_rev,$void_lang){
	
	if($valid_rev){
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[a-zA-Z()-_\s,.!]+$/", $valid_rev)){
			return $void_lang."はローマ字で入力してください。 -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_numen($valid_rev,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[a-zA-Z0-9()-_\s,.!]+$/", $valid_rev)){
		return $void_lang."は半角英数字で入力してください。 -- ";
	}else{
		return true;
	}
}

function valid_input_numen_if($valid_rev,$void_lang){
	
	if($valid_rev){
		
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[a-zA-Z0-9()-_\s,.!&quot;&#039;]+$/", $valid_rev)){
			return $void_lang."は半角英数字で入力してください。 -- ";
		}else{
			return true;
		}
		
	}else{
		return true;
	}
}

function valid_input_numen_limitnum($valid_rev,$limitnum,$langcode,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[a-zA-Z0-9()-_\s,.!&quot;&#039;]+$/", $valid_rev)){
		return $void_lang."は半角英数字で入力してください。 -- ";
	}elseif(mb_strlen($valid_rev,$langcode) > $limitnum){
		return $void_lang."が制限文字数を超えています -- ";
	}else{
		return true;
	}
}

function valid_input_numen_limitnum_if($valid_rev,$limitnum,$langcode,$void_lang){
	
	if($valid_rev){		
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[a-zA-Z0-9()-_\s,.!&quot;&#039;]+$/", $valid_rev)){
			return $void_lang."は半角英数字で入力してください。 -- ";
		}elseif(mb_strlen($valid_rev,$langcode) > $limitnum){
			return $void_lang."が制限文字数を超えています -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_numen_limitnum_minmax($valid_rev,$minnum,$maxnum,$langcode,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[a-zA-Z0-9()-_\s,.!&quot;&#039;]+$/", $valid_rev)){
		return $void_lang."は半角英数字で入力してください。 -- ";
	}elseif(mb_strlen($valid_rev,$langcode) > $maxnum){
		return $void_lang."が制限文字数を超えています -- ";
	}elseif(mb_strlen($valid_rev,$langcode) < $minnum){
		return $void_lang."が最低制限文字数を超えていません -- ";
	}else{
		return true;
	}
}

function valid_password_input_numen($valid_rev1,$valid_rev2,$void_lang){
	
	if(!$valid_rev1 || !$valid_rev2){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev1)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[a-zA-Z0-9()-_\s,.!]+$/", $valid_rev1)){
		return $void_lang."は半角英数字で入力してください。 -- ";
	}elseif($valid_rev1 !== $valid_rev2){
		return $void_lang."が再入力と異なります。 -- ";
	}else{
		return true;
	}
}

function valid_password_inputlimit_numen($valid_rev1,$valid_rev2,$limitnum,$langcode,$void_lang){
	
	if(!$valid_rev1 || !$valid_rev2){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev1)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[a-zA-Z0-9()-_\s,.!]+$/", $valid_rev1)){
		return $void_lang."は半角英数字で入力してください。 -- ";
	}elseif(mb_strlen($valid_rev1,$langcode) > $limitnum){
		return $void_lang."が制限文字数を超えています -- ";
	}elseif($valid_rev1 !== $valid_rev2){
		return $void_lang."が再入力と異なります。 -- ";
	}else{
		return true;
	}
}


function valid_input_address($valid_rev,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(ereg($GLOBALS["KEN_LANG"], $valid_rev)){
		return $void_lang."に都道府県が入力されています -- ";
	}else{
		return true;
	}
}

function valid_input_address_if($valid_rev,$void_lang){
	
	if($valid_rev){
		if(!$valid_rev){
			return $void_lang."が入力されていません -- ";
		}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(ereg($GLOBALS["KEN_LANG"], $valid_rev)){
			return $void_lang."に都道府県が入力されています -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_zip($valid_rev,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
		return $void_lang."は半角数字のみで入力してください。 -- ";
	}elseif(strlen($valid_rev) != 7){
		return $void_lang."は７桁で入力してください。 -- ";
	}else{
		return true;
	}
}

function valid_input_zip_if($valid_rev,$void_lang){
	if($valid_rev){
		if(!$valid_rev){
			return $void_lang."が入力されていません -- ";
		}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
			return $void_lang."は半角数字のみで入力してください。 -- ";
		}elseif(strlen($valid_rev) != 7){
			return $void_lang."は７桁で入力してください。 -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_tel_if($valid_rev,$void_lang){
	
	if($valid_rev){
		
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
			return $void_lang."は半角数字で入力してください。 -- ";
		}elseif(strlen($valid_rev) != 10 && strlen($valid_rev) != 11){
			return $void_lang."が正しくない可能性があります。 -- ";
		}else{
			return true;
		}
		
	}else{
		return true;
	}
	
}

function valid_input_tel($valid_rev,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
		return $void_lang."は半角数字で入力してください。 -- ";
	}elseif(strlen($valid_rev) != 10 && strlen($valid_rev) != 11){
		return $void_lang."が正しくない可能性があります。 -- ";
	}else{
		return true;
	}
	
}

function valid_input_date($valid_rev,$void_lang){
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
		
	}elseif(!preg_match("/^[0-9-]+$/", $valid_rev)){
		return $void_lang."は半角数字と-(ハイフン)で入力してください -- ";
	}else{
		$date_array = explode("-",$valid_rev);
		if(strlen($date_array[0]) == 4 && strlen($date_array[1]) == 2 && strlen($date_array[2]) == 2){
			if($date_array[0] >= 2010 && $date_array[0] <= 2050 && $date_array[1] <= 12 && $date_array[2] <= 31){
				return true;
			}else{
				return $void_lang."は適正の日付が入力されていません -- ";
			}
		}else{
			return $void_lang."は適正の日付が入力されていません -- ";
		}
	}
	
}

function valid_input_datetime($valid_rev,$void_lang){
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(!preg_match("/^[0-9-\:\s]+$/", $valid_rev)){
		return $void_lang."は半角数字と-(ハイフン)と:(コロン)で入力してください -- ";
	}else{
		
		$tmp_array = explode(" ",$valid_rev);
		$date_array = explode("-",$tmp_array[0]);
		$time_array = explode(":",$tmp_array[1]);
		
		if(strlen($date_array[0]) == 4 && strlen($date_array[1]) == 2 && strlen($date_array[2]) == 2 && strlen($time_array[0]) == 2 && strlen($time_array[1]) == 2){
			if($date_array[0] >= 2010 && $date_array[0] <= 2050 && $date_array[1] <= 12 && $date_array[2] <= 31 && $time_array[0] <= 24 && $time_array[1] <= 60){
				return true;
			}else{
				return $void_lang."は適正の日付が入力されていません -- ";
			}
		}else{
			return $void_lang."は適正の日付が入力されていません -- ";
		}
		
	}
	
}

function valid_input_datetime_if($valid_rev,$void_lang){
	if($valid_rev){
		if(!preg_match("/^[0-9-\:\s]+$/", $valid_rev)){
			return $void_lang."は半角数字と-(ハイフン)と:(コロン)で入力してください -- ";
		}else{
			
			$tmp_array = explode(" ",$valid_rev);
			$date_array = explode("-",$tmp_array[0]);
			$time_array = explode(":",$tmp_array[1]);
			
			if(strlen($date_array[0]) == 4 && strlen($date_array[1]) == 2 && strlen($date_array[2]) == 2 && strlen($time_array[0]) == 2 && strlen($time_array[1]) == 2){
				if($date_array[0] >= 2010 && $date_array[0] <= 2050 && $date_array[1] <= 12 && $date_array[2] <= 31 && $time_array[0] <= 24 && $time_array[1] <= 60){
					return true;
				}else{
					return $void_lang."は適正の日付が入力されていません -- ";
				}
			}else{
				return $void_lang."は適正の日付が入力されていません -- ";
			}
			
		}
	}else{
		return true;
	}
	
}

function DateTimeCheck($datearray,$msglang){
	$checkcount = 0;
	$returnmsg = array();

	for($i=0; $i<count($datearray); $i++){
		$datecheck = valid_input_datetime($datearray[$i],$msglang);
		$datecheck == 1 ? $checkcount++ : $returnmsg[] = $datecheck;
		$datename = "msgdate".$i;
		$$datename = str_replace(" ","",$datearray[$i]);
		$$datename = str_replace("-","",$$datename);
		$$datename = str_replace(":","",$$datename);
	}
	if(count($returnmsg) > 0){
		$retrun = $returnmsg[0];
	}else{
		$msgdate0 <= $msgdate1 ? $retrun = true : $retrun = $msglang."の開始日が終了日よりも古いです -- ";
	}
	
	return $retrun;
}

function DateCheck($datearray,$msglang){
	$checkcount = 0;
	$returnmsg = array();

	for($i=0; $i<count($datearray); $i++){
		$datecheck = valid_input_date($datearray[$i],$msglang);
		$datecheck == 1 ? $checkcount++ : $returnmsg[] = $datecheck;
		$datename = "msgdate".$i;
		$$datename = str_replace("-","",$datearray[$i]);
	
	}
	if(count($returnmsg) > 0){
		$retrun = $returnmsg[0];
	}else{
		$msgdate0 <= $msgdate1 ? $retrun = true : $retrun = $msglang."の開始日が終了日よりも古いです -- ";
	}
	
	return $retrun;
}

function valid_input_hour($valid_rev,$void_lang){
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
		return $void_lang."は半角数字で入力してください。 -- ";
	}elseif($valid_rev > 24 && $valid_rev < 0){
		return $void_lang."が正しくない可能性があります。 -- ";
	}else{
		return true;
	}
}

function valid_input_hour_if($valid_rev,$void_lang){
	if($valid_rev){
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
			return $void_lang."は半角数字で入力してください。 -- ";
		}elseif($valid_rev > 24 && $valid_rev < 0){
			return $void_lang."が正しくない可能性があります。 -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_min($valid_rev,$void_lang){
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
		return $void_lang."は半角数字で入力してください。 -- ";
	}elseif($valid_rev > 60 && $valid_rev < 0){
		return $void_lang."が正しくない可能性があります。 -- ";
	}else{
		return true;
	}
}

function valid_input_min_if($valid_rev,$void_lang){
	if($valid_rev){
		if(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
			return $void_lang."に特殊文字が入力されています -- ";
		}elseif(!preg_match("/^[0-9]+$/", $valid_rev)){
			return $void_lang."は半角数字で入力してください。 -- ";
		}elseif($valid_rev > 60 && $valid_rev < 0){
			return $void_lang."が正しくない可能性があります。 -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}


function valid_input_account($valid_rev,$minnum,$maxnum,$langcode,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[a-zA-Z0-9_]+$/", $valid_rev)){
		return $void_lang."は半角英数字と_(アンダーバー)で入力してください。 -- ";
	}elseif(mb_strlen($valid_rev,$langcode) > $maxnum){
		return $void_lang."が制限文字数を超えています -- ";
	}elseif(mb_strlen($valid_rev,$langcode) < $minnum){
		return $void_lang."が最低制限文字数を超えていません -- ";
	}else{
		return true;
	}
}


function valid_input_limit_enable($valid_rev,$limit_array,$evt_limitdateflag,$evt_limitnumflag,$void_lang){

	if(!$valid_rev){
		$returnmsg = $void_lang."の入力されていません -- ";
	}
	if(!in_array($valid_rev,$limit_array)){
		$returnmsg = $void_lang."の選択項目が正しくありません -- ";
	}elseif(!($evt_limitdateflag == "true") && $valid_rev == "limitdate"){
		$returnmsg = $void_lang."は期間限定を選択していない状態です -- ";
	}elseif(!($evt_limitnumflag == "true") && $valid_rev == "limitnum"){
		$returnmsg = $void_lang."は限定数を選択していない状態です -- ";
	}else{
		$returnmsg = true;
	}
	
	return $returnmsg;
}

function enabledate_check($s_date,$e_date){
	$today = date('Y-m-d H:i');
	
	if($e_date > $today && $s_date < $today){
		$returnmsg = 'true';
	}else{
		$returnmsg = 'limitday';
	}
	return $returnmsg;
}

function startendnum_check_if($s_num,$e_num,$void_lang){
	
	if($s_num || $e_num){
		if(!preg_match("/^[0-9]+$/", $s_num) || !preg_match("/^[0-9]+$/", $e_num)){
			$returnmsg = $void_lang."は半角数字で入力してください。 -- ";
		}elseif($s_num > $e_num){
			$returnmsg = $void_lang."に数字の誤りがあります -- ";
		}else{
			$returnmsg = true;
		}
	}else{
		$returnmsg = true;
	}
	
	return $returnmsg;
}

/*
function enableflag_check($enableflag,$s_date,$e_date,$void_lang){
	$today = date('Y-m-d H:i');
	if($e_date < $today && $enableflag == 'true'){
		$returnmsg = $void_lang."が過去の日付では公開の選択はできません -- ";
	}elseif(($e_date > $today && $s_date < $today) && $enableflag == 'limitdate'){
		$returnmsg = $void_lang."が期限切れではない場合、期限切れの選択はできません -- ";
	}else{
		$returnmsg = true;
	}
	return $returnmsg;
}

function DataOverCheck($enableflag,$limitnum,$table_name,$void_lang){
	
	$datanum = CountDBtable($table_name);
	
	if($limitnum < $datanum){
		$returnmsg = $void_lang."の現在の登録数が応募数を超えています -- ";
	}elseif(($limitnum >= $datanum) && $enableflag == 'limitnum'){
		$returnmsg = $void_lang."の登録数が応募数を超えていないため、限定数オーバーの選択はできません -- ";
	}else{
		$returnmsg = true;
	}
	return $returnmsg;
}
*/


function valid_input_url($valid_rev,$void_lang){
	
	$pattern = '/http:\/\/[0-9a-z_,.:;&=+*%$#!?@()~\'\/-]+/i';
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}elseif(!preg_match($pattern, $valid_rev)){
		return $void_lang."にはURLを入力してください -- ";
	}else{
		return true;
	}
}

function valid_input_url_if($valid_rev,$void_lang){
	
	$pattern = '/http:\/\/[0-9a-z_,.:;&=+*%$#!?@()~\'\/-]+/i';
	
	if($valid_rev){
		if(!preg_match($pattern, $valid_rev)){
			return $void_lang."にはURLを入力してください -- ";
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function valid_input_mail($valid_email_num,$void_lang){
	
	$pattern = '/^(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*"))*@(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\])(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\]))*$/';
	
	if(!$valid_email_num){
		return $void_lang."が入力されていません -- ";
	
	}elseif(strlen($valid_email_num) > 255){
		return $void_lang."の入力文字数が制限内ではありません -- ";
	}elseif(!preg_match($pattern, $valid_email_num)){
		return $void_lang."が正しくありません -- ";
	}else{
		return true;
	}
}

function valid_input_mail_if($valid_email_num,$void_lang){
	
	$pattern = '/^(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*"))*@(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\])(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\]))*$/';
	
	if($valid_email_num){
	
		if(strlen($valid_email_num) > 255){
			return $void_lang."の入力文字数が制限内ではありません -- ";
		}elseif(!preg_match($pattern, $valid_email_num)){
			return $void_lang."が正しくありません -- ";
		}else{
			return true;
		}
		
	}else{
		return true;
	}
}

function valid_input_mail_retype($valid_email_num,$valid_reemail_num,$void_lang){
	
	$pattern = '/^(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*"))*@(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\])(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\]))*$/';
	
	if(!$valid_email_num){
		return $void_lang."が入力されていません -- ";
	}elseif($valid_email_num !== $valid_reemail_num){
		return $void_lang."の入力が確認用入力と異なります -- ";
	}elseif(strlen($valid_email_num) > 255){
		return $void_lang."の入力文字数が制限内ではありません -- ";
	}elseif(!preg_match($pattern, $valid_email_num)){
		return $void_lang."が正しくありません -- ";
	}else{
		return true;
	}
}


function valid_input_numen_sl($valid_rev,$void_lang){
	
	if(!$valid_rev || $valid_rev == "x"){
		return $void_lang."が選択されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[a-zA-Z0-9()-_\s]+$/", $valid_rev)){
		return $void_lang."は半角英数字で入力してください。 -- ";
	}else{
		return true;
	}
}

function valid_input_maru_sl($valid_rev,$void_lang){
	
	if(!$valid_rev || $valid_rev == "x"){
		return $void_lang."が選択されていません -- ";
	}elseif(ereg($GLOBALS["ATTACK_LANG"], $valid_rev)){
		return $void_lang."に特殊文字が入力されています -- ";
	}elseif(!preg_match("/^[○×△\s]+$/", $valid_rev)){
		return $void_lang."は○×△で入力してください。 -- ";
	}else{
		return true;
	}
}


function valid_input_minnum($valid_rev,$valid_min,$void_lang){
	if($valid_rev <= $valid_min){
		return $void_lang."数が条件を満たしていません -- ";
	}else{
		return true;
	}
}

function valid_photo($valid_photo_type,$void_lang)
{
	$valid_type_array = explode("/",$valid_photo_type);
	$valid_type_txt = $valid_type_array[1];


	if($valid_photo_type && ($valid_type_txt == "jpeg" || $valid_type_txt == "pjpeg" || $valid_type_txt == "gif")){
		return true;
	}else{
		return $void_lang."の画像タイプが正しくありません -- ";
		
	}
}

function check_post_files($filetype,$filesize,$maxfilesize,$void_lang){
	
	$valid_type_array = explode("/",$filetype);
	$valid_type_txt = $valid_type_array[1];
	
	if($filetype && ($valid_type_txt == "jpeg" || $valid_type_txt == "pjpeg" || $valid_type_txt == "gif")){
		if($maxfilesize >= $filesize){
			return true;
		}else{
			return $void_lang."の画像サイズが制限外です -- ";
		}
	}else{
		return $void_lang."の画像タイプが正しくないか、選択されていません -- ";
	}
	
}


function valid_mobile_email($getemail){

	$domains_array = array ('docomo.ne.jp','ezweb.ne.jp','softbank.ne.jp','t.vodafone.ne.jp','d.vodafone.ne.jp','h.vodafone.ne.jp','c.vodafone.ne.jp','k.vodafone.ne.jp','r.vodafone.ne.jp','n.vodafone.ne.jp','s.vodafone.ne.jp','q.vodafone.ne.jp','pdx.ne.jp','wm.pdx.ne.jp','di.pdx.ne.jp','dj.pdx.ne.jp','dk.pdx.ne.jp');

	$em_array = explode('@',$getemail);
	if(count($em_array) != 2){
		return false;
	}

	if(in_array($em_array[1],$domains_array)){
		return true;
	}else{
		return false;
	}

}

function valid_input_limit($valid_rev,$limit_array,$void_lang){
	
	if(!$valid_rev){
		return $void_lang."が入力されていません -- ";
	}
	if(in_array($valid_rev,$limit_array)){
		return true;
	}else{
		return $void_lang."に入力間違いがあります -- ";
	}
}

?>