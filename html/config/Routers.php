<?php


$url_not_found = '/login';

$router = new Router();

$router->get($url_not_found, function() {
    echo "Pagina de login: <input type='password' />";
    
});


$router->autenticar(false, 
    function() use ($router){                
        $router->get('/users', "UserController@index");
        $router->get('/user/{id}', "UserController@view");
        $router->delete('/user/{id}', "UserController@delete");
        $router->put('/user/{id}', "UserController@put");
        $router->post('/user', "UserController@post");         
    }, $url_not_found
);

$router->dispatcher(); 





