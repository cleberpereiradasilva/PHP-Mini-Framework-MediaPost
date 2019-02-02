<?php

class UserController{

    public function index(){
        $users = [
            ['name' => 'name 01', 'id' => 1],
            ['name' => 'name 02', 'id' => 2],
            ['name' => 'name 03', 'id' => 3],
            ['name' => 'name 04', 'id' => 4],
            ['name' => 'name 05', 'id' => 5],
        ];
        echo json_encode($users);
    }


    public function view(){
        echo "Chamando view()";
    }

    public function update(){
        echo "Chamando update()";
    }

    public function delete(){
        echo "Chamando delete()";
    }

}