<?php
namespace core\database;
use core\database\Type;

interface DB{

    public function __construct($config = []);
    public function get_types();   
    public function prepare($stmt);   
    public function execute();   
    public function query($prepare = null);       
    public function cols();
    
    public function create_table($fields, $table);
    public function update_table($fields, $table);
    public function drop_table($table);

    public function add_field($field, $table);
    public function remove_field($field, $table);

    public function insert($stmt);

    

    
}
