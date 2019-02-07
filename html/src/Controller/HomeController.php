<?php
use core\Controller;
use core\helper\Env;
use core\helper\Response;

class HomeController extends Controller{
    public function index(){
        return Response::view('');
    }

    public function login(){
        return Response::view('layout/login');
    }


    public function logout(){
        session_unset();
        session_destroy();
        header('Location: /');
    }

}




