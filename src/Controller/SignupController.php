<?php

namespace App\Controller;

use App\Model\Twig;
use App\Model\User;
use App\Model\UserManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SignupController extends Twig
{
    public function show($filter = null) : void
    {
        $this->twig('signup.html.twig', ['erreur'=>''.$filter.'']);
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
        if (!$userManager->isNotEmpty($user)){
            $this->show('Veuillez remplir tout les champs');
        }
        elseif (!$userManager->checkPasswordLength()){
            $this->show('Mot de passe trop court');
        }
        elseif (!$userManager->checkPseudo($user)){
            $this->show('Pseudo déjà pris');
        }
        elseif (!$userManager->checkEmail($user)){
            $this->show('Email déjà pris');
        }else{
            $userManager->addUser($user);
            $signin = new SigninController();
            $signin->show();
        }

    }
}
