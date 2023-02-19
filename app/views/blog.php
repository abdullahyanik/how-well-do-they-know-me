<?php defined("SITE_URL") or die(); ?>
<div class="py-5" style="background:#f9f9f9">
    <div class="container my-1 text-center">
        <h1 class="mb-0"><?php _e("blog"); ?></h1>
    </div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <?php if(count($blogs) != 0): ?>
                <?php foreach($blogs as $blog): ?>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <a href="./blog/<?php echo $blog["slug"]."-".$blog["id"]; ?>"><img class="card-img-top" src="<?php echo file_exists("./assets/img/uploads/blogs"."/".$blog["id"].".jpg") ? "assets/img/uploads/blogs/".$blog["slug"]."-".$blog["id"].".jpg" : "assets/img/uploads/blogs/default.jpg"; ?>" alt="<?php echo htmlentities($blog["title"]); ?>"></a>
                        <div class="card-body">
                            <a href="./blog/<?php echo $blog["slug"]."-".$blog["id"]; ?>"><h5 class="mb-1 card-title text-truncate"><?php echo $blog["title"]; ?></h5></a>
                            <div class="badge badge-primary my-2"><i class="fas fa-calendar mr-1"></i> <span><?php echo date("d/m/Y", strtotime($blog["created_at"])); ?></span></div>
                            <p class="card-text mt-1"><?php echo strlen(strip_tags($blog["content"])) > 150 ? substr(strip_tags($blog["content"]), 0, 147)."..." : strip_tags($blog["content"]) ?></p>
                            <a href="./blog/<?php echo $blog["slug"]."-".$blog["id"]; ?>" class="btn btn-primary btn-sm"><?php _e("readMore"); ?></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <h5><?php _e("noBlogsFound"); ?></h5>
                <?php endif; ?>
            </div>
            <?php 
					if(count($blogs) != 0):
                    ?>
                    <nav>
                        <ul class="pagination justify-content-center mt-1">
                            <li class="page-item">
                            <a class="page-link" href="./blog?page=<?php echo $page == 1 ? 1 : $page-1; ?>">
                                <span aria-hidden="true"><i class="fas fa-angle-left"></i></span>
                            </a>
                            </li>
                            <?php foreach($pages as $p): ?>
                            <li class="page-item <?php echo $p == $page ? "active" : ""; ?>"><a class="page-link" href="./blog?page=<?php echo $p; ?>"><?php echo $p; ?></a></li>
                            <?php endforeach; ?>
                            <li class="page-item">
                            <a class="page-link" href="./blog?page=<?php echo $page == $total_pages ? $total_pages : $page+1; ?>">
                                <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                            </a>
                            </li>
                        </ul>
                    </nav>
				<?php endif; ?>
        </div>
        <div class="col-lg-4">
            <?php include(realpath(__DIR__)."/sidebar.php"); ?>
        </div>
    </div>
</div>