<?php


namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class MailController
{
    public function sendMail()
    {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $sujet = $_POST['sujet'];
        $message = $_POST['message'];


        $loader = new FilesystemLoader('src/View');
        $twig = new Environment($loader,[
            'cache' => false//'src/tmp',
        ]);

        if(empty($nom) OR empty($email) OR empty($sujet) OR empty($message))
        {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erreur ! </strong> Veuillez remplir tout les champs du formulaire.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
        }
        else
        {
            $to = "mat.micheli99@gmail.com";
            $email_sujet = 'Blog : ' . $sujet;
            $email_message = 'Nom : '. $nom . '<br>Email : ' . $email . '<br>Message : ' . $message;
            $headers = "De : " . $email;
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            if (mail($to, $email_sujet, $email_message, $headers)){
                echo $twig->render('home.html.twig');
                echo "<div class='alert alert-succes alert-dismissible fade show' role='alert'>
                    <strong>Message envoyé !</strong> Nous reviendrons vers vous au plus vite.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }else{
                echo $twig->render('home.html.twig');
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erreur !</strong> Veuillez reessayer plus tard.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
            }
        }
    }
}
