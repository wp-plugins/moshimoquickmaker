<?php
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {exit();}
delete_option('uc_moshimo_version');
delete_option('uc_moshimo_installflag');

global $wpdb;

$table_name_conf = $wpdb->prefix.'uc_moshimo_conf';
$table_name_junle = $wpdb->prefix.'uc_moshimo_junle';
$table_name_item = $wpdb->prefix.'uc_moshimo_item';

$wpdb->query("DROP TABLE IF EXISTS ".$table_name_conf.";");
$wpdb->query("DROP TABLE IF EXISTS ".$table_name_junle.";");
$wpdb->query("DROP TABLE IF EXISTS ".$table_name_item.";");
?>