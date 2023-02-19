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
        <th><?php _e("postTitle"); ?></th>
        <th><?php _e("postDate"); ?></th>
        <th><?php _e("action"); ?></th>
    </thead>
    <tbody>
        <?php foreach($blogs as $blog): ?>
        <tr class="d-flex align-items-center">
            <td style="vertical-align:middle;width:10%;white-space:nowrap;"><?php echo $blog["id"]; ?></td>
            <td style="vertical-align:middle"><?php echo $blog["title"]; ?></td>
            <td style="vertical-align:middle"><?php echo date("d/m/Y H:i", strtotime($blog["created_at"])); ?></td>
            <td style="vertical-align:middle;width:1%;white-space:nowrap;">
                <a href="./blog/<?php echo $blog["slug"]."-".$blog["id"]; ?>" target="_blank">
                    <button class="btn btn-sm btn-success"><i class="fa fa-eye" style="margin-right:1rem"></i><?php _e("view"); ?></button>
                </a>
                <a href="./admin/blogs/<?php echo $blog["id"]; ?>">
                    <button class="btn btn-sm btn-info"><i class="fa fa-edit" style="margin-right:1rem"></i><?php _e("edit"); ?></button>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="./admin/blogs/add" style="margin-top:20px;display:block"><button class="btn btn-primary"><?php _e("addBlog"); ?></button></a>
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