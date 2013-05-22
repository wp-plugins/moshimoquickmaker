<?php /* Template Name: uc_itemlist */ ?>
<?php global $uc_msm_message_flag; ?>
<?php $uc_msm_message_flag = "item_list"; ?>
<!-- ▼▼ main start ▼▼ -->
<div id="ds_msm_main-wrapper">
<?php get_header(); ?>
<!---container-->
<div id="ds_msm_container" class="clearfix">
    <?php get_sidebar(); ?>
	<div id="ds_msm_mainarea">
    	<div class="uc_itemlist">
			<?php if($disp_tag_array = $uc_msm_obj->PageItemList()) : ?>
                <div class="mainarea_itemtitle">
                    <h1 class='uc_itemtitle'><?php echo $disp_tag_array["title"]; ?></h1>
                    <?php echo $disp_tag_array["sort"]; ?>
                </div>
                <div class="mainarea_itemlist">
                    <?php echo $disp_tag_array["item"]; ?>
                </div>
                <div class="mainarea_paging">
                    <?php echo $disp_tag_array["link"]; ?>
                </div>
            <?php else : ?>
                <div class="mainarea_itemtitle">
                    商品一覧が取得できませんでした。
                </div>
            <?php endif; ?>
        </div>
	</div>

</div>
<!---container-->
<div class="push"><!--foot margin--></div>
</div>
<!-- ▲▲ main end ▲▲ -->
<?php get_footer(); ?>