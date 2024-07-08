<?php

$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/refreshtoken', 'AuthController@refreshtoken');
$router->get('/auth/logout', 'AuthController@logout');
$router->post('/auth/register', 'AuthController@register');
$router->get('/auth/confirm/{token}', 'AuthController@confirm');
$router->post('/auth/email/forgot', 'AuthController@forgotPassword');
$router->post('/auth/email/reset/{token}', 'AuthController@resetPassword');
