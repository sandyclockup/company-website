<?php

# Article
$router->get('/cms/category/article', 'ArticleController@list');
$router->post('/cms/category/article/create', 'ArticleController@create');
$router->put('/cms/category/article/update/{id}', 'ArticleController@update');
$router->get('/cms/category/article/{id}', 'ArticleController@show');
$router->delete('/cms/category/article/{id}', 'ArticleController@destroy');

# Portfolio
$router->get('/cms/category/portfolio', 'PortfolioController@list');
$router->post('/cms/category/portfolio/create', 'PortfolioController@create');
$router->put('/cms/category/portfolio/update/{id}', 'PortfolioController@update');
$router->get('/cms/category/portfolio/{id}', 'PortfolioController@show');
$router->delete('/cms/category/portfolio/{id}', 'PortfolioController@destroy');
$router->get('/cms/category/portfolio-dropdown', 'PortfolioController@dropdown');

# Tag
$router->get('/cms/category/tag', 'TagController@list');
$router->post('/cms/category/tag/create', 'TagController@create');
$router->put('/cms/category/tag/update/{id}', 'TagController@update');
$router->get('/cms/category/tag/{id}', 'TagController@show');
$router->delete('/cms/category/tag/{id}', 'TagController@destroy');
