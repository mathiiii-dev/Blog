<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SigninController
{
    public function show()
    {
        $loader = new FilesystemLoader('src/View');
        $twig = new Environment($loader, [
            'cache' => false//'src/tmp',
        ]);

        echo $twig->render('signin.html.twig');
    }
}