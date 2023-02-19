<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
<script src="assets/admin/vendor/toastr/toastr.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<style>.ql-editor{min-height:250px;}</style>
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<form action="" method="post" id="addForm">
    <span><?php _e("pageTitle"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="title" class="form-control" required>
    </div>
    <span><?php _e("pageMetaDesc"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="desc" class="form-control">
    </div>
    <span><?php _e("pageMetaTags"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="tags" class="form-control">
    </div>
    <span><?php _e("pageContent"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <div class="editor"></div>
    </div>
    <span><?php _e("addFooterLink"); ?></span>
    <div style="margin-top:10px;margin-bottom:20px">
        <select name="add_link" class="form-control">
            <option value="1" selected><?php _e("yes"); ?></option>
            <option value="0"><?php _e("no"); ?></option>
        </select>
    </div>
    <button class="btn btn-primary" style="margin-top:20px" type="submit"><?php _e("addPage"); ?></button>
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
$.ajax({
    type: form.attr("method"),
    url: form.attr("action"),
    data: form.serialize(),
    success: function(data) {
        data = JSON.parse(data);
        if(data.success) {
            toastr.success(data.message);
            setTimeout(function() {
            window.location.href = "./admin/pages";
            }, 2000);
        }
        else {
        toastr.error(data.message);
        }
    }
    });
});
</script>