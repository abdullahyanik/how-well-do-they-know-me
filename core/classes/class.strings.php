<?php
class Strings {
    var $strings;
    function __construct($lang) {
        include "app/strings/".$lang.".php";
        $this->strings = $strings;
    }
    public function g($s) {
        return $this->strings[$s];
    }
    public function e($s) {
        if(isset($this->strings[$s])) {
            echo $this->strings[$s];
        }
    }
}
?>