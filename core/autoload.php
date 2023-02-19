<?php
spl_autoload_register(function ($class_name) {
    if(file_exists('core/classes/class.'.strtolower($class_name).'.php')) {
        require 'core/classes/class.'.strtolower($class_name).'.php';
    }
    else if(file_exists('app/controllers/'.$class_name.'.php')) {
        require 'app/controllers/'.$class_name.'.php';
    }
    else if(file_exists('app/models/'.$class_name.'.php')) {
        require 'app/models/'.$class_name.'.php';
    }
});
?>