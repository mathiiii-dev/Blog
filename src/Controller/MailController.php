<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Services\{MessageFlash, RandomPassword, SendMail};

class MailController
{

    public function sendMail()
    {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $sujet = $_POST['sujet'];
        $message = $_POST['message'];

        $emailSujet = 'Blog : ' . $sujet;
        $emailMessage = 'Nom : ' . $nom . '<br>Email : ' . $email . '<br>Message : ' . $message;
        $sendMail = new SendMail();
        $sendMail->sendMail($emailSujet, $emailMessage, $email);

    }

    public function sendNewPassword()
    {

        $email = $_POST['email'];
        $userRepo = new UserRepository();

        if (!$userRepo->getUserByEmail($email)) {
            $session = new MessageFlash();
            $session->setFlashMessage('Le mail saisie n\'existe pas ! ', 'danger');
            header("Location: /Blog/sign-in");
            exit();
        }

        $randomPassword = new RandomPassword();
        $newPassword = $randomPassword->random();
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $userRepo->newPassword($newPasswordHash, $email);
        $sendMail = new SendMail();
        $emailSujet = 'Nouveau mot de passe';
        $emailMessage = 'Voici votre nouveau mot de passe : ' . $newPassword;
        $sendMail->sendMail($emailSujet, $emailMessage, $email);

        $session = new MessageFlash();
        $session->setFlashMessage('Votre mot de passe à bien été modifié ! Il vous a été envoyé par mail', 'success');
        header("Location: /Blog/sign-in");
    }

}
