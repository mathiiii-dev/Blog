<?php

namespace App\Controller;

use App\Model\Twig;
use App\Model\User;
use App\Model\UserManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SignupController extends Twig
{
    public function show() : void
    {
        $this->twig('signup.html.twig', [''=>'']);
    }

    public function signUp() : void
    {
        $user = new User([
            'lastname' => $_POST['nom'],
            'firstname' => $_POST['prenom'],
            'pseudo' => $_POST['pseudo'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'type' => 'Blogger',
            'createdAt' => date('y-m-d')
        ]);

        $userManager = new UserManager();
        $userManager->addUser($user);
        $this->show();
    }
}
