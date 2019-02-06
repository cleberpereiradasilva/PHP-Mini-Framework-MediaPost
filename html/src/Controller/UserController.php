<?php
use Model\User;
use core\Controller;
use core\helper\Env;

class UserController extends Controller{
    protected $class = 'Model\User'; 
    
    public function index(){        
        $retorno = new $this->class();        
        $users = json_decode($retorno->findAll(), true);
        foreach($users as $user){
            print_r($user);
            echo "<br />";
        }
    }


    public function post($request){               
        $dados = $request->request('post');
        $dados['password'] = $hash = crypt($dados['password'], Env::env('HASH'));
        $novo = new $this->class($dados);
        $novo->save();        
        header('Location: /users');
        
    }


    public function delete($request){
        $res = parent::delete($request);        
        if($res * 1 === 1){
            echo "Removido com sucesso!";
        }else{
            echo 'Ops, algo errado ocorreu...';
        }
        
    }
}




