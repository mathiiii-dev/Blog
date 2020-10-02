<?php

namespace App\Model;

class UserManager extends DbManager
{
    public function __construct()
    {
        $this->dbConnect();
    }

    public function isNotEmpty(User $user) : bool
    {
        $lastname = $user->getLastname();
        $firstname = $user->getFirstname();
        $email = $user->getEmail();
        $pseudo = $user->getPseudo();
        $password = $user->getPassword();

        if (!empty($lastname) && !empty($firstname) && !empty($email) && !empty($pseudo) && !empty($password)) {
            return true;
        }
        echo "<strong>Erreur !</strong> Veuillez remplir tout les champs";
        return false;
    }

    public function checkPasswordLength() : bool
    {
        $password = $_POST['password'];
        if (strlen($password) < 8) {
            echo "<strong>Erreur !</strong> Le mot de passe est trop court";
            return false;
        }
        return true;
    }

    public function addUser(User $user) : void
    {
        if ($this->isNotEmpty($user) && $this->checkPasswordLength() && $this->checkPseudo($user) && $this->checkEmail($user)) {
            $addUser = $this->dbConnect()->prepare(
                'INSERT INTO User (firstname, lastname, email, pseudo, password, type, createdAt) 
            VALUES (:firstname, :lastname, :email, :pseudo, :password, :type, :createdAt)'
            );

            $addUser->bindValue(':firstname', $user->getFirstname(), \PDO::PARAM_STR);
            $addUser->bindValue(':lastname', $user->getLastname(), \PDO::PARAM_STR);
            $addUser->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
            $addUser->bindValue(':pseudo', $user->getPseudo(), \PDO::PARAM_STR);
            $addUser->bindValue(':password', $user->getPassword(), \PDO::PARAM_STR);
            $addUser->bindValue(':type', $user->getType(), \PDO::PARAM_STR);
            $addUser->bindValue(':createdAt', $user->getCreatedAt(), \PDO::PARAM_STR);

            $addUser->execute();
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

    public function checkPseudo(User $user) : bool
    {
        if (!$this->getUserByPseudo($user->getPseudo()) == null) {
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

    public function checkEmail(User $user) : bool
    {
        if (!$this->getUserByEmail($user->getEmail()) == null) {
            echo "<strong>Erreur !</strong> L'email est déjà enregistré";
            return false;
        }
        return true;
    }
}