<?php
namespace Model;
use core\Model;
class Usuario extends Model{    
    //'int','varchar','datetime','real'
    protected $fields = [
        ['name','varchar', '(150)', 'NOT NULL'],        
        ['email','varchar', '(150)', ''],                          
        ['senha','varchar', '(150)', '']
    ];        
    public function __construct($dados = null){
        parent::__construct($dados);
    }
}