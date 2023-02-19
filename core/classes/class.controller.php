<?php
class Controller {
    public $configs;
    function prefered_language(array $available_languages, $http_accept_language) {
        $available_languages = array_flip($available_languages);
        $langs;
        preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
        foreach($matches as $match) {
            list($a, $b) = explode('-', $match[1]) + array('', '');
            $value = isset($match[2]) ? (float) $match[2] : 1.0;
            if(isset($available_languages[$match[1]])) {
                $langs[$match[1]] = $value;
                continue;
            }
            if(isset($available_languages[$a])) {
                $langs[$a] = $value - 0.1;
            }
        }
        arsort($langs);
        return $langs;
    }
    function is_bot() {
        return (
            isset($_SERVER['HTTP_USER_AGENT'])
            && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
        );
    }
    function __construct() {
        include realpath("./load.php");
        $this->configs["languages"] = [
            "tr" => "Türkçe",
            "en" => "English",
            "de" => "Deutsch"
        ];
    }
    public function validateRecaptcha($g_response) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "secret" => $this->configs["recaptcha_secret_key"],
            "response" => $g_response,
            "remoteip" => $_SERVER["REMOTE_ADDR"]
        ]);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $response["success"];
    }
    public function uploadJpeg($tmp_name, $path) {
        if(file_exists($path)) {unlink($path);}
        if(exif_imagetype($tmp_name) ==  IMAGETYPE_GIF) 
        {
            imagejpeg(imagecreatefromgif($tmp_name), $path);
        }
        elseif(exif_imagetype($tmp_name) ==  IMAGETYPE_PNG) 
        {
            imagejpeg(imagecreatefrompng($tmp_name), $path);
        }
        elseif(exif_imagetype($tmp_name) ==  IMAGETYPE_JPEG) 
        {
            move_uploaded_file($tmp_name, $path);
        }
    }
    public function uploadPng($tmp_name, $path) {
        if(file_exists($path)) {unlink($path);}
        if(exif_imagetype($tmp_name) ==  IMAGETYPE_GIF) 
        {
            imagepng(imagecreatefromgif($tmp_name), $path);
        }
        elseif(exif_imagetype($tmp_name) ==  IMAGETYPE_JPEG) 
        {
            imagepng(imagecreatefromjpeg($tmp_name), $path);
        }
        elseif(exif_imagetype($tmp_name) ==  IMAGETYPE_PNG) 
        {
            move_uploaded_file($tmp_name, $path);
        }
    }
}
?>