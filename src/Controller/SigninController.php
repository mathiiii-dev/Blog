<?php

namespace App\Controller;

use App\Model\User;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SigninController extends MainController
{
    public function show() : void
    {
        $loader = new FilesystemLoader('src/View');
        $twig = new Environment($loader, [
            'cache' => false//'src/tmp',
        ]);

        echo $twig->render('signin.html.twig');
    }

    public function signIn()
    {
        $lastname = $_POST['nom'];
        $firstname = $_POST['prenom'];
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $type = 'Blogger';
        $createdAt = date('d/m/y');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if (!empty($firstname) || !empty($lastname) || !empty($email) || !empty($pseudo) || !empty($password) || !empty($passwordHash))
        {
            $addUser = $this->dbConnect()->prepare("INSERT INTO user(firstname, lastname, email, pseudo, password, type, createdAt) VALUES('".$firstname."','".$lastname."','".$pseudo."','".$email."','".$passwordHash."','".$type."','".$createdAt."')");
            $addUser->execute(array($firstname , $lastname, $pseudo, $email, $passwordHash, $type, $createdAt));

            var_dump($addUser);

        }
    }
}
