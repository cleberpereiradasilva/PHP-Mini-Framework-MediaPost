<?php
$router = new Router();
use core\helper\Response;


$router->get('/', "HomeController@index");
$router->get('/login', "HomeController@login");
$router->get('/logout', "HomeController@logout");


$router->get('/group-new', function() {    
    echo '
        Pagina de cadastro <br>
        <form action="/group" method="POST">
        Nome: <input type="text" name="name" /><br />        
        <input type="submit" value="enviar">
        </form>
        <hr />             
    ';    
});


$router->get('/listas', "ListaController@index");
$router->get('/lista/new', "ListaController@new");
$router->get('/lista/{id}', "ListaController@view");
$router->get('/lista/delete/{id}', "ListaController@delete");
$router->get('/lista/edit/{id}', "ListaController@edit");
$router->post('/lista', "ListaController@post"); 



$router->get('/users', "UserController@index");
$router->get('/user/new', "UserController@new");
$router->get('/user/{id}', "UserController@view");
$router->get('/user/delete/{id}', "UserController@delete");
$router->get('/user/edit/{id}', "UserController@edit");
$router->put('/user/{id}', "UserController@put");
$router->post('/user', "UserController@post");    

$router->get('/groups', "UserGroupController@index");
$router->get('/group/new', "UserGroupController@new");
$router->get('/group/{id}', "UserGroupController@view");
$router->get('/group/edit/{id}', "UserGroupController@edit");
$router->get('/group/delete/{id}', "UserGroupController@delete");
$router->put('/group/{id}', "UserGroupController@put");
$router->post('/group', "UserGroupController@post");    



$router->get('/role/create', function() {    
    echo '
        Pagina de cadastro <br>
        <form action="/role" method="POST">
        Nome: <input type="text" name="name" /><br />
        <input type="submit" value="inserir">
        </form>
        <hr />        
    ';    
});


$router->get('/roles', "PermissaoController@index");
$router->get('/role/{id}', "PermissaoController@view");
$router->get('/role/delete/{id}', "PermissaoController@delete");
$router->put('/role/{id}', "PermissaoController@put");
$router->post('/role', "PermissaoController@post");   


$router->dispatcher(); 





