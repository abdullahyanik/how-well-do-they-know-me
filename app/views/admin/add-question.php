<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
<script src="assets/admin/vendor/toastr/toastr.min.js"></script>
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<form action="" method="post" id="addForm" enctype="multipart/form-data">
    <span><?php _e("questionText"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="text" class="form-control" required>
    </div>
    <span><?php _e("questionLanguage"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <select name="language" class="form-control" required>
            <?php foreach($Configs["languages"] as $i=>$language): ?>
            <option value="<?php echo $i; ?>"><?php echo $language; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <span><?php _e("questionAnswers"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <div class="table-responsive">
        <table class="table" id="questionAnswers">
                <thead style="background:#f9f9f9">
                    <tr>
                        <th><?php _e("id"); ?></th>
                        <th style="padding-left:0"><?php _e("answerText"); ?></th>
                        <th><?php _e("answerImage"); ?></th>
                        <th><?php _e("action"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="vertical-align:middle">1</td>
                        <td style="vertical-align:middle;padding-left:0"><input placeholder="<?php _e("enterAnswerText"); ?>" type="text" class="form-control" name="answer[]" required></td>
                        <td style="vertical-align:middle"><input type="file" accept="image/*" name="image[]"></td>
                        <td><button class="btn btn-danger btn-remove" disabled type="button"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle">2</td>
                        <td style="vertical-align:middle;padding-left:0"><input placeholder="<?php _e("enterAnswerText"); ?>" type="text" class="form-control" name="answer[]" required></td>
                        <td style="vertical-align:middle"><input type="file" accept="image/*" name="image[]"></td>
                        <td><button class="btn btn-danger btn-remove" disabled type="button"><i class="fa fa-trash"></i></button></td>
                    </tr>
                </tbody>
        </table>
        </div>
    </div>
    <button class="btn btn-primary" style="margin-top:20px" type="submit"><?php _e("addQuestion"); ?></button>
    <button class="btn btn-success" id="addAnswer" style="margin-top:20px" type="button"><?php _e("addAnswer"); ?></button>
</form>
</div>
</div>
<script>
$("body").on("click", ".btn-remove", function(e) {
    $(this).parent().parent().remove();
    $.each($("#questionAnswers tbody tr"), function(i) {
        $("#questionAnswers tbody tr:eq("+i+") td:eq(0)").text(i+1);
    });
});
$("#addAnswer").click(function() {
    var t = $("<tr>"+$("#questionAnswers tbody tr:eq(0)").html()+"</tr>");
    t.find("input").val("");
    t.find(".btn-remove").attr("disabled", false);
    t.find("td:eq(0)").text($("#questionAnswers tbody tr").length+1);
    $("#questionAnswers tbody").append(t);
});
$("#addForm").submit(function(e) {
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
            window.location.href = "./admin/questions";
            }, 2000);
        }
        else {
        toastr.error(data.message);
        }
    }
    });
});
</script>