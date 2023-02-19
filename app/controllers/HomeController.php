<?php
class HomeController extends Controller {
    public $HomeModel;
    private $View;
    public $Strings;
    function __construct() {
        parent::__construct();
        $this->HomeModel = new HomeModel();
        if(!$this->is_bot()) {
        if(isset($_GET["lang"]) && isset($this->configs["languages"][$_GET["lang"]])) {
            setcookie("language", $_GET["lang"], time() + (86400*30));
            $this->configs["language"] = $_GET["lang"];
        }
        else {
        if(isset($_COOKIE["language"]) && isset($this->configs["languages"][$_COOKIE["language"]])) {
            $this->configs["language"] = $_COOKIE["language"];
        }
        else {
            $lang = $this->prefered_language(array_keys($this->configs["languages"]), $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
            if(count(array_keys($lang)) > 0) {
                $lang = array_keys($lang)[0];
                setcookie("language", $lang, time() + (86400*30));
                $this->configs["language"] = $lang;
            }
            else {
                setcookie("language", $this->configs["language"], time() + (86400*30));
            }
        }
        }
        }
        $this->Strings = new Strings($this->configs["language"]);
        $this->View = new View($this->configs);
    }
    public function render($page, $args = []) {
        ob_start(function($b){return preg_replace(['/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s'],['>','<','\\1'],$b);});
        $this->View->render("header", [
            "title" => isset($args["title"]) ? $args["title"]." - ".$this->configs["title"] : ($page == "home" ? $this->configs["title"]." - ".$this->Strings->g("quizYourMate") : $this->Strings->g($page)." - ".$this->configs["title"]),
            "page" => $page,
            "p" => isset($args["page"]) && isset($args["page"]["id"]) ? $args["page"] : (isset($args["blog"]) ? $args["blog"] : null)
        ]);
        $this->View->render($page, $args);
        $this->View->render("footer", [
            "page" => $page
        ]);
    }
    public function index() {
        $this->render("home");
    }
    public function blog() {
        $AdminModel = new AdminModel();
        $posts_per_page = 4;
        $total_pages = ceil($this->HomeModel->getBlogsCount() / $posts_per_page);
        $page = 1;
        if(isset($_GET["page"]) && is_numeric($_GET["page"]) && intval($_GET["page"]) > 0 && intval($_GET["page"]) <= $total_pages) {
            $page = intval($_GET["page"]);
        }
        $start = ($page - 1) * $posts_per_page;
        $pages = [];
        if($total_pages > 3) {
        if($page == 1) {
            array_push($pages, 1, 2, 3); 
        }
        else if($page == $total_pages) {
            array_push($pages, $total_pages-2,$total_pages-1,$total_pages);
        }
        else {
            array_push($pages, $page-1, $page, $page+1);
        }
        }
        else {
            for($i = 0; $i < $total_pages; $i++) {
                array_push($pages, $i+1);
            }
        }
        $blogs = $this->HomeModel->getBlogs($start, $posts_per_page);
        foreach($blogs as $i=>$blog) {
            $blogs[$i]["slug"] = $AdminModel->createSlug($blog["title"]);
        }
        $random_blogs = $this->HomeModel->getRandomBlogs(3);
        foreach($random_blogs as $i=>$b) {
            $random_blogs[$i]["slug"] = $AdminModel->createSlug($b["title"]);
        }
        $this->render("blog", [
            "blogs" => $blogs,
            "total_pages" => $total_pages,
            "page" => $page,
            "pages" => $pages,
            "random_blogs" => $random_blogs
        ]);
    }
    function blog_post($id) {
        $id = explode("-", $id);
        $id = intval(end($id));
        $blog = $this->HomeModel->getBlog($id);
        if(isset($blog["id"])) {
            $AdminModel = new AdminModel();
            $blog["slug"] = $AdminModel->createSlug($blog["title"]);
            $blog["type"] = "blog";
            $random_blogs = $this->HomeModel->getRandomBlogs(3);
            foreach($random_blogs as $i=>$b) {
                $random_blogs[$i]["slug"] = $AdminModel->createSlug($b["title"]);
            }    
            $this->render("blog-post", [
                "title" => $blog["title"],
                "blog" => $blog,
                "random_blogs" => $random_blogs
            ]);
        }
        else {
            $this->four_zero_four();
        }
    }
    function page($slug) {
        $page = $this->HomeModel->getPageBySlug($slug);
        if(isset($page["id"])) {
            $this->render("page", [
                "title" => $page["title"],
                "page" => $page
            ]);
        }
        else {
            $this->four_zero_four();
        }
    }
   
    public function create_quiz() {        
        $this->render("createQuiz", [
            "questions" => $this->HomeModel->getRandomQuestions(50, $this->configs["language"])
        ]);
    }
    public function share_quiz($id) {
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $id)) {
            $this->four_zero_four();
        }
        else {
            $this->render("shareQuiz", [
                "shortcode" => $id
            ]);
        }   
    }
    public function view_quiz($id) {
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $id)) {
            $this->four_zero_four();
        }
        else {
            $quiz = $this->HomeModel->getQuizByShortcode($id);
            if(isset($quiz["id"])) {
                $questions = [];
                $answers = [];
                foreach(json_decode($quiz["questions"], true) as $question) {
                    $question_id = array_keys($question)[0];
                    array_push($questions, $question_id);
                    array_push($answers, $question[$question_id]);
                }
                $questions = $this->HomeModel->getQuestions($questions);
                foreach($questions as $i=>$question) {
                    $questions[$i]["answer"] = $answers[$i];
                }
                $quiz["questions"] = $questions;
                $quiz["scores"] = $this->HomeModel->getQuizScores($quiz["id"]);
                $this->render("friendQuiz", [
                    "quiz" => $quiz
                ]);
            }
            else {
                $this->four_zero_four();
            } 
        }   
    }
    public function create_quiz_post() {
        if(isset($_POST["username"]) && isset($_POST["questions"]) && $this->HomeModel->isJson($_POST["questions"])) {
            $shortcode = $this->HomeModel->generateRandomString();
            while(isset($this->HomeModel->getQuizByShortcode($shortcode)["id"])) {
                $shortcode = $this->HomeModel->generateRandomString();
            }
            if($this->HomeModel->insertQuiz(strip_tags($_POST["username"]), $_POST["questions"], $shortcode) != 0) {
                setcookie($shortcode, "1", time() + 77760000);
                echo json_encode([
                    "success" => true,
                    "shortcode" => $shortcode
                ]);
            }
        }
    }
    public function answer_quiz($id) {
        if(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $id)) {
            if(isset($_POST["username"]) && isset($_POST["score"]) && is_numeric($_POST["score"])) {
                $quiz = $this->HomeModel->getQuizByShortcode($id);
                $username = strip_tags($_POST["username"]);
                $score = intval($_POST["score"]);
                if(isset($quiz["id"]) && $score <= count(json_decode($quiz["questions"], true))) {
                    if($this->HomeModel->insertQuizScore($username, $score,  $quiz["id"])) {
                        setcookie($id, $username."=".$score, time() + 77760000);
                        echo json_encode(["success"=>true]);
                    }
                }
            }
        }
    }
    public function contact_page() {
        $this->render("contact");
    }
    public function about_page() {
        $this->render("about");
    }
    public function privacy_page() {
        $this->render("privacyPolicy");
    }
    public function cookie_page() {
        $this->render("cookiePolicy");
    }
    public function terms_page() {
        $this->render("termsOfUse");
    }
    public function sitemap() {
        $AdminModel = new AdminModel();
        header("Content-Type: text/xml");
        $pages = $this->HomeModel->getPages();
        $blogs = $this->HomeModel->getBlogs(0, 45000);
        foreach($blogs as $i=>$blog) {
            $blogs[$i]["slug"] = $AdminModel->createSlug($blog["title"]);
        }
        echo '<?'; ?>xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd">
            <url>
                <loc><?php echo SITE_URL; ?></loc>
                <lastmod><?php echo date("c", 1593216000); ?></lastmod>
            </url>
            <url>
                <loc><?php echo SITE_URL; ?>create-quiz</loc>
                <lastmod><?php echo date("c", 1593216000); ?></lastmod>
            </url>
            <url>
                <loc><?php echo SITE_URL; ?>blog</loc>
                <lastmod><?php echo date("c", 1593216000); ?></lastmod>
            </url>
            <url>
                <loc><?php echo SITE_URL; ?>contact</loc>
                <lastmod><?php echo date("c", 1593216000); ?></lastmod>
            </url>
            <?php foreach($pages as $page): ?>
            <url>
                <loc><?php echo SITE_URL.$page["slug"]; ?></loc>
                <lastmod><?php echo date("c", 1593216000); ?></lastmod>
            </url>
            <?php endforeach; ?>
            <?php foreach($blogs as $blog): ?>
            <url>
                <loc><?php echo SITE_URL."blog/".$blog["slug"]."-".$blog["id"]; ?></loc>
                <lastmod><?php echo date("c", strtotime($blog["created_at"])); ?></lastmod>
            </url>
            <?php endforeach; ?>
        </urlset>
<?php }
    public function contact_post() {
        if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["message"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            if($this->validateRecaptcha($_POST["g-recaptcha-response"])) {
                if($this->HomeModel->insertContactMessage(strip_tags($_POST["name"]), strip_tags($_POST["email"]), strip_tags($_POST["subject"]), strip_tags($_POST["message"])) != 0) {
                    echo json_encode([
                        "success" => true,
                        "title" => $this->Strings->g("messageSent"),
                        "message" => $this->Strings->g("messageSentText")
                    ]);
                }
                else {
                    echo json_encode([
                        "success" => false,
                        "title" => $this->Strings->g("error"),
                        "message" => $this->Strings->g("unknownError")
                    ]);
                }
            }
            else {
                echo json_encode([
                    "success" => false,
                    "title" => $this->Strings->g("error"),
                    "message" => $this->Strings->g("recaptchaFailed")
                ]);
            }
        }
        else {
            echo json_encode([
                "success" => false,
                "title" => $this->Strings->g("error"),
                "message" => $this->Strings->g("fillAllFields")
            ]);
        }
    }
    public function four_zero_four() {
        http_response_code(404);
        $this->View->render("404");
    }
}
?>