<?php
namespace core;

class Controller{
    protected $class = null;

    public function index(){
        $retorno = new $this->class();        
        echo $retorno->findAll();
    }

    public function view($request){                
        $retorno = new $this->class();        
        echo json_encode($retorno->findOne($request['id'])->dados);
    }

    public function post($request){               
        $dados = json_decode($request['request'],true);        
        $novo = new $this->class($dados);
        $novo->save();        
        return $novo->id;
    }

    public function put($request){        
        $retorno = new $this->class();     
        $objeto = $retorno->findOne($request['id'])->dados;
        $dados = json_decode($request['request'],true);
        foreach($dados as $key => $value){
            $objeto[$key] = $value;            
        }
        $novo = new $this->class($objeto);
        $novo->save();        
        return true;
    }

    public function delete($request){
        $model = new $this->class();        
        return $model->destroy($request['id']) * 1;
    }

}