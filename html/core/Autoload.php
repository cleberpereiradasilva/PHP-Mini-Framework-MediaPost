<?php
class Autoload{
    
    public function __construct(){        
        $this->src = "src" . DIRECTORY_SEPARATOR;
        spl_autoload_register(function ($class) {                              
            $class = str_replace('\\','/', $class);
            echo $class.'<br>';
            if (file_exists($this->src . $class .'.php')) {                  
                require $this->src . $class .'.php';
                return true;
            }else{
                foreach($this->diretorios($this->src) as $diretorio){                                    
                    $file = $diretorio . $class.'.php';                
                    echo $file."<br>";
                    if (file_exists($file)) {                    
                        require $file;
                        return true;
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