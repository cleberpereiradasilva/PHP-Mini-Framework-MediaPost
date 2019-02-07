<?php
use Model\User;
use core\Controller;
use core\helper\Env;
use core\helper\Response;

class UserController extends Controller{
    protected $class = 'Model\User';  

    public function index(){   
        

        $retorno = new $this->class();        
        $users = $retorno->findAll();
        return Response::view('user/list', ['users' => $users]);
    }

    public function view($request){          
        $user = parent::view($request);
        return Response::view('user/user', ['user' => $user]);
        
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




