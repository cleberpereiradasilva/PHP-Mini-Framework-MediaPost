<?php
namespace core\helper;


class Env{
    static private $env = null;
    static function env($str){
        if(self::$env == null){            
            $envFile = '.env';
            $myEnvFile = fopen($envFile, "r");            
            $aux = [];
            while (($line = fgets($myEnvFile)) !== false) {
                $field = substr($line, 0, strpos($line, '='));
                $value = str_replace('"','',substr($line, strpos($line, '=')+1));
                $aux[$field] = $value;                
            }
            self::$env = $aux;
        }        
        return self::$env[$str];
    }        
}

