<?php
$uc_msm_getinfoarray = "";
//サイドメニュー表示
function uc_msm_getsidemenu(){
	global $uc_msm_obj;
	return $uc_msm_obj->getsidemenu();
}
//サイト情報
function uc_msm_getotherinfo(){
	global $uc_msm_obj;
	global $uc_msm_getinfoarray;
	$uc_msm_getinfoarray = $uc_msm_obj->getinfo();
}
add_action('get_header', 'uc_msm_getotherinfo');
//リコメンド
function uc_msm_recommend(){
	global $uc_msm_obj;
	return $uc_msm_obj->ReccomendList();
}
//アナリティクス
function uc_msm_analytics(){
	global $uc_msm_obj;
	return $uc_msm_obj->Analytics();
}
if( function_exists('register_sidebar') ){
	register_sidebar();
}

//****************************************************************************************************************************************
?>