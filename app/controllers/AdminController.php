<?php
class AdminController extends Controller {
    public $AdminModel;
    private $View;
    public $Strings;
    function __construct() {
        parent::__construct();
        $this->AdminModel = new AdminModel();
        $this->Strings = new Strings($this->configs["language"]);
        $this->View = new View($this->configs);
        if(!isset($_SESSION["admin"])) {
            header("Location:".SITE_URL."admin/login");
            exit;
        }
        else if($_SESSION["admin"] !== md5($this->configs["admin_username"].$this->configs["admin_password"])) {
            unset($_SESSION["admin"]);
            header("Location:".SITE_URL."admin/login");
            exit;
        }
    }
    public function index() {
        $update = [
            "version" => 1,
            "announcement" => "Tüm sistemler sorunsuz çalışmaktadır!",
            "announcement_date" => date("d/m/Y")
        ];
        $stats_data = [];
        $stats_data["labels"] = [];
        $stats_data["series"] = [];
        $stats = $this->AdminModel->get10DaysQuizStats();
        foreach($stats as $i=>$s) {
            $stats[$s["date"]] = $s["quiz_count"];
            unset($stats[$i]);
        }
        for ($i = 0; $i < 10; $i++)
        {
            setlocale(LC_ALL, strtolower($this->configs["language"])."_".strtoupper($this->configs["language"]).".utf8");
            $t = strtotime($i." days ago");
            array_push($stats_data["labels"], date("d M", $t));
            if(isset($stats[date("Y-m-d", $t)])) {
                array_push($stats_data["series"], $stats[date("Y-m-d", $t)]);
            }
            else {
                array_push($stats_data["series"], 0);
            }
        }
        $stats_data["labels"] = array_reverse($stats_data["labels"]);
        $stats_data["series"] = array_reverse($stats_data["series"]);
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("dashboard")
        ]);
        $this->View->render("admin/dashboard", [
            "totalQuizCount" => $this->AdminModel->getQuizCount(),
            "totalQuizAnswersCount" => $this->AdminModel->getQuizScoresCount(),
            "statsData" => $stats_data,
            "update" => $update
        ]);
        $this->View->render("admin/footer");
    }
    public function questions() {
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("questions")
        ]);
        $this->View->render("admin/questions", [
            "questions" => $this->AdminModel->getQuestions()
        ]);
        $this->View->render("admin/footer");
    }
    public function add_question() {
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("addQuestion")
        ]);
        $this->View->render("admin/add-question");
        $this->View->render("admin/footer");
    }
    public function edit_question($id) {
        $id = intval($id);
        $question = $this->AdminModel->getQuestion($id);
        if(!isset($question["id"])) {
            header("Location: ".SITE_URL."admin/questions");
            exit;
        }
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("editQuestion")
        ]);
        $this->View->render("admin/edit-question", [
            "question" => $question
        ]);
        $this->View->render("admin/footer");
    }
    public function pages() {
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("pages")
        ]);
        $this->View->render("admin/pages", [
            "pages" => $this->AdminModel->getPages()
        ]);
        $this->View->render("admin/footer");
    }
    public function add_page() {
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("addPage")
        ]);
        $this->View->render("admin/add-page");
        $this->View->render("admin/footer");
    }
    public function edit_page($id) {
        $id = intval($id);
        $page = $this->AdminModel->getPage($id);
        if(!isset($page["id"])) {
            header("Location: ".SITE_URL."admin/pages");
            exit;
        }
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("editPage")
        ]);
        $this->View->render("admin/edit-page", [
            "page" => $page
        ]);
        $this->View->render("admin/footer");
    }
    public function blogs() {
        $blogs = $this->AdminModel->getBlogs();
        foreach($blogs as $i=>$blog) {
            $blogs[$i]["slug"] = $this->AdminModel->createSlug($blog["title"]);
        }
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("blogPosts")
        ]);
        $this->View->render("admin/blogs", [
            "blogs" => $blogs
        ]);
        $this->View->render("admin/footer");
    }
    public function add_blog() {
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("addBlog")
        ]);
        $this->View->render("admin/add-blog");
        $this->View->render("admin/footer");
    }
    public function edit_blog($id) {
        $id = intval($id);
        $blog = $this->AdminModel->getBlog($id);
        if(!isset($blog["id"])) {
            header("Location: ".SITE_URL."admin/blogs");
            exit;
        }
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("editBlog")
        ]);
        $this->View->render("admin/edit-blog", [
            "blog" => $blog
        ]);
        $this->View->render("admin/footer");
    }
    public function contact_form() {
        $this->View->render("admin/header", [
            "title" => $this->Strings->g("contactMessages")
        ]);
        $this->View->render("admin/contact-form", [
            "contact_messages" => $this->AdminModel->getContactMessages()
        ]);
        $this->View->render("admin/footer");
    }
    public function settings($id) {
        if(!in_array($id, ["general","design","ads","profile"])) {
            header("Location: ".SITE_URL."admin");
            exit;
        } 
        $this->View->render("admin/header", [
            "title" => $this->Strings->g($id."Settings"),
            "settings" => $id
        ]);
        $this->View->render("admin/settings", [
            "page" => $id
        ]);
        $this->View->render("admin/footer");
    }
    public function add_question_post() {
        if(isset($_POST["text"]) && isset($_POST["language"]) && isset($this->configs["languages"][$_POST["language"]]) && isset($_POST["answer"])) {
            $answers = [];
            foreach($_POST["answer"] as $i=>$answer) {
                array_push($answers, [
                    "text" => $answer,
                    "image" => !empty($_FILES["image"]["tmp_name"][$i]) && exif_imagetype($_FILES["image"]["tmp_name"][$i]) == (IMAGETYPE_JPEG || IMAGETYPE_GIF || IMAGETYPE_PNG)
                ]);
            }
            $a = $this->AdminModel->insertQuestion($_POST["text"], $_POST["language"], json_encode($answers));
            if($a != 0) {
                for($i = 0; $i < count($_FILES["image"]["tmp_name"]); $i++) {
                    if($answers[$i]["image"]) {
                        $folder_path = realpath("./assets/img/uploads");
                        $img_name = $a."-".strval($i+1).".jpg";
                        $this->uploadJpeg($_FILES["image"]["tmp_name"][$i], $folder_path."/".$img_name);
                    }
                }
                echo json_encode([
                    "success" => true,
                    "message" => $this->Strings->g("addQuestionSuccess")
                ]);
            }
            else {
                echo json_encode([
                    "success" => false,
                    "message" => $this->Strings->g("unknownError")
                ]);
            }
        }
    }
    public function edit_question_post($id) {
            if(isset($_POST["update"])) {
                if(isset($_POST["text"]) && isset($_POST["language"]) && isset($this->configs["languages"][$_POST["language"]]) && isset($_POST["answer"])) {
                    $answers = [];
                    foreach($_POST["answer"] as $i=>$answer) {
                        array_push($answers, [
                            "text" => $answer,
                            "image" => !empty($_FILES["image"]["tmp_name"][$i]) && exif_imagetype($_FILES["image"]["tmp_name"][$i]) == (IMAGETYPE_JPEG || IMAGETYPE_GIF || IMAGETYPE_PNG)
                        ]);
                    }
                    $a = $this->AdminModel->updateQuestion($id, $_POST["text"], $_POST["language"], json_encode($answers));
                    foreach($answers as $i=>$answer) {
                        $folder_path = realpath("./assets/img/uploads");
                        $img_name = $id."-".strval($i+1).".jpg";
                        if(file_exists($folder_path."/".$img_name)) {
                            unlink($folder_path."/".$img_name);
                        }
                        if($answers[$i]["image"]) {
                            $this->uploadJpeg($_FILES["image"]["tmp_name"][$i], $folder_path."/".$img_name);
                        }
                    }
                    echo json_encode([
                        "success" => true,
                        "message" => $this->Strings->g("editQuestionSuccess")
                    ]);
                }
                else {
                    echo json_encode([
                        "success" => false,
                        "message" => $this->Strings->g("fillAllFields")
                    ]);
                }
            }
            else if(isset($_POST["delete"])) {
                $this->AdminModel->deleteQuestion(intval($id));
                echo json_encode([
                    "success" => true,
                    "message" => $this->Strings->g("deleteQuestionSuccess")
                ]);
            }
        else {
            echo json_encode([
                "success" => false,
                "message" => $this->Strings->g("fillAllFields")
            ]);
        }
    }
    public function add_page_post() {
        if(isset($_POST["title"]) && isset($_POST["content"])) {
            $a = $this->AdminModel->insertPage(strip_tags($_POST["title"]), strip_tags($_POST["desc"]), strip_tags($_POST["tags"]), $_POST["content"]);
            if($a["success"]) {
                if(isset($_POST["add_link"]) && $_POST["add_link"] == "1") {
                    $links = json_decode($this->configs["footer_links"], true);
                    array_push($links, [
                        "title" => strip_tags($_POST["title"]),
                        "url" => SITE_URL.$a["slug"]
                    ]);
                    $this->AdminModel->updateConfig("footer_links", json_encode($links));
                }
                echo json_encode([
                    "success" => true,
                    "message" => $this->Strings->g("addPageSuccess")
                ]);
            }
            else {
                echo json_encode([
                    "success" => false,
                    "message" => $this->Strings->g("unknownError")
                ]);
            }
        }
        else {
            echo json_encode([
                "success" => false,
                "message" => $this->Strings->g("fillAllFields")
            ]);
        }
    }
    public function edit_page_post($id) {
        if(isset($_POST["update"])) {
            if(isset($_POST["title"]) && isset($_POST["content"])) {
                $this->AdminModel->updatePage(intval($id), strip_tags($_POST["title"]), strip_tags($_POST["desc"]), strip_tags($_POST["tags"]), $_POST["content"]);
                echo json_encode([
                    "success" => true,
                    "message" => $this->Strings->g("editPageSuccess")
                ]);
            }
            else {
                echo json_encode([
                    "success" => false,
                    "message" => $this->Strings->g("fillAllFields")
                ]);
            }
        }
        else if(isset($_POST["delete"])) {
            $this->AdminModel->deletePage(intval($id));
            echo json_encode([
                "success" => true,
                "message" => $this->Strings->g("deletePageSuccess")
            ]);
        }
    }
    public function add_blog_post() {
        if(isset($_POST["title"]) && isset($_POST["content"])) {
            $a = $this->AdminModel->insertBlog(strip_tags($_POST["title"]), strip_tags($_POST["desc"]), strip_tags($_POST["tags"]), $_POST["content"]);
            if($a != 0) {
                if(!empty($_FILES["image"]["tmp_name"]) && exif_imagetype($_FILES["image"]["tmp_name"]) == (IMAGETYPE_JPEG || IMAGETYPE_GIF || IMAGETYPE_PNG)) {
                    $folder_path = realpath("./assets/img/uploads/blogs");
                    $img_name = strval($a).".jpg";
                    $this->uploadJpeg($_FILES["image"]["tmp_name"], $folder_path."/".$img_name);
                }
                echo json_encode([
                    "success" => true,
                    "message" => $this->Strings->g("addBlogSuccess")
                ]);
            }
            else {
                echo json_encode([
                    "success" => false,
                    "message" => $this->Strings->g("unknownError")
                ]);
            }
        }
        else {
            echo json_encode([
                "success" => false,
                "message" => $this->Strings->g("fillAllFields")
            ]);
        }
    }
    public function edit_blog_post($id) {
        if(isset($_POST["update"])) {
            if(isset($_POST["title"]) && isset($_POST["content"])) {
                $this->AdminModel->updateBlog(intval($id), strip_tags($_POST["title"]), strip_tags($_POST["desc"]), strip_tags($_POST["tags"]), $_POST["content"]);
                if(!empty($_FILES["image"]["tmp_name"]) && exif_imagetype($_FILES["image"]["tmp_name"]) == (IMAGETYPE_JPEG || IMAGETYPE_GIF || IMAGETYPE_PNG)) {
                    $folder_path = realpath("./assets/img/uploads/blogs");
                    $img_name = strval($id).".jpg";
                    $this->uploadJpeg($_FILES["image"]["tmp_name"], $folder_path."/".$img_name);
                }
                echo json_encode([
                    "success" => true,
                    "message" => $this->Strings->g("editBlogSuccess")
                ]);
            }
            else {
                echo json_encode([
                    "success" => false,
                    "message" => $this->Strings->g("fillAllFields")
                ]);
            }
        }
        else if(isset($_POST["delete"])) {
            $this->AdminModel->deleteBlog(intval($id));
            $path = realpath("./assets/img/uploads/blogs")."/".strval($id).".jpg";
            if(file_exists($path)) {
                unlink($path);
            }
            echo json_encode([
                "success" => true,
                "message" => $this->Strings->g("deleteBlogSuccess")
            ]);
        }
    }
    public function contact_form_post() {
        if(isset($_POST["id"])) {
            if(isset($_POST["delete"])) {
                $this->AdminModel->deleteContactMessage(intval($_POST["id"]));
                echo json_encode([
                    "success" => true,
                    "message" => $this->Strings->g("deleteContactMessageSuccess")
                ]);
            }
            elseif(isset($_POST["seen"])) {
                $this->AdminModel->seenContactMessage(intval($_POST["id"]));
            }
        }
    }
    public function settings_post() {
        if(isset($_POST["id"])) {
            if($_POST["id"] == "design") {
                $footer_links = [];
                foreach($_POST["footer_text"] as $i => $text) {
                    array_push($footer_links, [
                        "title" => $text,
                        "url" => $_POST["footer_link"][$i]
                    ]);
                }
                foreach(["logo","favicon"] as $image) {
                    if(!empty($_FILES[$image]["tmp_name"]) && exif_imagetype($_FILES[$image]["tmp_name"]) == (IMAGETYPE_JPEG || IMAGETYPE_GIF || IMAGETYPE_PNG)) {
                        $folder_path = realpath("./assets/img/");
                        $img_name = strval($image).".png";
                        $this->uploadPng($_FILES[$image]["tmp_name"], $folder_path."/".$img_name);
                    }
                }
                $this->AdminModel->updateConfig("footer_links", json_encode($footer_links));
            }
            else {
                foreach($_POST as $key => $value) {
                    if($key == "admin_password") {
                        $password =  hash("sha256", $value);
                        if(!empty($value) && $this->configs[$key] !== $password) {
                            $this->AdminModel->updateConfig($key, $password);
                        }
                    }
                    else {
                    if(isset($this->configs[$key]) && $this->configs[$key] !== $value) {
                        $this->AdminModel->updateConfig($key, $value);
                    }
                    }
                }
            }
            echo json_encode([
                "success" => true,
                "message" => $this->Strings->g("settingsSavedSuccess")
            ]);
        }
    }
    public function logout() {
        session_destroy();
        header("Location:".SITE_URL."admin/login");
        exit;
    }
}
?>