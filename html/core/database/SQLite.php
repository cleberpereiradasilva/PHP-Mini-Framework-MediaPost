<?php
namespace core\database;
use core\database\Type;

class SQLite implements DB{
    private $types;
    public function __construct($config = ['database' => 'sqlite.db']) {    
        try {
           $this->pdo = new \PDO("sqlite:" . $config['database'], SQLITE3_OPEN_READWRITE);
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
        return $this->pdo->prepare($stmt);
    }   
    public function execute() {        
        $result =  $this->pdo->exec($this->stmt);            
        return $result;
    }   

    public function query($prepare = null) {          
        $tables = [];        
        foreach($prepare as $row ) {
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
        $result = $this->pdo->query('SELECT last_insert_rowid() as id');
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
        $cols = '';        
        foreach($fields as $field){
            $cols.= $field[0].',';
        }                  
        $this->drop_table($table."___temp");

        $this->create_table($fields, $table."___temp");

        $sql_smt = "INSERT INTO ".$table."___temp AS SELECT ". rtrim($cols,',') ." FROM ". $table;                    
        $this->prepare($sql_smt);
        $this->execute();
        $this->drop_table($table);
        $this->execute();
        $this->prepare( "ALTER TABLE ".$table."___temp RENAME TO " . $table);        
        $this->execute();      
        

    }

    public function update_table($fields, $table){
        $result = $this->pdo->query('PRAGMA table_info('.$table.')');        
        $names = [];
        $attributes = ['id'];

        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {            
            $names[] = $row['name'];
        }            
        foreach($fields as $field){
            $attributes[] = $field[0];
            if(!in_array($field[0], $names)){
                $this->add_field($field, $table);                
            }
        }

        $remove = false;
        foreach($names as $name){
            if(!in_array($name, $attributes)){
                $remove = true;
            }
        }           
        if($remove){
            $this->remove_field($fields, $table);
        }        
    }

    public function drop_table($table){
        $sql_smt = "DROP TABLE IF EXISTS " .  $table;                  
        $this->prepare($sql_smt);
        $this->execute();
    }

}
