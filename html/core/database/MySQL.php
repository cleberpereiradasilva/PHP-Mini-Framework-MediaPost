<?php
namespace core\database;
use core\database\Type;

class MySQL implements DB{
    private $types;
    private $db = 'minif';
    public function __construct($config = ['database' => 'sqlite.db']) {    
        try {
           $this->pdo = new \PDO("mysql:dbname=".$this->db.";host=mysqlserver", "root", "2323");               
        } catch (\PDOException $e) {            
           print_r($e);
           echo "Erro conectar-se ao banco" . PHP_EOL;           
        } 
        $types = new Type(
            'INTEGER', 
            'VARCHAR', 
            'DATETIME',
            'REAL'
        );       
        $this->types = $types->get_types();
    }
    public function get_types(){               
        return $this->types;
    }

    public function prepare($stmt) {        
        $this->stmt = $stmt;
        return $this;
    }   
    public function execute() {        
        $result =  $this->pdo->exec($this->stmt);            
        return $result;
    }   

    public function query() {          
            $result = $this->pdo->query($this->stmt);        
            if(!$result){
                echo "Erro ao executar a query:<br>";
                echo $this->stmt."<br>";

            }
            $tables = [];
            while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                $linha = [];
                foreach($this->cols() as $col){                
                    $linha[$col] = $row[$col];
                }
                $tables[] = $linha;
            }        
            return json_encode($tables);               
        
    }   


    public function cols() {
        #TODO ver a forma certa de fazer isso
        $cols = explode(",",
                str_replace('SELECT','', 
                    explode('FROM',$this->stmt)[0]
                )
            );
        $retorno = [];
        foreach($cols as $col){
            $part = explode("as ","as ". trim($col));            
            $retorno[] = end($part);
        }
        return $retorno;
    }   
    
    public function insert($sql_smt){        
        $this->prepare($sql_smt);
        $res = $this->execute();     
        $result = $this->pdo->query('SELECT LAST_INSERT_ID() as id');
        $row = $result->fetch(\PDO::FETCH_ASSOC);        
        return $row['id'];
    }



    public function create_table($fields, $table){
        $cols = '';
        echo "Criando tabela(se nao existir) `"   . $table . '`' . PHP_EOL;
        foreach($fields as $field){
            $cols.= '' . $field[0].' '.$this->types[$field[1]].' ' .$field[2]. ' '.$field[3].',';
        } 
        $sql_smt = "CREATE TABLE IF NOT EXISTS " .  $table . "(". rtrim($cols,',') .")";   
        $sql_smt = str_replace('AUTOINCREMENT', 'AUTO_INCREMENT', $sql_smt);        
        $this->prepare($sql_smt);
        $this->execute();
    }


    public function add_field($field, $table){        
        echo 'Adicionando `'. $field[0] . '`...' . PHP_EOL;
        $sql_smt = "ALTER TABLE " .  $table . " ADD ". $field[0] ." ". 
            $this->types[$field[1]]
            ."".$field[2]." ".$field[3]." ";           
        $this->prepare($sql_smt);
        $this->execute();
    }

    public function remove_field($fields, $table){        
        echo 'Removendo campos...' . PHP_EOL;                               
        foreach($fields as $field){
            $sql_smt = "ALTER TABLE ".$table." DROP COLUMN ". $field;
            $this->prepare($sql_smt);
            $this->execute();            
        }                
    }

    public function update_table($fields, $table){    
        $sql_smt = "SELECT COLUMN_NAME as name FROM INFORMATION_SCHEMA.COLUMNS  
            WHERE table_name = '" .$table. "'
            AND table_schema = '" . $this->db . "'";
        $result = $this->pdo->query($sql_smt);        
        $names = [];
        $attributes = ['id'];

        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {                        
            $names[] = $row['name'];
        }            
        $fields_names = [] ;
        foreach($fields as $field){
            $attributes[] = $field[0];
            $fields_names[] =  $field[0]; //so para confrontar com o que ja tem
            if(!in_array($field[0], $names)){
                $this->add_field($field, $table);                
            }
        }
        
        $remover = [];
        foreach($names as $name){            
            if(!in_array($name, $fields_names)){                
                $remover[] = $name;                             
            }
        }
             
        if(count($remover) > 0){            
            $this->remove_field($remover, $table);
        }        
    }

    public function drop_table($table){
        
    }

}
