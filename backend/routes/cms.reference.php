<?php

# Contact
$router->get('/cms/reference/contact-total', 'ContactController@getTotal');
$router->get('/cms/reference/contact', 'ContactController@list');
$router->get('/cms/reference/contact/{id}', 'ContactController@show');
$router->delete('/cms/reference/contact/{id}', 'ContactController@destroy');

# Customer
$router->get('/cms/reference/customer', 'CustomerController@list');
$router->post('/cms/reference/customer/create', 'CustomerController@create');
$router->put('/cms/reference/customer/update/{id}', 'CustomerController@update');
$router->get('/cms/reference/customer/{id}', 'CustomerController@show');
$router->delete('/cms/reference/customer/{id}', 'CustomerController@destroy');
$router->get('/cms/reference/customer-dropdown', 'CustomerController@dropdown');

# Team
$router->get('/cms/reference/team', 'TeamController@list');
$router->post('/cms/reference/team/create', 'TeamController@create');
$router->put('/cms/reference/team/update/{id}', 'TeamController@update');
$router->get('/cms/reference/team/{id}', 'TeamController@show');
$router->delete('/cms/reference/team/{id}', 'TeamController@destroy');
