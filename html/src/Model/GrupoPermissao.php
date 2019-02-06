<?php
namespace Model;
use core\Model;
class GrupoPermissao extends Model{    
    //'int','varchar','datetime','real'
    protected $fields = [
        ['group_id','int', '', 'NOT NULL', 'UserGroup'],
        ['permissao_id','int', '', 'NOT NULL', 'Permissao']
    ];  
    public function __construct($dados = null){
        parent::__construct($dados);
    }
}