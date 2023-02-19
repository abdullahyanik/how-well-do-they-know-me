<?php defined("SITE_URL") or die(); ?>
<!DOCTYPE html>
<html lang="<?php echo $Configs["language"]; ?>">

<head>
    <base href="<?php echo SITE_URL; ?>">
    <meta charset="utf-8">
    <meta name="theme-color" content="#eda11e">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <title><?php echo $title; ?></title>
    <?php if(is_null($p)): ?>
    <meta name="description" content="<?php echo htmlentities($Configs["description"]); ?>">
    <meta name="keywords" content="<?php echo htmlentities($Configs["tags"]); ?>">
    <meta property="og:type" content="website">
    <?php else: ?>
    <meta name="description" content="<?php echo htmlentities($p["description"]); ?>">
    <meta name="keywords" content="<?php echo htmlentities($p["tags"]); ?>">
    <meta property="og:type" content="article">
    <?php if(isset($p["type"]) && $p["type"] == "blog"): ?>
    <meta property="og:image" content="<?php echo SITE_URL; ?>assets/img/uploads/blogs/<?php echo file_exists(realpath("./assets/img/uploads/blogs")."/".$p["id"].".jpg") ? $p["slug"]."-".$p["id"].".jpg" : "default.jpg"; ?>"/>
    <?php endif; ?>  
    <meta property="og:description" content="<?php echo htmlentities($p["description"]); ?>">
    <?php endif; ?>
    <meta property="og:title" content="<?php echo $title; ?>">
    <meta property="og:url" content="<?php echo "http".(($_SERVER['SERVER_PORT'] == 443) ? "s" : "")."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">  
    <meta property="og:site_name" content="<?php echo htmlentities($Configs["title"]); ?>">  
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800|Roboto:400,500,700" rel="stylesheet">
    <link type="text/css" href="assets/css/theme.css" rel="stylesheet">
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <?php echo $Configs["extra_header"]; ?>
</head>

<body>
<div id="preloader"></div>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
    <a class="navbar-brand" href="./"><img src="assets/img/logo.png" alt="<?php echo $Configs["title"]; ?>"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_main" aria-controls="navbar_main" aria-expanded="false" aria-label="Nav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar_main">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item <?php echo $page == "home" ? "active" : ""; ?>">
                <a class="nav-link" href="./"><i class="fas fa-home mr-1"></i><?php _e("homePage"); ?></a>
            </li>
            <li class="nav-item <?php echo $page == "createQuiz" ? "active" : ""; ?>">
                <a class="nav-link" href="./create-quiz"><i class="fas fa-pencil-alt mr-1"></i><?php _e("createQuiz"); ?></a>
            </li>
            <li class="nav-item <?php echo $page == "blog" ? "active" : ""; ?>">
                <a class="nav-link" href="./blog"><i class="fas fa-rss mr-1"></i><?php _e("blog"); ?></a>
            </li>
            <li class="nav-item <?php echo $page == "contact" ? "active" : ""; ?>">
                <a class="nav-link" href="./contact"><i class="fas fa-phone-alt mr-1"></i><?php _e("contact"); ?></a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img style="height:1rem;border-radius:3px" class="mr-2" src="./assets/img/flags/<?php echo $Configs["language"]; ?>.svg" alt="<?php echo $Configs["languages"][$Configs["language"]]; ?>"><?php echo $Configs["languages"][$Configs["language"]]; ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php foreach($Configs["languages"] as $i=>$lang): ?>
                <a class="dropdown-item <?php echo $i == $Configs["language"] ? "active" : ""; ?>" href="?lang=<?php echo $i; ?>"><img style="height:1rem;border-radius:3px" class="mr-2" src="./assets/img/flags/<?php echo $i; ?>.svg" alt="<?php echo $lang; ?>"><?php echo $lang; ?></a>
            <?php endforeach; ?>
            </div>
            </li>
        </ul>
    </div>
    </div>
</nav>
<main>