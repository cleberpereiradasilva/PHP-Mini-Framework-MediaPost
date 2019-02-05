<?php
use core\helper\Request;
use core\Auth;

class Router {    

    private $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'delete' => []
    ];

    
    private $url_not_found = '/';
    private $url_login = '/login';

    private function urlNotFound($path){        
        echo 'Path not found `<i>'.$path.'</i>`';
        return false;
    }

    private function methodNotFound($method){
        echo 'Method not found `<i>'.$method.'</i>`';
        return false;
    }


    function get($pattern, $handler, $auth = null) {       
        $this->routes['get'][$pattern]['action'] = $handler;
        $this->routes['get'][$pattern]['auth'] = $auth;        
        
        return $this;
    }

    function delete($pattern, $handler, $auth = null) {       
        $this->routes['delete'][$pattern] = $handler;
        return $this;
    }

    function put($pattern, $handler, $auth = null) {       
        $this->routes['put'][$pattern] = $handler;
        return $this;
    }


    function post($pattern, $handler, $auth = null) {
        $this->routes['post'][$pattern] = $handler;
        return $this;
    }

    private function match($patern, $path){

        if($patern === $path){
            return true;
        }

        $patern_arr = explode('/',$patern);
        $path_arr = explode('/',$path);

        if(count($patern_arr) !== count($path_arr)){            
            return false;
        }

        if(strpos($patern, '{' ) === false){
            return false;
        }else{
            $uri = [];
            $index = 0;
            foreach($patern_arr as $patn){
                if($patn !== $path_arr[$index] && strpos($patn, '{' ) === false){                    
                    return false;
                }elseif(strpos($patn, '{' ) !== false){
                    $uri[str_replace(['{','}'], '', $patn)] = $path_arr[$index];
                }                
                $index++;
            }            
            return $uri;
        }

        
    }


    function autenticar($dados, $f){        
        echo $dados."<hr />";
        if($dados){            
            return $f($dados);
        }else{
            header('Location: /login');
            echo "Redirecionar /login<br />";
        }

    }


   

    function dispatcher() {
        $path = strtok($_SERVER["REQUEST_URI"],'?');
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        
        if (!isset($this->routes[$method])) { 
            return $this->methodNotFound($method);                       
            
        }


        
        
        foreach ($this->routes[$method] as $pattern => $node) {   
            if($path === '/auth'){
                Request::request();
                #$data = file_get_contents('php://input');  
                #Auth::autentication($data);
                die;
            }
            

            $retorno = $this->match($pattern,$path);
            $handler = $node['action'];
            $auth = $node['auth'];
            if ($retorno !== false) {                      
                if(Auth::is_autenticated($auth) !== true){
                    #ACESSO NEGADO...                            
                    header('Location: '. $this->url_login);
                    die;
                }

                if(is_callable($handler)){
                    if(is_array($retorno)){
                        return $handler($retorno);
                    }else{
                        return $handler();
                    }                    
                }else{
                    #TEM QUE SER UM CONTROLLER                    
                    $className = explode("@", $handler)[0];
                    $methodName = explode("@", $handler)[1];
                    require_once('src/Controller/'. $className . '.php');
                    $class = new $className();
                    if(is_array($retorno)){
                        if($method == 'put'){                            
                            $data = file_get_contents('php://input');                            
                            $retorno['request'] = $data;
                        }
                        return $class->$methodName($retorno);
                    }else{                       
                        if($method == 'post'){                            
                            $data = file_get_contents('php://input');                                                        
                            return $class->$methodName(['request' => $data]);
                        }
                        return $class->$methodName();
                    }                     
                }
            }
        }        
        return $this->urlNotFound($path);
    }

}

