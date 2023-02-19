<?php defined("SITE_URL") or die(); ?>
<link rel="stylesheet" href="assets/admin/vendor/toastr/toastr.min.css">
<script src="assets/admin/vendor/toastr/toastr.min.js"></script>
<link rel="stylesheet" href="assets/admin/css/dataTables.bootstrap.min.css">
<style>
table.dataTable.table thead th.sorting:after,table.dataTable.table thead td.sorting:after{
    content:"\f0dc";
    color:#ddd;
    font-size:0.8em;
    font-family: FontAwesome;
}
table.dataTable.table thead th.sorting_asc:after,table.dataTable.table thead td.sorting_asc:after{
    content:"\f0de";
    font-family: FontAwesome;
}
table.dataTable.table thead th.sorting_desc:after,table.dataTable.table thead td.sorting_desc:after{
    content:"\f0dd";
    font-family: FontAwesome;
}
</style>
<div class="modal fade" id="detailsModal" role="dialog">
    <div class="modal-dialog">
          <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php _e("contactMessage"); ?></h4>
        </div>
        <div class="modal-body">
          <p><b><?php _e("messageSender"); ?>: </b><span id="messageSender"></span><br/>
          <b><?php _e("messageSubject"); ?>: </b><span id="messageSubject"></span><br/>
          <b><?php _e("messageContent"); ?>: </b><span id="messageContent"></span><br/>
          <b><?php _e("messageDate"); ?>: </b><span id="messageDate"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("close"); ?></button>
        </div>
      </div>
      
    </div>
</div>
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<table id="messagesTable" class="table table-striped dataTable" style="width:100%" data-read="<?php _e("read"); ?>">
    <thead>
        <th><?php _e("id"); ?></th>
        <th><?php _e("messageSubject"); ?></th>
        <th><?php _e("messageDate"); ?></th>
        <th><?php _e("messageStatus"); ?></th>
        <th><?php _e("action"); ?></th>
    </thead>
    <tbody>
        <?php foreach($contact_messages as $message): ?>
        <tr class="d-flex align-items-center">
            <td style="vertical-align:middle;width:10%;white-space:nowrap;"><?php echo $message["id"]; ?></td>
            <td style="vertical-align:middle"><?php echo $message["subject"]; ?></td>
            <td style="vertical-align:middle"><?php echo date("d/m/Y H:i", strtotime($message["created_at"])); ?></td>
            <td style="vertical-align:middle"><?php $message["seen"] == 1 ? _e("read") : _e("unread") ; ?></td>
            <td style="vertical-align:middle;width:1%;white-space:nowrap;">
                <button class="btn btn-sm btn-success" onclick="showMessage(this,<?php echo $message["seen"]; ?>,<?php echo $message["id"]; ?>,'<?php echo rawurlencode($message["name"]." (".$message["email"].")"); ?>','<?php echo rawurlencode($message["subject"]); ?>','<?php echo rawurlencode(nl2br($message["message"])); ?>','<?php echo date("d/m/Y H:i", strtotime($message["created_at"])); ?>')"><i class="fa fa-eye" style="margin-right:1rem"></i><?php _e("view"); ?></button>
                <button class="btn btn-sm btn-danger" onclick="deleteMessage(<?php echo $message["id"]; ?>)"><i class="fa fa-trash" style="margin-right:1rem"></i><?php _e("delete"); ?></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
<script>
    function showMessage(e, seen, id, sender, subject, content, date) {
        $("#messageSender").text(decodeURIComponent(sender));
        $("#messageSubject").text(decodeURIComponent(subject));
        $("#messageContent").html(decodeURIComponent(content));
        $("#messageDate").text(decodeURIComponent(date));
        $("#detailsModal").modal();
        if(seen == 0) {
            $.post("./admin/contact-form", {seen:1,id:id}, function() {
                $(e).parent().parent().find("td:eq(3)").text($("#messagesTable").data("read"));
            });
        }
    }
    function deleteMessage(id) {
        $.post("./admin/contact-form", {delete:1,id:id}, function(data) {
            if(typeof data !== 'object') {
                data = JSON.parse(data);
            }
            if(data.success) {
                toastr.success(data.message);
                setTimeout(function() {
                    window.location.href = "./admin/contact-form";
                }, 2000);
            }
            else {
                toastr.error(data.message);
            }
        });
    }
    $(function() {
        $.fn.DataTable.ext.pager.numbers_length = 5;
        $(".dataTable").DataTable({
            "order": [[0, "desc"]],
            "scrollX": true,
            "language": {
                "url": "assets/admin/vendor/datatables/<?php echo $Configs["language"]; ?>.json"
            }
        });
    });
</script>
<script src="assets/admin/scripts/jquery.dataTables.min.js"></script>
<script src="assets/admin/scripts/dataTables.bootstrap.min.js"></script>