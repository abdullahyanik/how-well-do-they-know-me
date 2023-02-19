<?php defined("SITE_URL") or die(); ?>
<div class="card mt-4 mt-lg-0">
<div class="card-body">
    <?php echo $Configs["sidebar_ad"]; ?>
</div>
</div>
<?php if(count($random_blogs) > 0): ?>
<div class="card mt-4">
<div class="card-body">
<div class="row align-items-center">
    <div class="col">
        <h4 class="mb-0"><?php _e("randomPosts"); ?></h4>
    </div>
    <div class="col-auto">
        <i class="fas fa-fire fa-2x text-primary"></i>
    </div>
</div>
<?php foreach($random_blogs as $blog): ?>
<hr>
<a href="./blog/<?php echo $blog["slug"]."-".$blog["id"]; ?>">
<div class="row">
    <div class="col">
        <h5><?php echo strlen($blog["title"]) > 20 ? substr($blog["title"], 0, 17)."..." : $blog["title"] ?></h5>
        <small class="text-dark"><?php echo strlen(strip_tags($blog["content"])) > 50 ? substr(strip_tags($blog["content"]), 0, 47)."..." : strip_tags($blog["content"]) ?></small>
    </div>
    <div class="col-auto">
        <img class="rounded" src="<?php echo file_exists("./assets/img/uploads/blogs"."/".$blog["id"].".jpg") ? "assets/img/uploads/blogs/".$blog["slug"]."-".$blog["id"].".jpg" : "assets/img/uploads/blogs/default.jpg"; ?>" style="height:75px;width:75px;">
    </div>
</div>
</a>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>