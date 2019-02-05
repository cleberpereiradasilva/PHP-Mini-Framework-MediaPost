<?php
namespace core\helper;

class Request{        
    protected $request = [];
    public function __construct(){
        $data = file_get_contents('php://input');  
        $json = json_decode($data);
        $post = $_POST;
        $get = $_GET;

        
        $this->request = [
            'body' => $data,
            'json' => $json,
            'post' => $post,
            'get' => $get            
        ];
    }

    public function request($index){
        return $this->request[$index];
    }
}