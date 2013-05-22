<?php /* Template Name: uc_itemdetail */ ?>
<?php global $uc_msm_message_flag; ?>
<?php $uc_msm_message_flag = "item_detail"; ?>
<!-- ▼▼ main start ▼▼ -->
<div id="ds_msm_main-wrapper">
<?php get_header(); ?>
<!---container-->
<div id="ds_msm_container" class="clearfix">
    <?php get_sidebar(); ?>
	<div id="ds_msm_mainarea">
    	
			<?php if($detail_tag = $uc_msm_obj->PageItemDetail()) : ?>
                <?php echo $detail_tag; ?>
            <?php else : ?>
                <div class="mainarea_itemtitle">
                    商品一覧が取得できませんでした。
                </div>
            <?php endif; ?>
    	
	</div>
</div>
<!---container-->
<div class="push"><!--foot margin--></div>
</div>
<!-- ▲▲ main end ▲▲ -->
<?php get_footer(); ?>