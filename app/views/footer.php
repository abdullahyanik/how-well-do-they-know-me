<?php defined("SITE_URL") or die(); ?>
</main>
<div class="bg-primary py-4">
    <div class="container">
        <div class="row border-bottom pb-4" style="border-color:#0066dc45!important">
            <div class="col-lg-4">
                <h5 class="text-white"><?php _e("footerInfo"); ?></h5>
                <p class="text-light mb-0"><?php _e("footerInfoText"); ?></p>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0">
                <h5 class="text-white"><?php _e("footerLinks"); ?></h5>
                <ul class="p-0 list-unstyled">
                    <?php foreach(json_decode($Configs["footer_links"], true) as $link): ?>
                    <li><a href="<?php echo $link["url"]; ?>" class="text-light"><?php echo $link["title"]; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0">
                <h5 class="text-white"><?php _e("footerPages"); ?></h5>
                <ul class="p-0 list-unstyled">
                    <li><a href="./about" class="text-light"><?php _e("about"); ?></a></li>
                    <li><a href="./privacy-policy" class="text-light"><?php _e("privacyPolicy"); ?></a></li>
                    <li><a href="./cookie-policy" class="text-light"><?php _e("cookiePolicy"); ?></a></li>
                    <li><a href="./terms-of-use" class="text-light"><?php _e("termsOfUse"); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="pt-4 mb-0 text-white">© <?php echo date("Y"); ?>. <b><?php echo $Configs["title"]; ?></b>. <?php _e("allRightsReserved"); ?>.</p>
            </div>
        </div>
    </div>
</div>
<?php defined("SITE_URL") or die(); ?>
    <script src="assets/vendor/popper/popper.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="assets/vendor/fontawesome/js/custom.min.js" defer></script>
    <script src="assets/js/theme.js"></script>
    <?php echo $Configs["extra_footer"]; ?>
</body>
</html>