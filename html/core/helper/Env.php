<?php
namespace core\helper;
 

class Env{
    static private $env = null;
    static function env($str){
        if(self::$env == null){            
            $envFile = '.env';
            $json_config = json_decode(file_get_contents($envFile), true);                  
            self::$env = $json_config;
        }        
        return self::$env[$str];
    }        
}

