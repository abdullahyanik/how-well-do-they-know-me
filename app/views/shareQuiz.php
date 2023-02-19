<?php defined("SITE_URL") or die(); ?>
<?php $quizLink = SITE_URL."quiz/".$shortcode; ?>
<div class="py-5 h-100">
<div class="container h-100">
    <div class="text-center">
        <h1><i class="fas fa-share-alt fa-2x text-primary"></i></h1>
        <h1 class="my-4"><?php _e("shareQuiz"); ?></h1>
        <p class="mb-0"><?php _e("sharePageText"); ?></p>
        <div class="my-4 row justify-content-center">
        <div class="col-lg-6">
            <div class="input-group py-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                </div>
                <input readonly="" value="<?php echo $quizLink; ?>" id="quizLink" class="form-control" placeholder="<?php _e("enterYourName"); ?>" type="text">
                <div class="input-group-append">
                    <button class="btn btn-warning" onclick="copyLink()"><?php _e("copyLink"); ?><i class="fas fa-copy ml-2"></i></button>
                </div>
            </div>
            <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-lg-6 p-0 pr-lg-1 mb-3">
                    <a target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($quizLink); ?>&quote=<?php echo urlencode($Strings->g("shareText")); ?>"><button style="background:#3b5998;border-color:#3b5998" class="btn btn-primary w-100 d-flex align-items-center justify-content-center btn-lg"><i class="fab fa-facebook mr-2"></i><?php _e("shareFacebook"); ?></button></a>
                </div>
                <div class="col-lg-6 p-0 pl-lg-1 mb-3">
                    <a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo urlencode($Strings->g("shareText")." ".$quizLink); ?>"><button style="background:#128c7e;border-color:#128c7e" class="btn btn-primary w-100 d-flex align-items-center justify-content-center btn-lg"><i class="fab fa-whatsapp mr-2"></i><?php _e("shareWhatsapp"); ?></button></a>
                </div>
                <div class="col-lg-6 p-0 pr-lg-1 mb-3">
                    <a target="_blank" href="fb-messenger://share?link=<?php echo urlencode($quizLink); ?>"><button style="background:#0084ff;border-color:#0084ff" class="btn btn-primary w-100 d-flex align-items-center justify-content-center btn-lg"><i class="fab fa-facebook-messenger mr-2"></i><?php _e("shareMessenger"); ?></button></a>
                </div>
                <div class="col-lg-6 p-0 pl-lg-1 mb-3">
                    <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode($Strings->g("shareText")." ".$quizLink); ?>"><button style="background:#1da1f2;border-color:#1da1f2" class="btn btn-primary w-100 d-flex align-items-center justify-content-center btn-lg"><i class="fab fa-twitter mr-2"></i><?php _e("shareTwitter"); ?></button></a>
                </div>
                <div class="col-lg-6 p-0 pr-lg-1 mb-3">
                    <a target="_blank" href="line://msg/text/?<?php echo urlencode($Strings->g("shareText")." ".$quizLink); ?>"><button style="background:#00c300;border-color:#00c300" class="btn btn-primary w-100 d-flex align-items-center justify-content-center btn-lg"><i class="fab fa-line mr-2"></i><?php _e("shareLine"); ?></button></a>
                </div>
                <div class="col-lg-6 p-0 pl-lg-1 mb-3">
                    <a target="_blank" href="tg://msg?text=<?php echo urlencode($Strings->g("shareText")." ".$quizLink); ?>"><button style="background:#0088cc;border-color:#0088cc" class="btn btn-primary w-100 d-flex align-items-center justify-content-center btn-lg"><i class="fab fa-telegram mr-2"></i><?php _e("shareTelegram"); ?></button></a>
                </div>
            </div>
            </div>
            <div class="mt-4">
                <a target="_blank" href="<?php echo $quizLink; ?>"><button class="btn btn-warning btn-lg d-block w-100"><i class="fas fa-poll mr-2"></i><?php _e("showResults"); ?></button></a>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
<div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalText" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="copyModalText"><?php _e("linkCopied"); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php _e("close"); ?>">
          <span aria-hidden="true" class="d-flex align-items-center justify-content-center">&times;</span>
        </button>   
      </div>
      <div class="modal-body"><?php _e("linkCopiedText"); ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?php _e("close"); ?></button>
      </div>
    </div>
  </div>
</div>
<script>
function copyLink() {
    var temp = $("<input>");
    $("body").append(temp);
    temp.val($("#quizLink").val()).select();
    document.execCommand("copy");
    temp.remove();
    $("#copyModal").modal();
}
</script>
