<?php

namespace App\Model;

class UserManager extends DbManager
{
    public function __construct()
    {
        $this->dbConnect();
    }

    public function newUser()
    {
        $lastname = $_POST['nom'];
        $firstname = $_POST['prenom'];
        $email = $_POST['email'];
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $type = 'Blogger';
        $createdAt = date('d/m/y');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if (!empty($firstname) || !empty($lastname) || !empty($email) || !empty($pseudo) || !empty($password) || !empty($passwordHash)) {

            if (!$this->getUserByPseudo($pseudo) == null) {

                echo 'Pseudo deja pris';

            } elseif (!$this->getUserByEmail($email) == null) {

                echo 'Mail déja pris';

            } else {
                $addUser = $this->dbConnect()->prepare("INSERT INTO user(firstname, lastname, email, pseudo, password, type, createdAt)
                VALUE ('" . $firstname . "','" . $lastname . "','" . $email . "','" . $pseudo . "','" . $passwordHash . "','" . $type . "','" . $createdAt . "')");
                $addUser->execute(array($firstname, $lastname, $email, $pseudo, $passwordHash, $type, $createdAt));
            }

        } else {

            echo 'remplir tout les champs';

        }
    }

    public function getUserByPseudo($pseudo)
    {
        $userPseudo = $this->dbConnect()->prepare("SELECT * FROM User WHERE pseudo = :pseudo");
        $userPseudo->bindValue(':pseudo', $pseudo);
        $userPseudo->execute();
        $userPseudo->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\User');
        return $userPseudo->fetch();
    }

    public function getUserByEmail($email)
    {
        $userEmail = $this->dbConnect()->prepare("SELECT * FROM User WHERE email = :email");
        $userEmail->bindValue(':email', $email);
        $userEmail->execute();
        $userEmail->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\User');
        return $userEmail->fetch();
    }
}
