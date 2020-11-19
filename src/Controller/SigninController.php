<?php

namespace App\Controller;

use App\PHPClass\Twig;
use App\Model\User;
use App\PHPClass\UserManager;
use App\PHPClass\MessageFlash;

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
            $session = new MessageFlash();
            $session->setFlashMessage('Vous êtes bien connecté !', 'alert alert-success');
            $userManager->connectUser($user);
            header('Location: /Blog');
        }
    }

    public function disconnect(){
        $userManager = new UserManager();
        $userManager->userDisconnect();
        header('Location: /Blog');
    }
}
