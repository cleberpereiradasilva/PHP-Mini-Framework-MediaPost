<?php
$router = new Router();



$router->get('/', function() {    
    echo "<center> HOME </center>";
});


$router->get('/logout', function() {
    session_unset();
    session_destroy();
    header('Location: /');
});


$router->get('/login', function() {    
    echo '
        Pagina de cadastro <br>

        <form action="/user" method="POST">
        Nome: <input type="text" name="name" /><br />
        Username: <input type="text" name="username" /><br />
        Grupo: <input type="text" name="group_id" /><br />
        Senha: <input type="password" name="password" /><br />
        <input type="submit" value="logar">
        </form>
        <hr />
        Pagina de login <br>
        
        <form action="/auth" method="POST">
        Email: <input type="text" name="username" /><br />
        Senha: <input type="password" name="password" /><br />
        <input type="submit" value="logar">
        </form>
    ';    
});


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

$router->get('/users', "UserController@index");
$router->get('/user/{id}', "UserController@view");
$router->get('/user/delete/{id}', "UserController@delete");
$router->put('/user/{id}', "UserController@put");
$router->post('/user', "UserController@post");    

$router->get('/groups', "UserGroupController@index");
$router->get('/group/{id}', "UserGroupController@view");
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





