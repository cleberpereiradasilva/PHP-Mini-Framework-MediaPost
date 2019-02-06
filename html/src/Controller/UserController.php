<?php
use Model\User;
use core\Controller;
use core\helper\Env;

class UserController extends Controller{
    protected $class = 'Model\User'; 
    
    public function post($request){               
        $dados = $request->request('post');
        $dados['password'] = $hash = crypt($dados['password'], Env::env('HASH'));
        print_r($dados);
        $novo = new $this->class($dados);
        $novo->save();        
        return $novo->id;
    }


    public function delete($request){
        $res = parent::delete($request);
        if($res === true){
            echo "Removido com sucesso!";
        }else{
            echo 'Ops, algo errado ocorreu...';
        }
        
    }
}




