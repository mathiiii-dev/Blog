<?php

namespace App\Controller;

use App\Services\FormValidator;
use App\Services\Twig;
use App\Model\User;
use App\Services\UserManager;
use App\Services\MessageFlash;

class SigninController extends Twig
{
    public function show()
    {
        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->twig('signin.html.twig', [
            'message' => $flash['message'] ?? null,
            'class' => $flash['class'] ?? null
        ]);
    }

    public function signIn()
    {
        $user = new User([
            'pseudo' => $_POST['pseudo'],
            'password' => $_POST['password']
        ]);

        $userManager = new UserManager();
        $checkSignIn = new FormValidator();
        if (!$checkSignIn->checkSignIn($user)) {
            return header('Location: /Blog/sign-in');
        }
        $session = new MessageFlash();
        $session->setFlashMessage('Vous êtes bien connecté !', 'success');
        $userManager->connectUser($user);
        header('Location: /Blog');
    }

    public function disconnect()
    {
        $userManager = new UserManager();
        $userManager->userDisconnect();
        header('Location: /Blog');
    }
}
