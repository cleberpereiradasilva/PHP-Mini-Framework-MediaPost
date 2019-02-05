<?php
use Model\Usuario;
use core\Controller;
use core\helper\Env;
class UserController extends Controller{
    protected $class = 'Model\Usuario'; 
    
    public function post($request){               
        $dados = $request->request('post');
        $dados['senha'] = $hash = crypt($dados['senha'], Env::env('HASH'));
        print_r($dados);
        $novo = new $this->class($dados);
        $novo->save();        
        return $novo->id;
    }
}




