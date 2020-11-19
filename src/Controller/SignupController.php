<?php

namespace App\Controller;

use App\Repository\BloggerRepository;
use App\Repository\UserRepository;
use App\PHPClass\Twig;
use App\Model\User;
use App\PHPClass\UserManager;

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
            $userRepo = new UserRepository();
            $bloggerRepo = new BloggerRepository();
            $userRepo->addUser($user);
            $id = $userRepo->getLastUserId();
            $bloggerRepo->createUserProfil((int)$id[0]);
            header('Location: sign-in');
        }
    }


}
