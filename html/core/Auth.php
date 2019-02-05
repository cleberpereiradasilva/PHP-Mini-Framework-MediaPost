<?php
namespace core;

class Auth{
    static function authentication($data){
       //....
    }
    static function is_autenticated($parans = []){        
        //pode-se usar qualquer regra para validar
        $_SESSION["usuario"] = [
            'name' => 'User Name',
            'user_id' => 1,
            'grupo_id' => 10
        ];
        print_r($_SESSION["usuario"]['name']);
        echo "<hr />";
        

        if(!is_array($parans)){
            return true;
        }

        if(in_array($parans['grupo_id'], $_SESSION["user"]['grupo_id'])){
            return true;
        }        
        return false;
    }
}