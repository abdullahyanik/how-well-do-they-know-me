<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
<script src="assets/admin/vendor/toastr/toastr.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<style>.ql-editor{min-height:250px;}</style>
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<form action="" method="post" id="addForm" enctype="multipart/form-data">
    <span><?php _e("postTitle"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="title" class="form-control" required>
    </div>
    <span><?php _e("postMetaDesc"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="desc" class="form-control">
    </div>
    <span><?php _e("postMetaTags"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="tags" class="form-control">
    </div>
    <span><?php _e("postImage"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="file" name="image" accept="image/*" class="form-control" style="padding:4.5px">
    </div>
    <span><?php _e("postContent"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <div class="editor"></div>
    </div>
    <button class="btn btn-primary" style="margin-top:20px" type="submit"><?php _e("addBlog"); ?></button>
</form>
</div>
</div>
<script>
var toolbarOptions = [['bold', 'italic', 'underline', 'strike'],['blockquote', 'code-block'],[{ 'header': 1 }, { 'header': 2 }],[{ 'list': 'ordered'}, { 'list': 'bullet' }],[{ 'script': 'sub'}, { 'script': 'super' }],[{ 'header': [1, 2, 3, 4, 5, 6, false] }],[{ 'color': [] }, { 'background': [] }],[{ 'font': [] }],[{ 'align': [] }],['clean'], [ 'link', 'image', 'video', 'formula' ]];
var quill = new Quill('.editor', {theme: 'snow', modules: { toolbar: toolbarOptions }});
$("#addForm").submit(function(e) {
e.preventDefault();
var form = $(this);
$("<input>").attr({type: "hidden", name: "content", value: quill.root.innerHTML}).appendTo(form);
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
            window.location.href = "./admin/blogs";
            }, 2000);
        }
        else {
        toastr.error(data.message);
        }
    }
    });
});
</script>