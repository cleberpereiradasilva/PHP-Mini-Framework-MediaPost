<?php
use core\Controller;
use Model\UserGroup;
use core\helper\Response; 

class UserGroupController extends Controller{
    protected $class = 'Model\UserGroup';  

    public function index(){                       
        $grupos = parent::index();
        return Response::json($grupos);        
    }


    public function post($request){                       
        $grupos = parent::post($request);        
        header('Location: /groups');
    }

    public function view($request){                       
        $grupo = parent::view($request); 
        return Response::json($grupo->permissoes);                  
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

