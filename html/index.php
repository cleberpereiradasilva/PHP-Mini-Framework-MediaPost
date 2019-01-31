<?php
require_once("core/Autoload.php");

use Model\Usuario;
use Controller\auth\outro\login\Auth as Login;

$usuario = new Usuario();
$usuario->ola();

$auth = new Login();
$auth->autenticar();