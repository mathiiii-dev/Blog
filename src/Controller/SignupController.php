<?php

namespace App\Controller;

use App\Model\UserManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SignupController
{
    public function show() : void
    {
        $loader = new FilesystemLoader('src/View');
        $twig = new Environment($loader, [
            'cache' => false//'src/tmp',
        ]);

        echo $twig->render('signup.html.twig');
    }

    public function signUp() : void
    {
        $userManger = new UserManager();
        $userManger->newUser();
        $this->show();
    }
}
