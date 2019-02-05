<?php
namespace core\helper;

class Type{    
    protected $type = [];
    public function __construct(
        $int = null,
        $varchar = null,
        $datetime = null,
        $real = null
    ){        
        $this->type = [
            'int' => $int,
            'varchar' => $varchar,
            'datetime' => $datetime,
            'real' => $real
        ];              
    }

    public function get_types(){
        return $this->type;
    }

}