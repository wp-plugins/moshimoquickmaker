<?php
/*
Plugin Name: MoshimoQuickMaker
Plugin URI: http://www.a-ings.net/
Description: このプラグインは、日本のドロップシッピングサービスの"もしも"をより簡単に運用するために開発されたものです。プラグインで任意のカテゴリーを選択すると、商品はあなたのwordpress内に自動的にインストールされます。しかも、定期的に自動で新しい商品に更新します。多くの人は"ドロップシッピングは興味あるが、手間がかかる"と言います。その要望に応えるために作りました。弊社サイトでテンプレートや拡張ウィジェットを有料で販売しています。購入して今後の開発にご協力ください。
Version: 1.0.7
Author: n.uchiumi
Author URI: http://www.a-ings.net/
*/

require_once( 'ds-config.php' );
require_once( UC_MSM_INCLUDEPATH.'admin_index.php' );
$showtext = new UcDsMoshimo;
require_once( UC_MSM_INCLUDEPATH.'public_index.php' );
$uc_msm_obj = new UcDsMoshimoPublic;
$uc_msm_message_flag = "";

if (function_exists('register_activation_hook')){
	register_activation_hook(__FILE__, array($showtext, 'uc_moshimo_activationhook'));
}
if (function_exists('register_deactivation_hook')){
	register_deactivation_hook(__FILE__, array($showtext, 'uc_moshimo_deactivationhook'));
}
/*
if (function_exists('register_uninstall_hook')){
   register_uninstall_hook(__FILE__, array($showtext, 'uc_moshimo_uninstallhook'));
}
*/
?>