<?php
namespace core;
use core\helper\Env;

class Model{ 
    protected $db = null;
    protected $table = '';
    protected $fields_default = [
            ['id','int', '', ' PRIMARY KEY AUTOINCREMENT NOT NULL']
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
        
        if(Env::env('database_type') == 'mysql'){
            $dataBaseClass = '\core\database\MySQL';     
            $config = Env::env('mysql');                       
        }elseif(Env::env('database_type') == 'sqlite'){
            $dataBaseClass = '\core\database\SQLite';  
            $config = ['database' => Env::env('sqlite')['database']];            
        }

        $this->db = new $dataBaseClass($config);
    }        

    public function fill($dados = null){                    
        //se recebeu dados ja salva o stado do objeto
        if($dados){  
            foreach($dados as $key => $value){                
                if($key != 'id'){
                    $this->dados[$key] = $value;
                }            
            }
        }
    }        

    public function findOne($id){        
        if($id == ''){
            return null;
        }
        
        $stmt = 'SELECT ';
        foreach($this->dados as $key => $value){                            
                $stmt .= $key . ",";                                           
        }
        $stmt_all = rtrim($stmt, ','). " FROM " . $this->get_table() . ' where id=?';
        $prepare = $this->db->prepare($stmt_all);                
        $prepare->execute([$id]);
        $dados = $this->db->query($prepare);  
        $className = get_called_class();                
        $model = new $className(json_decode($dados,true)[0]);        
        $this->dados = $model->dados;
        return $model;
    }



    public function findAll(){
        $stmt = 'SELECT ';
        foreach($this->dados as $key => $value){                            
                $stmt .= $key . ",";                                           
        }
        $stmt_all = rtrim($stmt, ','). " FROM " . $this->get_table();       
        $prepare = $this->db->prepare($stmt_all);             
        $prepare->execute();
        //$dado_json = $prepare->execute(); 
        $dado_json = $this->db->query($prepare);        
        $dados = json_decode($dado_json,true);
        $objects = [];
        foreach($dados as $dado){
            $className = get_called_class();                            
           
            $objects[] = new $className($dado);            
        }
        return $objects;
    }

    public function get_fields(){
        return  array_merge($this->fields_default, $this->fields);
    }  


    public function where($str){       
        
       

        $stmt = 'SELECT ';
        foreach($this->dados as $key => $value){                            
                $stmt .= $key . ",";                                           
        }
        $stmt_all = rtrim($stmt, ','). " FROM " . $this->get_table(). ' where ';    
        $valores = [];
        foreach($str as $item => $valor){
            $stmt_all .= " " . $item ."=? and";
            $valores[] = $valor;
        }                   
        $prepare = $this->db->prepare(rtrim($stmt_all, " and"));                    
        $prepare->execute($valores);
        $dado_json = $this->db->query($prepare);        
        $dados = json_decode($dado_json,true);
        $objects = [];
        foreach($dados as $dado){
            $className = get_called_class();                            
           
            $objects[] = new $className($dado);            
        }        
        return $objects;



       
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
        $values = [];
        foreach($this->dados as $key => $value){                
            if($key !== 'id'){
                $stmt .= $key . "=?,";                        
                $values[] = $value;
            }
        }       
        $stmt = rtrim($stmt, ',') . " where id=?";          
        $values[] = $this->dados['id'];        
        $prepare = $this->db->prepare($stmt);                            
        $prepare->execute($values);
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
            return $this;
        }        
    }


    public function destroy($id){
        $stmt_delete = 'DELETE FROM  '. $this->get_table() . ' WHERE id='. (1 * $id);                        
        $retorno = $this->db->prepare($stmt_delete)->execute();        
        return $retorno;
    }  





    
    
    private function relationship($attr){
        $className = $attr[4];        
        $fileName =  'src/Model/'. $className . '.php';
        if(file_exists($fileName)){
            $className = "\\Model\\".$className;
            $class = new $className();
            $objeto = $class->findOne($this->dados[$attr[0]]);
            return $objeto;
        }
        return null;
    }

    public function __get($attr){        
        foreach($this->get_fields() as $field){            
            if($field[0] === $attr){                
                return $this->dados[$attr];
            }else{                
                if(isset($field[4]) && $field[0] == $attr.'_id'){
                    $hasOne = $this->relationship($field);
                    return $hasOne;                  
                }
            }
        }

        
        //TODO precisa melhorar bastante esse parte do codigo.... foom...
        $className = get_called_class();          
        $class = new $className();
        $class->findOne($this->dados['id']);  
        if (is_callable(array($class, $attr))){
            
            $criteria = $class->{$attr}();   
            if(is_array($criteria)){ //checa se é um array pq pode ser qualquer tipo de metodo
                if(isset($criteria['models']) && isset($criteria['fields'])){
                    $objects_attr = [];
                    $classOneName = 'Model\\' . $criteria['models'][0];
                    $classOne  = new $classOneName();
                    $classOneList = $classOne->where([$criteria['fields'][0] => $this->id]);
                    $second_id = $criteria['fields'][1];            
                    foreach($classOneList as $one){                                
                        $classTwoName = 'Model\\' . $criteria['models'][1];
                        $classTwo  = new $classTwoName();
                        $objects_attr[] = $classTwo->findOne($one->dados[$second_id]);
                    }
                    return $objects_attr;
                }else{
                    return $criteria;    
                }
            }else{
                return $criteria;
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