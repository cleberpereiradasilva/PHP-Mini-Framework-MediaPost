<?php
namespace core;
use core\helper\Env;
use Model\User;

class Auth{

    static function authentication($data){
       $dados = $data->request('post');
       $dados['password'] = crypt($dados['password'], Env::env('hash'));       
       $user = (new User())->where(['username' => $dados['username'], 'password' =>  $dados['password']]);       
       if(count($user) == 1){
            $_SESSION["user"] = $user[0]->dados;
            header('Location: ' . Env::env('pos_login'));
            die;
       }else{
            header('Location: ' . Env::env('login_url') . '?erro=691');
            die;
       }
    }
    static function is_authenticated($params = null){        
        //pode-se usar qualquer regra para validar  
        
        if(!is_array($params)){                        
            return true;
        }
        
        if(isset($params['logged'])){               
            if(is_auth()){
                return true;
            }else{
                return false;
            }
        }

        // if(in_array($params['grupo_id'], $_SESSION["user"]['grupo_id'])){
        //     return true;
        // }        
        return false;
    }
}