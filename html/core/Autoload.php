<?php
session_start();



class Autoload{
    
    public function __construct(){        
       
        $this->src = "../html" . DIRECTORY_SEPARATOR;
        spl_autoload_register(function ($class) {                                                      
            $class = str_replace('\\','/', $class);            
            if (file_exists($this->src . $class .'.php')) {                  
                require_once($this->src . $class .'.php');
                return true;
            }else{
                foreach($this->diretorios($this->src) as $diretorio){                                    
                    $file = $diretorio . $class.'.php';
                    if (file_exists($file)) {                                            
                        require_once($file);
                        return true;
                    }else{
                        
                        $className = explode("/",$class);
                        $file = $diretorio . end($className).'.php';
                        if (file_exists($file)) { 
                            require_once($file);
                            return true;
                        }                        
                    }
                }     
            }       
            return false;
        });
    }

    private function diretorios($path, &$dirs = [] ){        
        foreach(scandir($path) as $dir){            
            $atual = $path . $dir . DIRECTORY_SEPARATOR;
            if(is_dir($atual) && $dir != '.' && $dir != '..'){                                
                $dirs[] =$atual;
                $this->diretorios($atual, $dirs);
            }
        }
        return $dirs;
    }    
}
new Autoload();