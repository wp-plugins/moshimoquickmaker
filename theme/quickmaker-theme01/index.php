<?php global $uc_msm_getinfoarray; ?>
<?php get_header(); ?>
<!-- ▼▼ main start ▼▼ -->
<div id="ds_msm_main-wrapper">
<!---container-->
<div id="ds_msm_container" class="clearfix">
<?php get_sidebar(); ?>
<div id="ds_msm_mainarea">
    <!---img-->
    <?php if($uc_msm_getinfoarray['conf_shopimg'] && $uc_msm_getinfoarray['conf_shopimg_flag'] == "true")  : ?>
        <?php $topimg_url = get_template_directory_uri()."/images/".$uc_msm_getinfoarray['conf_shopimg']; ?>
        <h1 class="top_mainimg">
            <?php if($uc_msm_getinfoarray['conf_shopimglink'])  : ?>
                <a href="<?php echo $uc_msm_getinfoarray['conf_shopimglink']; ?>">
            <?php endif; ?>
            <img src="<?php echo $topimg_url ?>" alt="<?php $uc_msm_getinfoarray['conf_shopname']; ?>" />
            <?php if($uc_msm_getinfoarray['conf_shopimglink'])  : ?>
                </a>
            <?php endif; ?>
        </h1>
    <?php endif; ?>
    <!---catchcopy-->
    <?php if($uc_msm_getinfoarray['conf_shopcatch']) : ?>
        <h2 class="top_shopcatch"><?php echo $uc_msm_getinfoarray['conf_shopcatch']; ?></h2>
    <?php endif; ?>
    <!---recommend-->
    <div class="mainarea_recommend_title"><img src="<?php  echo get_template_directory_uri(); ?>/images/main_tit_recommend.gif" alt="おすすめ商品" /></div>
    <div class="uc_itemlist_recommend">
        <?php echo uc_msm_recommend(); ?>
    </div>
</div>
</div>
<!---container-->
<div class="push"><!--foot margin--></div>
</div>
<!-- ▲▲ main end ▲▲ -->
<?php get_footer(); ?>