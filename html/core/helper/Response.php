<?php
namespace core\helper;
class Response{            
    public function __construct(){        
    }

    static function view($path, $vars = []){
        foreach($vars as $var => $value){
            $$var = $value;
        }   
        require_once('src/View/layout/top.php');
        if($path != ''){
            require_once('src/View/' . $path . '.php');
        }
        require_once('src/View/layout/bottom.php');
    }

    static function json($vars){
        header('Content-type: application/json');
        echo json_encode($vars);
    }
}