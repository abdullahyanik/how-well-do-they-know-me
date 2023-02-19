<?php
class View {
    var $Strings;
    var $configs;
    function __construct($configs) {
        $this->configs = $configs;
        $lang = $this->configs["language"];
        $this->Strings = new Strings($lang);
    }
    public function render($file, $data = null) {
        if(file_exists("app/views/".$file.".php")) {
            global $arr, $Strings, $configs;
            $Configs = $this->configs;
            $Strings = $this->Strings;
            ob_start();
            if(!is_null($data)) {
                extract($data);
            }
            if(!function_exists("_e")) {
                function _e($s) {
                    global $Strings;
                    $Strings->e($s);
                }
            }
            include "app/views/".$file.".php";
            $output = ob_get_clean();
            echo $output;
        }
        else {
            die($file.".php isn't exists!");
        }
    }
}
?>