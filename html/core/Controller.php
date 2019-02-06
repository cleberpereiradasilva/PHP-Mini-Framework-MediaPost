<?php
namespace core;


class Controller{
    protected $class = null;

    public function index(){
        $retorno = new $this->class();        
        return $retorno->findAll();
    }

    public function view($request){          
        $retorno = new $this->class();        
        $retorno->findOne($request['id']);        
        return $retorno;
    }   
    
    public function post($request){                       
        $dados = $request->request('post');
        $novo = new $this->class($dados);
        $novo->save();                        
        return $novo;
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
        return $novo;
    }

    public function delete($request){        
        $model = new $this->class();    
        $retorno = $model->destroy($request['id']);            
        return ($retorno * 1);
    }

}