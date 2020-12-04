<?php

namespace App\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    public function twig(string $view, array $parameter = []): void
    {
        ob_start();
        $loader = new FilesystemLoader('src/View');
        $twig = new Environment($loader, [
            'cache' => false//'src/tmp',
        ]);

        $userManager = new UserManager();
        $rememberMe = $userManager->getRememberMe();
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $twig->addGlobal('session', $_SESSION ?? $rememberMe);
        $twig->addGlobal('idUser', $_SESSION['id'] ?? $cookie[0]);
        echo $twig->render($view, $parameter);
    }
}
