<?php global $uc_msm_getinfoarray; ?>
<div id="ds_msm_footer">
	<div class="footer_area">
        <div class="footer_button">
            <ul class="clearfix">
                <li><a href="http://mp.moshimo.com/about/correspond?shop_id=<?php echo $uc_msm_getinfoarray['conf_salecode']; ?>" target="_blank">お問い合わせ対応時間</a></li>
                <li><a href="http://mp.moshimo.com/about/faq?shop_id=<?php echo $uc_msm_getinfoarray['conf_salecode']; ?>" target="_blank">FAQ</a></li>
                <li><a href="http://mp.moshimo.com/about/seller?shop_id=<?php echo $uc_msm_getinfoarray['conf_salecode']; ?>" target="_blank">会社概要</a></li>
            </ul>
        </div>
        <div class="footer_copy">
            Copyright &copy; <?php echo $uc_msm_getinfoarray['conf_shopname']; ?> All Rights Reserved.
        </div>
    </div>
</div>


<?php /* ▼wp_footerアクションフックをスタートさせます */ ?>
<?php wp_footer(); ?>
<?php echo uc_msm_analytics(); ?>
</body>
</html>