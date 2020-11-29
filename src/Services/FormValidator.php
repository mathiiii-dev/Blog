<?php

namespace App\Services;

class FormValidator
{
    public function checkSignIn($user)
    {
        $userManager = new UserManager();
        $session = new MessageFlash();

        if (empty($_POST["password"]) || empty($_POST["pseudo"])){
            $session->setFlashMessage('Veuillez remplir tout les champs !', 'alert alert-warning');
            return false;
        }
        elseif (!$userManager->checkIfPseudoExist($user)){
            $session->setFlashMessage('Le pseudo n\'éxiste pas !', 'alert alert-danger');
            return false;
        }
        elseif (!$userManager->checkPasswordHash($user)){
            $session->setFlashMessage('Mauvais mot de passe !', 'alert alert-danger');
            return false;
        }
        return true;
    }

    public function checkSignUp($user)
    {
        $session = new MessageFlash();
        $userManager = new UserManager();
        if (!$userManager->isNotEmpty($user)){
            $session->setFlashMessage('Veuillez remplir tout les champs !', 'alert alert-warning');
            return false;
        }
        elseif (!$userManager->checkPasswordLength()){
            $session->setFlashMessage('Le mot de passe est trop court !', 'alert alert-danger');
            return false;
        }
        elseif (!$userManager->checkPseudo($user)){
            $session->setFlashMessage('Le pseudo est déjà utilisé !', 'alert alert-danger');
            return false;
        }
        elseif (!$userManager->checkEmail($user)){
            $session->setFlashMessage('Le mail est déjà utilisé !', 'alert alert-danger');
            return false;
        }
        return true;
    }

    public function checkPost($post)
    {

        $session = new MessageFlash();
        $postManager = new PostsManager();
        if (!$postManager->isNotEmpty($post)) {
            $session->setFlashMessage('Veuillez remplir tout les champs !', 'alert alert-warning');
            return false;
        }
        if (!$postManager->checkLength(50, $_POST['title'])) {
            $session->setFlashMessage('Le titre est trop long (max. 50) !', 'alert alert-danger');
            return false;
        }
        if (!$postManager->checkLength(100, $_POST['lead'])) {
            $session->setFlashMessage('Le châpo est trop long (max. 100) !', 'alert alert-danger');
            return false;
        }
        return true;
    }
}
