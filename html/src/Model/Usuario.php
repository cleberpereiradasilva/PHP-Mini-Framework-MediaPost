<?php
namespace Model;
use core\Model;
class Usuario extends Model{    
    //'int','varchar','datetime','real'
    protected $fields = [
        ['name','varchar', '(150)', 'NOT NULL'],
        ['lastname','varchar', '(150)', ''],
        ['email','varchar', '(150)', ''],                          
        ['cidade','varchar', '(150)', ''],      
        ['idade','int', '', '']
    ];        
    public function __construct($dados = null){
        parent::__construct($dados);
    }
}