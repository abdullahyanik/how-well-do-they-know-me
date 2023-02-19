<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
<script src="assets/admin/vendor/toastr/toastr.min.js"></script>
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<form action="./admin/settings" method="post" id="settingsForm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $page; ?>">
    <?php if($page == "general"): ?>
    <span><?php _e("siteTitle"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="title" class="form-control" value="<?php echo htmlentities($Configs["title"]); ?>" required>
    </div>
    <span><?php _e("siteDescription"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="description" class="form-control" value="<?php echo htmlentities($Configs["description"]); ?>" required>
    </div>
    <span><?php _e("siteTags"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="tags" class="form-control" value="<?php echo htmlentities($Configs["tags"]); ?>" required>
    </div>
    <span><?php _e("siteLanguage"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <select name="language" required class="form-control">
            <?php foreach($Configs["languages"] as $l => $language): ?>
            <option value="<?php echo $l; ?>" <?php echo $l == $Configs["language"] ? "selected" : ""; ?>><?php echo $language; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php include(realpath(__DIR__."/../../libraries/timezones.php")); ?>
    <span><?php _e("siteTimezone"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <select name="timezone" required class="form-control">
            <?php foreach($timezones as $t => $timezone): ?>
            <option value="<?php echo $t; ?>" <?php echo $t == $Configs["timezone"] ? "selected" : ""; ?>><?php echo $timezone; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <span><?php _e("questionLimit"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="number" name="question_limit" class="form-control" value="<?php echo htmlentities($Configs["question_limit"]); ?>" required>
    </div>
    <span><?php _e("recaptchaSiteKey"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="recaptcha_site_key" class="form-control" value="<?php echo htmlentities($Configs["recaptcha_site_key"]); ?>" required>
    </div>
    <span><?php _e("recaptchaSecretKey"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="recaptcha_secret_key" class="form-control" value="<?php echo htmlentities($Configs["recaptcha_secret_key"]); ?>" required>
    </div>
    <span><?php _e("disqusUsername"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="disqus_username" class="form-control" value="<?php echo htmlentities($Configs["disqus_username"]); ?>" required>
    </div>
    <span><?php _e("extraHeaderCode"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <textarea name="extra_header" class="form-control"><?php echo htmlentities($Configs["extra_header"]); ?></textarea>
    </div>
    <span><?php _e("extraFooterCode"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <textarea name="extra_footer" class="form-control"><?php echo htmlentities($Configs["extra_footer"]); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary"><?php _e("submit"); ?></button>
    <?php elseif($page == "design"): ?>
    <div class="row">
    <div class="col-lg-6">
        <span><?php _e("currentLogo"); ?>:</span>
        <div style="margin-top:10px;margin-bottom:20px">
            <img src="assets/img/logo.png?t=<?php echo time(); ?>" style="height:50px" class="mw-100">
        </div>
        <span><?php _e("newLogo"); ?>:</span>
        <div style="margin-top:10px;margin-bottom:20px">
            <input type="file" name="logo" accept="image/*" class="form-control" style="padding:4.5px">
            <small><?php _e("keepEmptyText"); ?></small>
        </div>
    </div>
    <div class="col-lg-6">
        <span><?php _e("currentFavicon"); ?>:</span>
        <div style="margin-top:10px;margin-bottom:20px">
            <img src="assets/img/favicon.png?t=<?php echo time(); ?>" style="height:50px">
        </div>
        <span><?php _e("newFavicon"); ?>:</span>
        <div style="margin-top:10px;margin-bottom:20px">
            <input type="file" name="favicon" accept="image/*" class="form-control" style="padding:4.5px">
            <small><?php _e("keepEmptyText"); ?></small>
        </div>
    </div>
    </div>
    <span><?php _e("footerLinks"); ?>:</span>
    <div class="table-responsive">
    <table class="table" id="footerLinks">
                <thead style="background:#f9f9f9">
                    <tr>
                        <th style="padding-left:1rem"><?php _e("linkTitle"); ?></th>
                        <th style="padding-left:0"><?php _e("linkUrl"); ?></th>
                        <th><?php _e("action"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $links = json_decode($Configs["footer_links"], true); ?>
                    <tr><!--<tr><td style="vertical-align:middle;padding-left:1rem"><input placeholder="<?php _e("enterlinkTitle"); ?>" type="text" class="form-control" name="footer_text[]" required value=""></td><td style="vertical-align:middle;padding-left:0"><input placeholder="<?php _e("enterlinkUrl"); ?>" type="text" class="form-control" name="footer_link[]" required value=""></td><td><button class="btn btn-danger" type="button" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash"></i></button></td></tr>--></tr>
                    <?php foreach($links as $link): ?>
                    <tr>
                        <td style="vertical-align:middle;padding-left:1rem"><input placeholder="<?php _e("enterlinkTitle"); ?>" type="text" class="form-control" name="footer_text[]" required value="<?php echo htmlentities($link["title"]); ?>"></td>
                        <td style="vertical-align:middle;padding-left:0"><input placeholder="<?php _e("enterlinkUrl"); ?>" type="text" class="form-control" name="footer_link[]" required value="<?php echo htmlentities($link["url"]); ?>"></td>
                        <td><button class="btn btn-danger" type="button" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
        </table>
        </div>
        <button type="submit" class="btn btn-primary"><?php _e("submit"); ?></button>
        <button type="button" class="btn btn-success" id="addLink"><?php _e("buttonFooterLink"); ?></button>
    <?php elseif($page == "ads"): ?>
    <span><?php _e("sidebarAdCode"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <textarea name="sidebar_ad" class="form-control"><?php echo htmlentities($Configs["sidebar_ad"]); ?></textarea>
    </div>
    <span><?php _e("inPostAdCode"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <textarea name="post_ad" class="form-control"><?php echo htmlentities($Configs["post_ad"]); ?></textarea>
    </div>
    <span><?php _e("scoreAdCode"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <textarea name="score_ad" class="form-control"><?php echo htmlentities($Configs["score_ad"]); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary"><?php _e("submit"); ?></button>
    <?php elseif($page == "profile"): ?>
    <span><?php _e("adminUsername"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="admin_username" class="form-control" value="<?php echo htmlentities($Configs["admin_username"]); ?>" required>
    </div>
    <span><?php _e("adminPassword"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="admin_password" class="form-control" value="">
        <small><?php _e("keepEmptyText"); ?></small>
    </div>
    <button type="submit" class="btn btn-primary"><?php _e("submit"); ?></button>
    <?php endif; ?>
</form>
</div>
</div>
<script>
$("#addLink").click(function() {
    var t = $("<tr>"+$("#footerLinks tbody tr:eq(0)").html().replace("<!--", "").replace("-->", "")+"</tr>");
    t.find("input").val("");
    $("#footerLinks tbody").append(t);
});
$("#settingsForm").submit(function(e) {
e.preventDefault();
var form = $(this);
var formData = new FormData(form[0]);
$.ajax({
    type: form.attr("method"),
    url: form.attr("action"),
    data: formData,
    async: false,
    cache: false,
    processData: false,
    contentType: false,
    enctype: form.attr("enctype"),
    success: function(data) {
        data = JSON.parse(data);
        if(data.success) {
            toastr.success(data.message);
            setTimeout(function() {
            window.location.href = "./admin/settings/<?php echo $page; ?>";
            }, 2000);
        }
        else {
            toastr.error(data.message);
        }
    }
    });
});
</script>