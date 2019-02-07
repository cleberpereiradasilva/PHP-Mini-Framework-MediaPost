<?php
use core\Controller;
use core\helper\Env;
use core\helper\Response;

class HomeController extends Controller{
    public function index(){
        return Response::view('');
    }

}




