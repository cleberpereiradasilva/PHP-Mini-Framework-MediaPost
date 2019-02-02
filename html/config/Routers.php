<?php
$router = new Router();
$router->get('/foo', 
    function() { echo "GET WW  foo\n"; }
);

$router->get('/users', "UserController@index");
$router->get('/user', "UserController@view");

$router->put('/user', "UserController@update");
$router->delete('/user', "UserController@delete");


$router->post('/bar', 
    function() { echo "POST bar RRRRRR\n"; }
);


$router->dispatcher();
