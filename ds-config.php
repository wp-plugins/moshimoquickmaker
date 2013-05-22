<?php

global $wpdb;

define("UC_MSM_TITLE", 'ドロップシッピングもしも用プラグインQuickMaker');
define("UC_MSM_VERSION", '1.0.7');
///path
define("UC_MSM_PLUGINPATH", __FILE__);
define("UC_MSM_INCLUDEPATH", dirname(__FILE__)."/includes/");
define("UC_MSM_CLASSPATH", dirname(__FILE__)."/class/");
define("UC_MSM_FUNCTIONPATH", dirname(__FILE__)."/func/");
define("UC_MSM_LIBPATH", dirname(__FILE__)."/lib/");
define("UC_MSM_JSPATH", dirname(__FILE__)."/js/");

define('UC_MSM_JSDIR_URL', get_option('siteurl') . '/wp-content/plugins/quickmaker/js/');
define('UC_MSM_CSSDIR_URL', get_option('siteurl') . '/wp-content/plugins/quickmaker/css/');
define('UC_MSM_IMGDIR_URL', get_template_directory_uri().'/images/');


///database
define("UC_MSM_TABLECONF", $wpdb->prefix.'uc_moshimo_conf');
define("UC_MSM_TABLEJUNLE", $wpdb->prefix.'uc_moshimo_junle');
define("UC_MSM_TABLEITEM", $wpdb->prefix.'uc_moshimo_item');
define("UC_MSM_CONFID", '1');

///moshimo画像パス
define('UC_MSM_IMAGE_URL', 'http://www.moshimo.com/item_image/');
///moshimoカートパス
define('UC_MSM_CART_URL', 'http://mp.moshimo.com/cart/add?');
///moshimo_parent
define('UC_MSM_PARENT_URL', 'http://moshimo.lighfix.com/');

///トップアップロード画像パス
define('UC_MSM_TOPIMG_PATH', get_theme_root()."/".get_template().'/images/');
///トップアップロード画像ファイル名
define('UC_MSM_TOPIMG', 'topimg');

///最大カテゴリー登録数
define('UC_MSM_CATEGORY_ADDMAX', 80);

///初期設定
define("UC_MSM_TABLECONF_MARRAY", 'conf_confid:name=>設定ID*judge=>valid_input_num,conf_salecode:name=>ショップID*judge=>valid_input_numen,conf_apicode:name=>もしもAPIコード*judge=>valid_input_numen,conf_pattern:name=>商品表示パターン*judge=>valid_input_numen_if,conf_shopname:name=>ショップ名*judge=>valid_input,conf_shopcatch:name=>ショップ説明テキスト*judge=>valid_input_if,conf_shopdescript:name=>ディスクリプション*judge=>valid_input_if,conf_shopkeyword:name=>キーワード*judge=>valid_input_if,conf_shopimg:name=>ショップトップ画像*judge=>valid_input_if,conf_shopimg_flag:name=>ショップトップ画像掲載許可*judge=>valid_input_if,conf_shopimglink:name=>ショップトップ画像リンク*judge=>valid_input_url_if,conf_shopupdate:name=>商品アップデート*judge=>valid_input_en_if,conf_shopupdate_time:name=>商品アップデート時間*judge=>valid_input_numen_if,conf_shopupdate_lasttime:name=>最終商品アップデート時間*judge=>valid_input_numen_if,conf_analytics:name=>グーグルアナリティクス*judge=>valid_input_numen_if,conf_analytics_flag:name=>グーグルアナリティクス使用許可*judge=>valid_input_en_if');
///アップデート設定
define("UC_UPDATE_RARRAY","noupdate=>しない,daily=>毎日,2day=>2日おき,3day=>3日おき,1week=>一週間おき,2week=>二週間おき,1month=>一ヶ月おき");
///ジャンル
define("UC_MSM_TABLEJUNLE_MARRAY", 'junle_id:name=>ジャンルID*judge=>valid_input_num,junle_name:name=>ジャンル名*judge=>valid_input,junle_parentid:name=>親ID*judge=>valid_input_num,junle_parentname:name=>親ジャンル名*judge=>valid_input,junle_item:name=>登録アイテム*judge=>valid_input_if,junle_titleimg:name=>タイトル画像*judge=>valid_input_numen,junle_titletxt:name=>タイトルテキスト*judge=>valid_input_if');
///商品
define("UC_MSM_TABLEITEM_MARRAY", 'item_id:name=>登録ID*judge=>valid_input_num,item_moshimo_id:name=>商品ID*judge=>valid_input_numen,item_junle_id:name=>ジャンルID*judge=>valid_input_num,item_price:name=>販売価格*judge=>valid_input_num,item_open:name=>公開フラグ*judge=>valid_input_num');

define("UC_PARENTDIR_RARRAY","01=>フード・ドリンク・スイーツ,02=>ファッション,03=>AV・デジモノ,04=>家電,05=>美容・コスメ,06=>ダイエット・健康,07=>生活用品・インテリア・雑貨,08=>スポーツ・レジャー,09=>ホビー・エトセトラ");

define("UC_ITEMDB_ARRAY","item_ArticleId,item_Name,item_Description,item_SpecialDescription,item_Spec,item_CatchCopy,item_MakerName,item_ModelNumber,item_Tags,item_IsNewly,item_HeavySeller,item_IsDeliverySameday,item_IsFreeShipping,item_DodFrom,item_DodTo,item_PreorderFlag,item_PreorderPeriod,item_Category_Code,item_Category_Name,item_Category_Level,item_Category_Parents,item_GroupId,item_ImageCode,item_ImageCount,item_JanCode,item_PaymentType,item_BundleImpossible,item_StartDate,item_HasMaterial,item_FixedPrice,item_DefaultProfitPrice,item_DefaultProfitRate,item_RecommendedPrice,item_MinimumPrice,item_WholesalePrice,item_ShopPrice,item_StockStatus,item_StockStatusWord,item_MyParentGroupId,item_MyChildGroupId,item_InsertDate,item_Clickcount,item_ClickcountData");

define("UC_ITEMCATEGORY_ARRAY","item_Category_Code,item_Category_Name,item_Category_Level,item_Category_Parents_Code,item_Category_Parents_Name,item_Category_Parents_Level");

define("UC_ITEMJUNLE_ARRAY","junle_id,junle_name,junle_parentid,junle_parentname,junle_item,junle_titleimg,junle_titletxt");

///default optionDB variable
define("UC_MSM_VALNAME_VERSION", 'uc_moshimo_version');
define("UC_MSM_VALNAME_INSTALLFLAG", 'uc_moshimo_installflag');

///スラッグ
define("UC_MSM_ITEMSLUG", 'uc_itemlist');
define("UC_MSM_DETAILSLUG", 'uc_itemdetail');
///各GET変数名

///一覧カテゴリID
define("UC_MSM_ITEMSELECTID", 'selectID');
///一覧カテゴリID
define("UC_MSM_ITEMDETAILID", 'detailID');
///一覧ソートID
define("UC_MSM_ITEMSORTCATE", 'sortID');
///一覧ソート順
define("UC_MSM_ITEMSORTDESC", 'sortdesc');
///検索
define("UC_MSM_ITEMSEARCH", 'search');
///検索 AND/OR
define("UC_MSM_ITEMSEARCHANDOR", 'searchandor');
///検索 AND/OR
define("UC_MSM_ITEMSEARCHCATEGORY", 'searchcategory');
///ページGET変数名
define("UC_MSM_PAGINGID", 'paging');

define("UC_MSM_ITEMSORT_RARRAY","price=>item_RecommendedPrice,startdate=>item_StartDate");
define("UC_MSM_ITEMANDOR_RARRAY","and=>AND,or=>OR");
define("UC_MSM_ITEMCATEGORY_RARRAY","select=>nowcategory,all=>allcategory");

///ページ一覧

///ページ番号の表示数
define("UC_MSM_ITEMLIST_MAX", 5);
///ページあたりの表示数
define("UC_MSM_ITEMLIST_MAXITEM", 20);
///アイテムの１行あたりの商品数
define("UC_MSM_ITEMLIST_COLUM", 5);

?>