<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
<script src="assets/admin/vendor/toastr/toastr.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<style>.ql-editor{min-height:250px;}</style>
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<form action="" method="post" id="editForm" enctype="multipart/form-data">
    <span><?php _e("postTitle"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="title" class="form-control" value="<?php echo htmlentities($blog["title"]); ?>" required>
    </div>
    <span><?php _e("postMetaDesc"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="desc" class="form-control" value="<?php echo htmlentities($blog["description"]); ?>">
    </div>
    <span><?php _e("postMetaTags"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="tags" class="form-control" value="<?php echo htmlentities($blog["tags"]); ?>">
    </div>
    <span><?php _e("postImage"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="file" name="image" accept="image/*" class="form-control" style="padding:4.5px">
        <small><?php _e("keepEmptyText"); ?></small>
    </div>
    <span><?php _e("postContent"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <div class="editor"><?php echo $blog["content"]; ?></div>
    </div>
    <input class="btn btn-primary" name="update" value="<?php _e("editBlog"); ?>" style="margin-top:20px" type="submit">
    <input class="btn btn-danger" name="delete" value="<?php _e("deleteBlog"); ?>" style="margin-top:20px" type="submit">
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
            window.location.href = "./admin/blogs/<?php echo $blog["id"]; ?>";
            }, 2000);
        }
        else {
        toastr.error(data.message);
        }
    }
    });
});
</script>