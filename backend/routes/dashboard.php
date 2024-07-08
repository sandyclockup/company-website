<?php

$router->get('/dashboard/total', 'DashboardController@GetByTotal');
$router->get('/dashboard/visitor', 'DashboardController@VisitorByYear');
$router->get('/dashboard/reader', 'DashboardController@ArticleReader');
$router->get('/dashboard/portfolio/customer', 'DashboardController@PortfolioByCustomer');
$router->get('/dashboard/portfolio/category', 'DashboardController@PortfolioByCategory');
$router->get('/dashboard/article/tag', 'DashboardController@ArticleByTag');
$router->get('/dashboard/article/category', 'DashboardController@ArticleByCategory');
