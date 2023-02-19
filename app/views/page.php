<?php defined("SITE_URL") or die(); ?>
<div class="py-5" style="background:#f9f9f9">
    <div class="container my-1 text-center">
        <h1 class="mb-0"><?php echo $title; ?></h1>
    </div>
</div>
<div class="container my-5">
    <div class="card p-4 page-content">
        <?php echo $page["content"]; ?>
    </div>
</div>