<?php
namespace core;
use core\helper\Env;
use Model\User;

class Auth{
    static function authentication($data){
       $dados = $data->request('post');
       $dados['password'] = crypt($dados['password'], Env::env('HASH'));       
       $user = (new User())->where(['username' => $dados['username'], 'password' =>  $dados['password']]);
       $_SESSION["user"] = $user->dados;
       header('Location: ' . Env::env('POS_LOGIN'));
       die;
    }
    static function is_authenticated($params = null){        
        //pode-se usar qualquer regra para validar  
        
        if(!is_array($params)){                        
            return true;
        }
        
        if(isset($params['logged'])){               
            if(isset($_SESSION["user"])){
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