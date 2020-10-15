<?php

namespace App\Model;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    public function twig(string $view, array $filter) : void
    {
        $loader = new FilesystemLoader('src/View');
        $twig = new Environment($loader, [
            'cache' => false//'src/tmp',
        ]);

        if(!isset($_SESSION))
        {
            session_start();
        }
        $userManager = new UserManager();
        $userManager->getRememberMe();

        $twig->addGlobal('session', $_SESSION ?? $userManager);

        echo $twig->render($view, $filter);
    }
}
