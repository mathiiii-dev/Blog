<?php

namespace App\Controller;

use App\Model\Twig;
use App\Model\User;
use App\Model\UserManager;

class SigninController extends Twig
{
    public function show($filter = null) : void
    {
        $this->twig('signin.html.twig',['erreur'=>''.$filter.'']);
    }

    public function signIn() : void
    {
       $user = new User([
            'pseudo' => $_POST['pseudo'],
            'password' => $_POST['password']
       ]);
        $userManager = new UserManager();
        if (empty($_POST["password"]) || empty($_POST["pseudo"])){
            $this->show('Veuillez remplir tout les champs');
        }
        elseif (!$userManager->checkIfPseudoExist($user)){
            $this->show('Pseudo incorrect');
        }
        elseif (!$userManager->checkPasswordHash($user)){
            $this->show('Mauvais mot de passe');
        }
        else{
            $userManager->connectUser($user);
            $home = new HomeController();
            $home->show();
        }
    }

    public function disconnect(){
        $userManager = new UserManager();
        $userManager->userDisconnect();
        $home = new HomeController();
        $home->show();
    }
}
