<?php
namespace core\helper;

class Request{        
    static public function request(){
        $data = file_get_contents('php://input');  
        print_r($data);
        return $data;
    }
}