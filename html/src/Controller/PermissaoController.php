<?php
use Model\Permissao;
use core\Controller;
use core\helper\Env;
use core\helper\Response;

class PermissaoController extends Controller{
    protected $class = 'Model\Permissao';  

    public function index(){        
        $retorno = new $this->class();        
        $objects = $retorno->findAll();
        return Response::json(['items' => $objects]);
    }

    public function view($request){          
        $user = parent::view($request);
        return Response::json(['item' => $user]);
        
    }   

    public function post($request){
        $item = parent::post($request);
        header('Location: /roles');
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




