<?php
use core\Controller;
use core\helper\Env;
use core\helper\Response;

use Model\User;
use Model\UserGroup;

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
    
    public function new(){      
        $grupos = new UserGroup();    
        $user = new User();
        return Response::view('user/form', [
                'user' => $user, 
                'grupos' => $grupos->findAll()]);        
    } 

    public function edit($request){    
        $grupos = new UserGroup();
        $user = parent::view($request);
        return Response::view('user/form', [
                'user' => $user,
                'grupos' => $grupos->findAll()
                ]);        
    }   

    public function post($request){
        $dados = $request->request('post');   
        
        $errors = [];
        if($dados['name'] == ''){
            $errors[] = ['message' => 'Nome inválido/vazio'];
        }

        if($dados['group_id'] == ''){
            $errors[] = ['message' => 'Grupo inválido/vazio'];
        }


        if(count($errors) > 0){
           
            return Response::errors($_SERVER['HTTP_REFERER'], $errors);
            die;
        }



        $user = new User();
        if($dados['id'] != ''){
            //PUT
            $user = $user->findOne($dados['id']);
            if($dados['password'] == ''){
                unset($dados['password']);                
            }else{
                $dados['password'] = crypt($dados['password'], Env::env('hash'));
            }
            $user->fill($dados);
            
        }else{
            //POST
            $dados['password'] = crypt($dados['password'], Env::env('hash'));
            $user = new $this->class($dados);
        }        
        $user->save();
        header('Location: /users');
    }

    public function delete($request){
        $res = parent::delete($request);        
        if($res * 1 === 1){
            header('Location: /users?erro=Erro ao remover');
        }else{
            header('Location: /users');
        }        
    }
}




