<?php

namespace App\Controller;

use App\Model\UserManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SigninController
{
    public function show() : void
    {
        $loader = new FilesystemLoader('src/View');
        $twig = new Environment($loader, [
            'cache' => false//'src/tmp',
        ]);

        echo $twig->render('signin.html.twig');
    }

    public function signIn()
    {
        $userManger = new UserManager();
        $userManger->newUser();
    }
}
