<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
<script src="assets/admin/vendor/toastr/toastr.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<style>.ql-editor{min-height:250px;}</style>
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<form action="" method="post" id="editForm">
    <span><?php _e("pageTitle"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="title" class="form-control" required value="<?php echo htmlentities($page["title"]); ?>">
    </div>
    <span><?php _e("pageMetaDesc"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="desc" class="form-control" value="<?php echo htmlentities($page["description"]); ?>">
    </div>
    <span><?php _e("pageMetaTags"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="tags" class="form-control" value="<?php echo htmlentities($page["tags"]); ?>">
    </div>
    <span><?php _e("pageContent"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <div class="editor"><?php echo $page["content"]; ?></div>
    </div>
    <input class="btn btn-primary" name="update" value="<?php _e("editPage"); ?>" style="margin-top:20px" type="submit">
    <input class="btn btn-danger" name="delete" value="<?php _e("deletePage"); ?>" style="margin-top:20px" type="submit">
</form>
</div>
</div>
<script>
var toolbarOptions = [['bold', 'italic', 'underline', 'strike'],['blockquote', 'code-block'],[{ 'header': 1 }, { 'header': 2 }],[{ 'list': 'ordered'}, { 'list': 'bullet' }],[{ 'script': 'sub'}, { 'script': 'super' }],[{ 'header': [1, 2, 3, 4, 5, 6, false] }],[{ 'color': [] }, { 'background': [] }],[{ 'font': [] }],[{ 'align': [] }],['clean'], [ 'link', 'image', 'video', 'formula' ]];
var quill = new Quill('.editor', {theme: 'snow', modules: { toolbar: toolbarOptions }});
$("#editForm input[type='submit']").click(function(e) {
e.preventDefault();
var form = $("#editForm");
$("<input>").attr({type: "hidden", name: $(this).attr("name"), value: "1"}).appendTo(form);
$("<input>").attr({type: "hidden", name: "content", value: quill.root.innerHTML}).appendTo(form);
$.ajax({
    type: form.attr("method"),
    url: form.attr("action"),
    data: form.serialize(),
    success: function(data) {
        data = JSON.parse(data);
        if(data.success) {
            toastr.success(data.message);
            setTimeout(function() {
            window.location.href = "./admin/pages/<?php echo $page["id"]; ?>";
            }, 2000);
        }
        else {
            toastr.error(data.message);
        }
    }
    });
});
</script>