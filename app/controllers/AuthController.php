<?php
class AuthController extends Controller {
    private $View;
    public $Strings;
    function __construct() {
        parent::__construct();
        $this->Strings = new Strings($this->configs["language"]);
        $this->View = new View($this->configs);
        if(isset($_SESSION["admin"]) && $_SESSION["admin"] === md5($this->configs["admin_username"].$this->configs["admin_password"])) {
            header("Location:".SITE_URL."admin");
            exit;
        }
    }
    public function login() {
        $this->View->render("admin/login");
    }
    public function login_post() {
        if(isset($_POST["username"]) && isset($_POST["password"])) {
            if($_POST["username"] === $this->configs["admin_username"] && hash("sha256", $_POST["password"]) === $this->configs["admin_password"]) {
                $_SESSION["admin"] = md5($this->configs["admin_username"].$this->configs["admin_password"]);
                echo json_encode([
                    "success" => true,
                    "message" => $this->Strings->g("loginSuccess")
                ]);
            }
            else {
                echo json_encode([
                    "success" => false,
                    "message" => $this->Strings->g("loginFailed")
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
}
?>