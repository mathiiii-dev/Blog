<?php

use App\Router\Router;

require 'vendor/autoload.php';

session_start();

define('ROOT_DIR', basename(dirname(__FILE__)));
define("ADMIN",'Location: /Blog/admin');
define("POST",'Location: /Blog/post');
define("POSTS",'Location: /Blog/posts');
define("ERR_500",'500.html.twig');
define("MODEL_ANSWER",'\Model\Answer');
define("MODEL_USER",'\Model\User');
define("MODEL_POST",'\Model\Post');
define("ID_POST",':idPost');
define("EMAIL",':email');
define("PSEUDO",':pseudo');
define("FORM_FIELDS",'Veuillez remplir tout les champs !');
define("COOKIE_SEPARATOR",'-----');

$router = new Router($_GET['url']);
$router->get('/', 'Home#show');
$router->get('/sign-up', 'Signup#show');
$router->get('/sign-in', 'Signin#show');
$router->post('/signUp', 'Signup#signUp');
$router->post('/signIn', 'Signin#signIn');
$router->post('/sendmail', 'Mail#sendMail');
$router->get('/exit', 'Signin#disconnect');
$router->get('/posts/:page', 'Posts#showAllPosts');
$router->get('/post/:id', 'Posts#show');
$router->get('/create-post', 'Posts#createPost');
$router->post('/create-post', 'Posts#createPost');
$router->get('/modify-post/:id', 'Posts#modifyPost');
$router->post('/modify-post/:id', 'Posts#modifyPost');
$router->get('/delete-post/:id', 'Posts#deletePost');
$router->get('/profil/:id', 'Blogger#show');
$router->get('/modify-profil/:id', 'Blogger#modifyProfil');
$router->post('/modify-profil/:id', 'Blogger#modifyProfil');
$router->post('/createAnswer/:id', 'Answer#createAnswer');
$router->get('/modify-answer/:id', 'Answer#modifyAnswer');
$router->post('/modify-answer/:id', 'Answer#modifyAnswer');
$router->get('/delete-answer/:id', 'Answer#deleteAnswer');
$router->get('/admin', 'Admin#show');
$router->post('/validate-post/:id', 'Admin#validatePost');
$router->post('/validate-answer/:idAnswer', 'Admin#validateAnswer');
$router->post('/admin-delPost/:idPost', 'Admin#deletePost');
$router->post('/admin-delAnswer/:idAnswer', 'Admin#deleteAnswer');
$router->post('/sendNewPassword', 'Mail#sendNewPassword');

$router->run();
