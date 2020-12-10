<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Services\MessageFlash;

class MailController
{

    public function sendMail()
    {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $sujet = $_POST['sujet'];
        $message = $_POST['message'];

        $to = "mat.micheli99@gmail.com";
        $emailSujet = 'Blog : ' . $sujet;
        $emailMessage = 'Nom : ' . $nom . '<br>Email : ' . $email . '<br>Message : ' . $message;
        $headers = "De : " . $email;
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";

        $httpCode = 200;
        $httpMessage = "Success";

        if (!mail($to, $emailSujet, $emailMessage, $headers)) {
            $httpCode = 500;
            $httpMessage = "Error";
        }

        http_response_code($httpCode);
        header('Content-Type: application/json');

        echo json_encode(array(
            'status' => $httpCode,
            'message' => $httpMessage
        ));

    }

    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function sendNewPassword()
    {

        $email = $_POST['email'];
        $userRepo = new UserRepository();

        if (!$userRepo->getUserByEmail($email)) {
            $session = new MessageFlash();
            $session->setFlashMessage('Le mail saisie n\'existe pas ! ', 'danger');
            return header("Location: /Blog/sign-in");
        }

        $newPassword = $this->randomPassword();
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $userRepo->newPassword($newPasswordHash, $email);
        $to = "mat.micheli99@gmail.com";
        $emailSujet = 'Nouveau mot de passe';
        $emailMessage = 'Votre nouveau mot de passe est : ' . $newPassword;
        $headers = "De : " . $email;
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";

        $httpCode = 200;
        $httpMessage = "Success";

        if (!mail($to, $emailSujet, $emailMessage, $headers)) {
            $httpCode = 500;
            $httpMessage = "Error";
        }

        http_response_code($httpCode);
        header('Content-Type: application/json');

        echo json_encode(array(
            'status' => $httpCode,
            'message' => $httpMessage
        ));

        $session = new MessageFlash();
        $session->setFlashMessage('Votre mot de passe à bien été modifié ! Il vous a été envoyé par mail', 'success');
        header("Location: /Blog/sign-in");
    }

}
