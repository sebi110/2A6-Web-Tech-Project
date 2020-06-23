<?php

// USER

$router->get('/user/read', 'user@read');

$router->get('/user/read_one', 'user@read_one');

$router->post('/user/find', 'user@find');

$router->post('/user/create', 'user@create');

$router->delete('/user/delete', 'user@delete');

$router->put('/user/update', 'user@update');

$router->post('/user/form', 'user@form');


// ATTACK

$router->get('/attack/read', 'attack@read');

$router->get('/attack/find', 'attack@find');

$router->post('/attack/find', 'attack@find');


// HOME

$router->get('/home/register', 'home@register');

$router->get('/home/index', 'home@index');

$router->get('/home/login', 'home@login');

$router->get('/home/admin', 'home@admin');

$router->get('/home/form', 'home@form');

$router->get('/home/map', 'home@map');

$router->get('/home/graph', 'home@graph');

