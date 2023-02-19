<?php
require_once 'core/autoload.php';
require_once 'core/config.php';

if(SITE_URL == '%BASEURL%') {
    header('Location: ./install');
    exit;
}

$base_path = isset($_SERVER['SERVER_NAME']) ? explode($_SERVER['SERVER_NAME'], SITE_URL)[1] : '/';

$Router = new Router($base_path);

$HomeController = new HomeController();

$Router->get('/', [$HomeController, 'index']);
$Router->get('/sitemap.xml', [$HomeController, 'sitemap']);

$Router->get('/admin', function() {(new AdminController())->index();});

$Router->get('/admin/questions', function() {(new AdminController())->questions();});
$Router->get('/admin/questions/add', function() {(new AdminController())->add_question();});
$Router->get('/admin/questions/:id', function($id) {(new AdminController())->edit_question($id);});
$Router->get('/admin/pages', function() {(new AdminController())->pages();});
$Router->get('/admin/pages/add', function() {(new AdminController())->add_page();});
$Router->get('/admin/pages/:id', function($id) {(new AdminController())->edit_page($id);});
$Router->get('/admin/blogs', function() {(new AdminController())->blogs();});
$Router->get('/admin/blogs/add', function() {(new AdminController())->add_blog();});
$Router->get('/admin/blogs/:id', function($id) {(new AdminController())->edit_blog($id);});
$Router->get('/admin/contact-form', function() {(new AdminController())->contact_form();});
$Router->get('/admin/settings/:id', function($id) {(new AdminController())->settings($id);});

$Router->get('/admin/login', function() {(new AuthController())->login();});
$Router->get('/admin/logout', function() {(new AdminController())->logout();});

$Router->get('/create-quiz', [$HomeController, 'create_quiz']);
$Router->get('/blog', [$HomeController, 'blog']);
$Router->get('/privacy-policy', [$HomeController, 'privacy_page']);
$Router->get('/about', [$HomeController, 'about_page']);
$Router->get('/cookie-policy', [$HomeController, 'cookie_page']);
$Router->get('/terms-of-use', [$HomeController, 'terms_page']);
$Router->get('/blog/:id', [$HomeController, 'blog_post']);
$Router->get('/contact', [$HomeController, 'contact_page']);
$Router->get('/share/:id', [$HomeController, 'share_quiz']);
$Router->get('/quiz/:id', [$HomeController, 'view_quiz']);

$Router->post('/admin/login', function() {(new AuthController())->login_post();});
$Router->post('/create-quiz', [$HomeController, 'create_quiz_post']);
$Router->post('/quiz/:id', [$HomeController, 'answer_quiz']);
$Router->post('/contact', [$HomeController, 'contact_post']);
$Router->post('/admin/questions/add', function() {(new AdminController())->add_question_post();});
$Router->post('/admin/questions/:id', function($id) {(new AdminController())->edit_question_post($id);});
$Router->post('/admin/pages/add', function() {(new AdminController())->add_page_post();});
$Router->post('/admin/pages/:id', function($id) {(new AdminController())->edit_page_post($id);});
$Router->post('/admin/blogs/add', function() {(new AdminController())->add_blog_post();});
$Router->post('/admin/blogs/:id', function($id) {(new AdminController())->edit_blog_post($id);});
$Router->post('/admin/contact-form', function() {(new AdminController())->contact_form_post();});
$Router->post('/admin/settings', function() {(new AdminController())->settings_post();});

$Router->get('/:slug', [$HomeController, 'page']);

$Router->get('/assets/img/uploads/blogs/:slug', function($slug) {
    $slug = explode('-',explode('.jpg', $slug)[0]);
    $slug = intval(end($slug));
    $path = realpath(__DIR__.'/assets/img/uploads/blogs').'/'.$slug.'.jpg';
    if(file_exists($path)) {
        header("Content-type: image/jpeg");
        readfile($path);
    }
});

if(!$Router->run()) {
    // 404 - Page Not Found
    $HomeController->four_zero_four();
}
?>