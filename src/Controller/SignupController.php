<?php

namespace App\Controller;

use App\Services\{FormValidator, MessageFlash, Twig};
use App\Repository\{BloggerRepository, UserRepository};
use App\Model\User;

class SignupController extends Twig
{
    public function show(): void
    {
        $session = new MessageFlash();
        $flash = $session->showFlashMessage();
        $this->renderView(
            'signup.html.twig', [
            'message' => $flash['message'] ?? null,
            'class' => $flash['class'] ?? null
            ]
        );
    }

    public function signUp()
    {
        $user = new User(
            [
            'lastname' => $_POST['nom'],
            'firstname' => $_POST['prenom'],
            'pseudo' => $_POST['pseudo'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'type' => 'Blogger',
            'createdAt' => date('y-m-d')
            ]
        );
        $checkSignIn = new FormValidator();

        if (!$checkSignIn->checkSignUp($user)) {
            header('Location: /Blog/sign-up');
            exit();
        }
        $session = new MessageFlash();
        $session->setFlashMessage('Votre compte a bien été créé ! Vous pouvez maintenant vous connecter', 'success');
        $userRepo = new UserRepository();
        $bloggerRepo = new BloggerRepository();
        $userRepo->addUser($user);
        $id = $userRepo->getLastUserId();
        $bloggerRepo->createUserProfil((int)$id[0]);
        header('Location: sign-in');
    }
}
