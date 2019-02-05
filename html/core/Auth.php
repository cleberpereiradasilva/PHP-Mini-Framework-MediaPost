<?php

class Auth{
    static function autentication($data){
        print_r($data);
    }
    static function is_autenticated($parans = []){
        if($_SESSION["user"]){
            echo $_SESSION["user"]."<hr />";
        }

        $auth = $parans[0];
        if (is_bool($auth) && $auth !== true){
            return false;
            die;
        }
        if( is_callable($auth)){           
            return $auth();
        }        
        return true;
    }
}