<?php

use App\Router\Router;

require 'vendor/autoload.php';

$router = new Router($_GET['url']);

$router->get('/', 'Home#show');

$router->run();




