<?php
use core\Controller;
use Model\UserGroup;

class UserGroupController extends Controller{
    protected $class = 'Model\UserGroup';  

    public function post($request){                       
        parent::post($request);
        header('Location: /groups');
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

