<?php

$router->get('/account/notification', 'NotificationController@index');
$router->get('/account/notification/list', 'NotificationController@list');
$router->get('/account/notification/{id}', 'NotificationController@show');
$router->delete('/account/notification/{id}', 'NotificationController@destroy');
