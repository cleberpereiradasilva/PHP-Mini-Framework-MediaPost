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
        Email: <input type="text" name="username" /><br />
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

$router->get('/users', "UserController@index");
$router->get('/user/{id}', "UserController@view");
$router->get('/user/delete/{id}', "UserController@delete");
$router->put('/user/{id}', "UserController@put");
$router->post('/user', "UserController@post");         


$router->dispatcher(); 





