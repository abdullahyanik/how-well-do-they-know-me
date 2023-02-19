<?php defined("SITE_URL") or die(); ?>
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
<div class="panel panel-headline">
<div class="panel-body" style="padding-top:20px">
<table class="table table-striped dataTable" style="width:100%">
    <thead>
        <th><?php _e("id"); ?></th>
        <th><?php _e("questionText"); ?></th>
        <th><?php _e("questionLanguage"); ?></th>
        <th><?php _e("action"); ?></th>
    </thead>
    <tbody>
        <?php foreach($questions as $question): ?>
        <tr class="d-flex align-items-center">
            <td style="vertical-align:middle;width:10%;white-space:nowrap;"><?php echo $question["id"]; ?></td>
            <td style="vertical-align:middle"><?php echo $question["text"]; ?></td>
            <td style="vertical-align:middle"><?php echo isset($Configs["languages"][$question["lang"]]) ? $Configs["languages"][$question["lang"]] : "-"; ?></td>
            <td style="vertical-align:middle;width:1%;white-space:nowrap;">
                <a href="./admin/questions/<?php echo $question["id"]; ?>">
                    <button class="btn btn-sm btn-info"><i class="fa fa-edit" style="margin-right:1rem"></i><?php _e("edit"); ?></button>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="./admin/questions/add" style="margin-top:20px;display:block"><button class="btn btn-primary"><?php _e("addQuestion"); ?></button></a>
</div>
</div>
<script>
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