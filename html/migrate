<?php

require_once("core/Autoload.php");


//varrer os models e criar ou alterar as tabelas de acordo 
//com os atributos
echo PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;
echo "Executando migracoes..." . PHP_EOL;

$path = 'src/Model';
foreach(scandir($path) as $model){    
    if($model != '.' && $model != '..'){                
        $className = "Model\\" . str_replace(".php", "", $model);        
        $obj = new $className();       
        $obj->create_table($obj->get_fields(), $obj->get_table());
    }
    
}

#TODO fazer uma forma de remover a tabela se o Model for removido...
echo PHP_EOL;


