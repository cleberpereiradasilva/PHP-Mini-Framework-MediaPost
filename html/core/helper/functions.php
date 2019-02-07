<?php
use core\Auth;

function is_auth(){
    if(isset($_SESSION["user_id"])){
        return true;
    }else{
        return false;
    }
}

function auth_user(){
    $user = null;
    if(is_auth()){
        $user = (new User())->findOne($_SESSION["user_id"]);
    }
    return $user;
}