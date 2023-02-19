<?php defined("SITE_URL") or die(); ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="py-5" style="background:#f9f9f9">
    <div class="container my-1 text-center">
        <h1 class="mb-0"><?php _e("contact"); ?></h1>
    </div>
</div>
<div class="container my-5">
    <div class="text-center h4 font-weight-normal pb-2"><?php _e("contactPageText"); ?></div>
    <form action="" method="post" id="contactForm">
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input class="form-control" name="name" type="text" required="" placeholder="<?php _e("formNameText"); ?>">
            </div>
        </div>
        <div class="col-lg-6 mt-3 mt-lg-0">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input class="form-control" name="email" type="email" required="" placeholder="<?php _e("formEmailText"); ?>">
            </div>
        </div>
        <div class="col-lg-12 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                </div>
                <input class="form-control" name="subject" type="text" required="" placeholder="<?php _e("formSubjectText"); ?>">
            </div>
        </div>
        <div class="col-lg-12 mt-3">
            <div class="input-group">
                <textarea style="height:100px;resize:none" class="form-control" name="message" required="" placeholder="<?php _e("formMessageText"); ?>"></textarea>
            </div>
            <div class="g-recaptcha my-3" data-sitekey="<?php echo htmlentities($Configs["recaptcha_site_key"]); ?>"></div>
            <button type="submit" class="btn btn-primary"><?php _e("submit"); ?></button>
        </div>
    </div>
    </form>
</div>
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalText" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alertModalText"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php _e("close"); ?>">
          <span aria-hidden="true" class="d-flex align-items-center justify-content-center">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?php _e("close"); ?></button>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/contact.js"></script>