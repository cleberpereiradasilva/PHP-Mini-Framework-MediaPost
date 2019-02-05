<?php
$router = new Router();
$router->get('/login', function() {
    $_SESSION["user"] = true;
    echo '
        Pagina de login <br>
        <form action="/auth" method="POST">
        Email: <input type="text" name="usuario" /><br />
        Email: <input type="password" name="senha" /><br />
        <input type="submit" value="logar">
        </form>
    ';    
});

$router->get('/users', "UserController@index");
$router->get('/user/{id}', "UserController@view",['grupo_id' => 11]);
$router->delete('/user/{id}', "UserController@delete");
$router->put('/user/{id}', "UserController@put");
$router->post('/user', "UserController@post");         

    
$router->dispatcher(); 





