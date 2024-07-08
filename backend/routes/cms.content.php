<?php

# Article
$router->get('/cms/content/article', 'ArticleController@list');
$router->post('/cms/content/article/create', 'ArticleController@create');
$router->put('/cms/content/article/update/{id}', 'ArticleController@update');
$router->get('/cms/content/article/{id}', 'ArticleController@show');
$router->delete('/cms/content/article/{id}', 'ArticleController@destroy');
$router->get('/cms/content/article-option/{type}', 'ArticleController@options');

# Portfolio Image
$router->get('/cms/content/portfolio-image/list/{id}', 'PortfolioImageController@list');
$router->post('/cms/content/portfolio-image/create/{id}', 'PortfolioImageController@create');
$router->get('/cms/content/portfolio-image/primary/{id}', 'PortfolioImageController@primary');
$router->delete('/cms/content/portfolio-image/delete/{id}', 'PortfolioImageController@destroy');

# Faq
$router->get('/cms/content/faq', 'FaqController@list');
$router->post('/cms/content/faq/create', 'FaqController@create');
$router->put('/cms/content/faq/update/{id}', 'FaqController@update');
$router->get('/cms/content/faq/{id}', 'FaqController@show');
$router->delete('/cms/content/faq/{id}', 'FaqController@destroy');

# Feature
$router->get('/cms/content/feature', 'FeatureController@list');
$router->post('/cms/content/feature/create', 'FeatureController@create');
$router->put('/cms/content/feature/update/{id}', 'FeatureController@update');
$router->get('/cms/content/feature/{id}', 'FeatureController@show');
$router->delete('/cms/content/feature/{id}', 'FeatureController@destroy');

# Portfolio
$router->get('/cms/content/portfolio', 'PortfolioController@list');
$router->post('/cms/content/portfolio/create', 'PortfolioController@create');
$router->put('/cms/content/portfolio/update/{id}', 'PortfolioController@update');
$router->get('/cms/content/portfolio/{id}', 'PortfolioController@show');
$router->delete('/cms/content/portfolio/{id}', 'PortfolioController@destroy');

# Pricing
$router->get('/cms/content/pricing', 'PricingController@list');
$router->post('/cms/content/pricing/create', 'PricingController@create');
$router->put('/cms/content/pricing/update/{id}', 'PricingController@update');
$router->get('/cms/content/pricing/{id}', 'PricingController@show');
$router->delete('/cms/content/pricing/{id}', 'PricingController@destroy');

# Service
$router->get('/cms/content/service', 'ServiceController@list');
$router->post('/cms/content/service/create', 'ServiceController@create');
$router->put('/cms/content/service/update/{id}', 'ServiceController@update');
$router->get('/cms/content/service/{id}', 'ServiceController@show');
$router->delete('/cms/content/service/{id}', 'ServiceController@destroy');

# Skill
$router->get('/cms/content/skill', 'SkillController@list');
$router->post('/cms/content/skill/create', 'SkillController@create');
$router->put('/cms/content/skill/update/{id}', 'SkillController@update');
$router->get('/cms/content/skill/{id}', 'SkillController@show');
$router->delete('/cms/content/skill/{id}', 'SkillController@destroy');

# Slider
$router->get('/cms/content/slider', 'SliderController@list');
$router->post('/cms/content/slider/create', 'SliderController@create');
$router->put('/cms/content/slider/update/{id}', 'SliderController@update');
$router->get('/cms/content/slider/{id}', 'SliderController@show');
$router->delete('/cms/content/slider/{id}', 'SliderController@destroy');

# Testimonial
$router->get('/cms/content/testimonial', 'TestimonialController@list');
$router->post('/cms/content/testimonial/create', 'TestimonialController@create');
$router->put('/cms/content/testimonial/update/{id}', 'TestimonialController@update');
$router->get('/cms/content/testimonial/{id}', 'TestimonialController@show');
$router->delete('/cms/content/testimonial/{id}', 'TestimonialController@destroy');


