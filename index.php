<?php

use App\Router\Router;

require 'vendor/autoload.php';
session_start();
define('ROOT_DIR', basename(dirname(__FILE__)));

define('ROOT_DIR', basename(dirname(__FILE__)));

$router = new Router($_GET['url']);
$router->get('/', 'Home#show');
$router->get('/sign-up', 'Signup#show');
$router->get('/sign-in', 'Signin#show');
$router->post('/signUp', 'Signup#signUp');
$router->post('/signIn', 'Signin#signIn');
$router->post('/sendmail', 'Mail#sendMail');
$router->get('/exit', 'Signin#disconnect');
$router->get('/posts', 'Posts#showAllPosts');
$router->get('/posts/:id', 'Posts#show');
$router->get('/create-post', 'Posts#showCreatePost');
$router->post('/createPost', 'Posts#createPost');
$router->get('/modify-post/:id', 'Posts#showModifyPost');
$router->post('/modifyPost/:id', 'Posts#modifyPost');
$router->get('/delete-post/:id', 'Posts#deletePost');

$router->run();
