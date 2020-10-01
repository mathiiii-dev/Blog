<?php

namespace App\Model;

use App\Controller\SigninController;

class UserManager extends DbManager
{
    public function __construct()
    {
        $this->dbConnect();
    }

    public function isNotEmpty()
    {
        $lastname = $_POST['nom'];
        $firstname = $_POST['prenom'];
        $email = $_POST['email'];
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];

        if (!empty($lastname) && !empty($firstname) && !empty($email) && !empty($pseudo) && !empty($password)) {
            return true;
        }
        echo "<strong>Erreur !</strong> Veuillez remplir tout les champs";
        return false;
    }

    public function checkPassword()
    {
        $password = $_POST['password'];
        if (strlen($password) < 8 ) {
            echo "<strong>Erreur !</strong> Le mot de passe est trop court";
            return false;
        }
        return true;
    }

    public function newUser()
    {
        $lastname = $_POST['nom'];
        $firstname = $_POST['prenom'];
        $email = $_POST['email'];
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $type = 'Blogger';
        $createdAt = date('y/m/d');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if ($this->isNotEmpty() && $this->checkPassword() && $this->checkEmail() && $this->checkPseudo()) {
            $addUser = $this->dbConnect()->prepare("INSERT INTO user(firstname, lastname, email, pseudo, password, type, createdAt)
            VALUE ('" . $firstname . "','" . $lastname . "','" . $email . "','" . $pseudo . "','" . $passwordHash . "','" . $type . "','" . $createdAt . "')");
            $addUser->execute(array($firstname, $lastname, $email, $pseudo, $passwordHash, $type, $createdAt));
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

    public function checkPseudo()
    {
        if (!$this->getUserByPseudo($_POST['pseudo']) == null) {
            echo "<strong>Erreur !</strong> Le pseudo est déjà enregistré";
            return false;
        }
        return true;
    }

    public function getUserByEmail($email)
    {
        $userEmail = $this->dbConnect()->prepare("SELECT * FROM User WHERE email = :email");
        $userEmail->bindValue(':email', $email);
        $userEmail->execute();
        $userEmail->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Model\User');
        return $userEmail->fetch();
    }

    public function checkEmail()
    {
        if (!$this->getUserByEmail($_POST['email']) == null) {
            echo "<strong>Erreur !</strong> L'email est déjà enregistré";
            return false;
        }
        return true;
    }
}
