<?php

namespace App\Controller;

class MailController {

    public function sendMail()
    {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $sujet = $_POST['sujet'];
        $message = $_POST['message'];

        $to = "mat.micheli99@gmail.com";
        $email_sujet = 'Blog : ' . $sujet;
        $email_message = 'Nom : '. $nom . '<br>Email : ' . $email . '<br>Message : ' . $message;
        $headers = "De : " . $email;
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        if (mail($to, $email_sujet, $email_message, $headers)){
            throw new \Exception('Success', 200);
        }else {
            throw new \Exception('Error', 500);
        }
    }
}
