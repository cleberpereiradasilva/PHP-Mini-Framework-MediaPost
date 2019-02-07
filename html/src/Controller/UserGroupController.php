<?php
use core\Controller;
use Model\UserGroup;
use core\helper\Response; 

class UserGroupController extends Controller{
    protected $class = 'Model\UserGroup';    

    public function index(){ 
        $retorno = new $this->class();        
        $groups = $retorno->findAll();
        return Response::view('group/list', ['groups' => $groups]);
    }

    public function view($request){          
        $group = parent::view($request);
        return Response::view('group/group', ['group' => $group]);        
    } 

    
    public function new(){      
        $group = new UserGroup();            
        return Response::view('group/form', [
                'group' => $group, 
                ]);        
    } 

    public function edit($request){        
        $group = parent::view($request);
        return Response::view('group/form', [
                'group' => $group               
                ]);        
    }   

    public function post($request){        
        $dados = $request->request('post');    
        
       


        $group = new UserGroup();
        if($dados['id'] != ''){
            //PUT
            $group = $group->findOne($dados['id']);            
            $group->fill($dados);            
        }else{
            //POST            
            $group = new $this->class($dados);
        }        
        $group->save();        
        header('Location: /groups');
    }

    public function delete($request){
        $res = parent::delete($request);        
        if($res * 1 === 1){
            header('Location: /groups?erro=Erro ao remover');
        }else{
            header('Location: /groups');
        }        
    }
}

