<?php

$router->get('/account/profile/token', 'ProfileController@checkToken');
$router->get('/account/profile/info', 'ProfileController@profileView');
$router->post('/account/profile/update', 'ProfileController@profileUpdate');
$router->post('/account/profile/upload', 'ProfileController@uploadImage');
$router->post('/account/profile/password', 'ProfileController@passwordUpdate');
