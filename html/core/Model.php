<?php
namespace core;
use core\SQLite;


class Model{ 
    protected $db = null;
    protected $table = '';
    protected $fields_default = [
            ['id','int', '', 'PRIMARY KEY AUTOINCREMENT NOT NULL']
    ]; // para todos os Models
    public $dados = [];
    protected $fields = [];

    public function __construct($dados = null){    
        //seta todos os campos com valor ''
        foreach($this->get_fields() as $item){       
            $this->dados[$item[0]] = '';
        }         
        
        //se recebeu dados ja salva o stado do objeto
        if($dados){
            foreach($dados as $key => $value){                       
                $this->dados[$key] = $value;
            }
        }

        $get_called_class = explode('\\', get_called_class());
        $this->table = strtolower(end($get_called_class));                 
        $this->db = new SQLite();                
        return $this;
    }

    public function get_fields(){
        return  array_merge($this->fields_default, $this->fields);
    }


    public function create_table(){                
        $this->db->create_table($this->get_fields(), $this->get_table());
        $this->db->update_table($this->get_fields(), $this->get_table());        
        return true;        
    }

    public function drop_table(){
        $this->db->drop_table($this->get_table());               
        return true;        
    }    

    public function get_table(){
        return $this->table;
    }


    public function first(){
        echo "Trazendo o primeiro registro<br>";
        return $this;
    }

    public function destroy($id){
        $stmt_delete = 'DELETE FROM  '. $this->get_table() . ' WHERE id='. (1 * $id);                
        return $this->db->prepare($stmt_delete)->execute();   
    }   


     

    public function findOne($id){
        $stmt = 'SELECT ';
        foreach($this->dados as $key => $value){                            
                $stmt .= $key . ",";                                           
        }
        $stmt_all = rtrim($stmt, ','). " FROM " . $this->get_table() . ' where id=' . (1 * $id);
        $dados = $this->db->prepare($stmt_all)->query(); 
        $className = get_called_class();
        
        $model = new $className(json_decode($dados,true)[0]);                
        return $model;
    }

    public function findAll(){
        $stmt = 'SELECT ';
        foreach($this->dados as $key => $value){                            
                $stmt .= $key . ",";                                           
        }
        $stmt_all = rtrim($stmt, ','). " FROM " . $this->get_table();
        return $this->db->prepare($stmt_all)->query();        
    }

    public function where($str){
        echo "Resultado de busca por where<br>";
        return $this;
    }

    private function insert(){
        $stmt='INSERT INTO '.$this->get_table().' (';
        $values = '';
        foreach($this->dados as $key => $value){                
            if($key !== 'id'){
                $stmt .= $key . ",";
                $values .= "'" . $value . "',";                
            }
        }
        $stmt_final = rtrim($stmt, ','). ") values (" . 
            rtrim($values, ',') . ");";                                   
        $res = $this->db->insert($stmt_final);
        $this->dados['id']=$res;
    }

    private function update(){
        $stmt='UPDATE '.$this->get_table().' SET ';        
        foreach($this->dados as $key => $value){                
            if($key !== 'id'){
                $stmt .= $key . " = '" . $value . "',";                        
            }
        }
        $stmt_update = rtrim($stmt, ','). " WHERE id = ".$this->dados['id'];        
        $this->db->prepare($stmt_update);
        $this->db->execute();        
    }
   
    public function save(){
        $errorMessage = [];
        foreach($this->get_fields() as $field){
            if(strpos($field[3] , 'NOT NULL') !== false && $this->dados[$field[0]] === '' && $field[0] !== 'id' ){
                $errorMessage[] = ['message' =>  $field[0] . " is required"];                
            }
        }
        if(count($errorMessage) > 0){
            return ['error' => true, 'errors' => $errorMessage];
        }else{
            if($this->dados['id'] != ''){
                //UPDATE               
                $this->update();
            }else{
                //INSERT
                $this->insert();
            }
            
            return $this->dados;
        }        
    }






    
    public function __get($attr){
        foreach($this->get_fields() as $field){
            if($field[0] === $attr){
                return $this->dados[$attr];
            }
        }
        throw new \Exception("Field `". $attr . "` not found");
    }

    public function __set($attr, $value){
        foreach($this->get_fields() as $field){
            if($field[0] === $attr){
                $this->dados[$attr] = $value;
                return true;
            }
        }
        throw new \Exception("Field `". $attr . "` not found");
        
    }

}