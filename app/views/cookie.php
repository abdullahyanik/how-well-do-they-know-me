<?php if(!isset($_COOKIE["comply_cookie"])) { ?>
  <div id="cookies">
  <p><?php _e("cookieWarning"); ?>
  <span class="cookie-accept" title="Okay, close"><?php _e("cookieAccept"); ?></span></p>
  </div>
<?php } ?>