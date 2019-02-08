<?php
use core\Controller;
use core\helper\Response; 
use Mapi\Client;

class ListaController extends Controller{  
    
    public function __construct(){
        $this->mapi = new Client(
            
        );
    }
    

    public function index(){         
        $lista = [];
        return Response::view('lista/list', ['lista' => $lista]);
    }


    public function new(){     
        $lista = [
            'nome' => '',
            'cod' => ''
        ];    
        return Response::view('lista/form', ['lista' => $lista]);
    }


    public function post($request){     
        

       

        try {
            // Requisições GET            
            // $response = $mapi->get('contato/campos');
            // var_dump($response);           
        
            // // Requisições DELETE
            // $response = $mapi->delete('url/do/recurso');
        
            // Requisições POST
            $response = $this->mapi->get('lista/all');
            print_r($response);
        
            // // Requisições PUT
            // $response = $mapi->put('url/do/recurso', [
            //     'campo' => 'valor',
            //     'campo2' => 'valor2'
            // ]);
        } catch (Mapi\Exception $e) {
            // Erro de requisição
            var_dump($e);
        } catch (Exception $e) {
            // Erro genérico (por exemplo, parâmetros inválidos)
            var_dump($e);
        }



        
    }

    
}

