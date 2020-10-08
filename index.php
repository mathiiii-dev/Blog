<?php

use App\Router\Router;

require 'vendor/autoload.php';

$router = new Router($_GET['url']);
$router->get('/', 'Home#show');
$router->get('/sign-up', 'Signup#show');
$router->get('/sign-in', 'Signin#show');
$router->post('/signUp', 'Signup#signUp');
$router->post('/signIn', 'Signin#signIn');
$router->post('/sendmail', 'Mail#sendMail');
$router->get('/exit', 'Signin#disconnect');
$router->run();
