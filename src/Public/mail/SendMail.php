<?php

$nom = $_POST['nom'];
$email = $_POST['email'];
$sujet = $_POST['sujet'];
$message = $_POST['message'];

if (!isset($nom, $email, $sujet, $message))
{
    echo 'Veuillez remplir tout les champs du formulaire';
}
else
{
    $to = "mat.micheli99@gmail.com";
    $from = $email;
    $email_sujet = 'Blog' . $sujet;
    $email_message = 'Nom : '. $nom . '<br>Email : ' . $email . '<br>Message : ' . $message;
    $headers = "De : " . $email;
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    if (mail($to, $email_sujet, $email_message, $headers)){
        echo 'envoyer';
    }else{
        echo "erreur lors de l'envoie";
    }
}
