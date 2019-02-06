<?php
namespace Model;
use core\Model;
class User extends Model{    
    //'int','varchar','datetime','real'
    protected $fields = [
        ['name','varchar', '(150)', 'NOT NULL'],        
        ['username','varchar', '(150)', 'UNIQUE'],
        ['password','varchar', '(150)', 'NOT NULL']
    ];  

    public function __construct($dados = null){
        parent::__construct($dados);
    }
}