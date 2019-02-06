<?php
namespace Model;
use core\Model;
class UserGroup extends Model{    
    //'int','varchar','datetime','real'
    protected $fields = [
        ['name','varchar', '(150)', 'UNIQUE NOT NULL']                
    ];  

    public function __construct($dados = null){
        parent::__construct($dados);
    }
}