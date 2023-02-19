<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
<script src="assets/admin/vendor/toastr/toastr.min.js"></script>
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<form action="" method="post" id="editForm" enctype="multipart/form-data">
    <span><?php _e("questionText"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <input type="text" name="text" class="form-control" value="<?php echo htmlentities($question["text"]); ?>" required>
    </div>
    <span><?php _e("questionLanguage"); ?>:</span>
    <div style="margin-top:10px;margin-bottom:20px">
        <select name="language" class="form-control" required>
            <?php foreach($Configs["languages"] as $i=>$language): ?>
            <option value="<?php echo $i; ?>" <?php echo $question["lang"] == $i ? "selected" : ""; ?>><?php echo $language; ?></option>
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
                    <?php $answers = json_decode($question["answers"], true); ?>
                    <tr>
                        <td style="vertical-align:middle">1</td>
                        <td style="vertical-align:middle;padding-left:0"><input placeholder="<?php _e("enterAnswerText"); ?>" type="text" class="form-control" name="answer[]" required value="<?php echo isset($answers[0]) ? $answers[0]["text"] : ""; ?>"></td>
                        <td style="vertical-align:middle"><input type="file" accept="image/*" name="image[]"></td>
                        <td><button class="btn btn-danger btn-remove" disabled type="button"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle">2</td>
                        <td style="vertical-align:middle;padding-left:0"><input placeholder="<?php _e("enterAnswerText"); ?>" type="text" class="form-control" name="answer[]" required value="<?php echo isset($answers[1]) ? $answers[1]["text"] : ""; ?>"></td>
                        <td style="vertical-align:middle"><input type="file" accept="image/*" name="image[]"></td>
                        <td><button class="btn btn-danger" disabled type="button"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <?php foreach($answers as $i => $answer): ?>
                    <?php if($i > 1): ?>
                    <tr>
                        <td style="vertical-align:middle"><?php echo $i+1; ?></td>
                        <td style="vertical-align:middle;padding-left:0"><input placeholder="<?php _e("enterAnswerText"); ?>" type="text" class="form-control" name="answer[]" required value="<?php echo $answers[$i]["text"]; ?>"></td>
                        <td style="vertical-align:middle"><input type="file" accept="image/*" name="image[]"></td>
                        <td><button class="btn btn-danger" type="button" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
        </table>
        </div>
    </div>
    <div><small><?php _e("editQuestionInfo"); ?></small></div>
    <input class="btn btn-primary" name="update" value="<?php _e("editQuestion"); ?>" style="margin-top:20px" type="submit">
    <button class="btn btn-success" id="addAnswer" style="margin-top:20px" type="button"><?php _e("addAnswer"); ?></button>
    <input class="btn btn-danger" name="delete" value="<?php _e("deleteQuestion"); ?>" style="margin-top:20px" type="submit">
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
$("#editForm input[type='submit']").click(function(e) {
e.preventDefault();
var form = $("#editForm");
$("<input>").attr({type: "hidden", name: $(this).attr("name"), value: "1"}).appendTo(form);
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
            window.location.href = "./admin/questions/<?php echo $question["id"]; ?>";
            }, 2000);
        }
        else {
        toastr.error(data.message);
        }
    }
    });
});
</script>