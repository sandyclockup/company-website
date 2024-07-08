<?php

# Website
$router->get('/setting/website', 'WebsiteController@index');
$router->post('/setting/website/update', 'WebsiteController@update');

# User
$router->get('/setting/user', 'UserController@list');
$router->post('/setting/user/create', 'UserController@create');
$router->put('/setting/user/update/{id}', 'UserController@update');
$router->get('/setting/user/{id}', 'UserController@show');
$router->delete('/setting/user/{id}', 'UserController@destroy');
