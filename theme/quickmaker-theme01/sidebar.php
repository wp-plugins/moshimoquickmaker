
<div id="ds_msm_sidearea">
    <div class="sidearea_category_title"><img src="<?php  echo get_template_directory_uri(); ?>/images/main_tit_category.gif" alt="カテゴリー" /></div>
    <div class="sidearea_buttonarea">
            <?php echo uc_msm_getsidemenu(); ?>
    </div>
    <div>
    	<?php if( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<?php endif; ?>
    </div>
    <div id="option_area"></div>
</div>