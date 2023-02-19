<?php defined("SITE_URL") or die(); ?>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?php echo SITE_URL; ?>" itemid="<?php echo SITE_URL; ?>" itemscope itemtype="https://schema.org/WebPage" itemprop="item"><span itemprop="name"><?php _e("homePage"); ?></span></a>
                <meta itemprop="position" content="1" />
            </li>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?php echo SITE_URL; ?>blog" itemid="<?php echo SITE_URL; ?>blog" itemscope itemtype="https://schema.org/WebPage" itemprop="item"><span itemprop="name"><?php _e("blog"); ?></span></a>
                <meta itemprop="position" content="2" />
            </li>
            <li class="breadcrumb-item text-truncate" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name"><?php echo $blog["title"]; ?></span>
                <meta itemprop="position" content="3" />
            </li>
        </ol>
        </nav>
        <div class="card">
        <?php if(file_exists(realpath("./assets/img/uploads/blogs")."/".$blog["id"].".jpg")): ?>
            <img class="card-img-top" style="height:300px" src="<?php echo "assets/img/uploads/blogs/".$blog["slug"]."-".$blog["id"].".jpg"; ?>" alt="<?php echo htmlentities($blog["title"]); ?>">
        <?php endif; ?>
        <div class="card-body">
            <h3 class="mb-1 card-title"><?php echo $blog["title"]; ?></h3>
            <div class="badge badge-primary my-2"><i class="fas fa-calendar mr-1"></i> <span><?php echo date("d/m/Y H:i", strtotime($blog["created_at"])); ?></span></div>
            <p class="card-text mt-1">
            <?php
                $ps = explode("</p>", $blog["content"]);
                if(count($ps) > 1) {
                    $ps[1] = "<div>".$Configs["post_ad"]."<p></p></div>".$ps[1];
                }
                echo join("</p>", $ps);
            ?>
            </p>
        </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <div id="disqus_thread"></div>
            </div>
        </div>
        </div>
        <div class="col-lg-4">
            <?php include(realpath(__DIR__)."/sidebar.php"); ?>
        </div>
    </div>
</div>
<script src="https://<?php echo $Configs["disqus_username"]; ?>.disqus.com/embed.js" data-timestamp="<?php echo time(); ?>"></script>