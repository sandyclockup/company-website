<?php

# Page
$router->get('/page/guest/slider', 'GuestController@GetSlider');
$router->get('/page/guest/content', 'GuestController@GetContent');
$router->get('/page/guest/feature', 'GuestController@GetFeature');
$router->get('/page/guest/service', 'GuestController@GetService');
$router->get('/page/guest/customer', 'GuestController@GetCustomer');
$router->post('/page/guest/newsletter', 'GuestController@CreateNewsLetter');
$router->post('/page/guest/contact', 'GuestController@CreateContact');
$router->get('/page/guest/team', 'GuestController@GetTeam');
$router->get('/page/guest/skill', 'GuestController@GetSkill');
$router->get('/page/guest/testimonial', 'GuestController@GetTestimonial');
$router->get('/page/guest/portfolio', 'GuestController@GetPortfolio');
$router->get('/page/guest/portfolio/{id}', 'GuestController@GetDetailPortfolio');
$router->get('/page/guest/pricing', 'GuestController@GetPricing');
$router->get('/page/guest/faq', 'GuestController@GetFaq');

# Blog
$router->get('/blog/article/post', 'BlogController@GetPostArticle');
$router->get('/blog/article/category', 'BlogController@GetArticleCategory');
$router->get('/blog/article/tag', 'BlogController@GetArticleTag');
$router->get('/blog/article/read/{slug}', 'BlogController@GetReadArticle');
$router->get('/blog/article/comment/{id}', 'BlogController@GetArticleComment');
$router->post('/blog/article/comment/{id}', 'BlogController@CreateArticleComment');
$router->delete('/blog/article/comment/{id}', 'BlogController@DeleteArticleComment');
