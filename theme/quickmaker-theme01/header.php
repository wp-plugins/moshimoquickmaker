<?php global $uc_msm_getinfoarray; ?>
<?php global $uc_msm_obj; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<?php wp_enqueue_script( 'jquery' ); ?>
<?php wp_head(); ?>
<meta name="discription" content="<?php echo $uc_msm_getinfoarray['conf_shopdescript']; ?>" />
<meta name="keyword" content="<?php echo $uc_msm_getinfoarray['conf_shopkeyword']; ?>" />
<?php /* ▼テーマのCSSが入ります */ ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/layout.css" type="text/css" />
<title><?php echo $uc_msm_getinfoarray['conf_shopname']; ?>｜<?php echo $uc_msm_obj->GetTitle(); ?></title>
</head>
<body id="ds_msm">
<div id="ds_msm_head">
    <div class="ds_msm_headtitle clearfix">
        <div class="ds_msm_sitetitle"><?php echo $uc_msm_getinfoarray['conf_shopname']; ?></div>
        <div class="ds_msm_righttxt clearfix">
            <div class="ds_msm_souryou_img"><img src="<?php  echo get_template_directory_uri(); ?>/images/hd_backimg03.gif" ></div>
            <div class="ds_msm_souryou_text">税込8000円以上のお買い上げで</div>
        </div>
    </div>
    <div class="ds_msm_headbt">
        <ul class="clearfix">
            <li><a href="http://mp.moshimo.com/cart?shop_id=<?php echo $uc_msm_getinfoarray['conf_salecode']; ?>" target="_blank"><img src="<?php  echo get_template_directory_uri(); ?>/images/hd_bt_cart.gif" alt="カートを見る" /></a></li>
            <li><a href="http://mp.moshimo.com/about/return?shop_id=<?php echo $uc_msm_getinfoarray['conf_salecode']; ?>" target="_blank"><img src="<?php  echo get_template_directory_uri(); ?>/images/hd_bt_return.gif" alt="返品について" /></a></li>
            <li><a href="http://mp.moshimo.com/about/payment?shop_id=<?php echo $uc_msm_getinfoarray['conf_salecode']; ?>" target="_blank"><img src="<?php  echo get_template_directory_uri(); ?>/images/hd_bt_payment.gif" alt="支払い・配送について" /></a></li>
            <li><a href="http://mp.moshimo.com/about/flow?shop_id=<?php echo $uc_msm_getinfoarray['conf_salecode']; ?>" target="_blank"><img src="<?php  echo get_template_directory_uri(); ?>/images/hd_bt_howto.gif" alt="お買い物の流れ" /></a></li>
            <li><a href="<?php bloginfo('url'); ?>"><img src="<?php  echo get_template_directory_uri(); ?>/images/hd_bt_top.gif" alt="商品一覧" /></a></li>
        </ul>
    </div>
</div>

