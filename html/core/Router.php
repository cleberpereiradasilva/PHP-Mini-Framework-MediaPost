<?php

class Router {    

    private $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'delete' => []
    ];
    private function urlNotFound($path){
        echo 'Path not found `<i>'.$path.'</i>`';
        return false;
    }

    private function methodNotFound($method){
        echo 'Method not found `<i>'.$method.'</i>`';
        return false;
    }

    function get($pattern, $handler) {       
        $this->routes['get'][$pattern] = $handler;
        return $this;
    }

    function delete($pattern, $handler) {       
        $this->routes['delete'][$pattern] = $handler;
        return $this;
    }

    function put($pattern, $handler) {       
        $this->routes['put'][$pattern] = $handler;
        return $this;
    }


    function post($pattern, $handler) {
        $this->routes['post'][$pattern] = $handler;
        return $this;
    }

    function dispatcher() {
        $path = strtok($_SERVER["REQUEST_URI"],'?');
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        
        if (!isset($this->routes[$method])) { 
            return $this->methodNotFound($method);                       
            
        }
        
        foreach ($this->routes[$method] as $pattern => $handler) {
            if ($pattern === $path) { 
                if(is_callable($handler)){
                    return $handler();
                }else{
                    #TEM QUE SER UM CONTROLLER                    
                    $className = explode("@", $handler)[0];
                    $methodName = explode("@", $handler)[1];
                    require_once('src/Controller/'. $className . '.php');
                    $class = new $className();
                    return $class->$methodName();
                }
            }
        }        
        return $this->urlNotFound($path);
    }

}

