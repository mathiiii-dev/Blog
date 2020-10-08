<?php

namespace App\Model;

use App\Model\Repository\UserRepository;

class UserManager extends UserRepository
{
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
        return false;
    }

    public function checkPasswordLength() : bool
    {
        $password = $_POST['password'];
        if (strlen($password) < 8) {
            return false;
        }
        return true;
    }

    public function checkPseudo(User $user) : bool
    {
        if (!$this->getUserByPseudo($user->getPseudo()) == null) {
            return false;
        }
        return true;
    }

    public function checkEmail(User $user): bool
    {
        if (!$this->getUserByEmail($user->getEmail()) == null) {
            return false;
        }
        return true;
    }

    public function checkIfPseudoExist(User $user) : bool
    {
        $pseudo = $user->getPseudo();
        if ($this->getUserByPseudo($pseudo)) {
            return true;
        }
        return false;
    }

    public function checkPasswordHash(User $user) : bool
    {
        if ($this->checkIfPseudoExist($user)){
            $password = $user->getPassword();
            if (password_verify($password, $this->getPasswordHash($user))) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function connectUser(User $user) : bool
    {
        if ($this->checkPasswordHash($user) && $this->checkIfPseudoExist($user)) {
            session_start();
            $pseudo = $user->getPseudo();
            $userInfo = $this->getUserByPseudo($pseudo);
            $_SESSION['id'] = $userInfo[0];
            $_SESSION['pseudo'] = $userInfo[4];
            $_SESSION['password'] = $userInfo[5];
            $_SESSION['type'] = $userInfo[6];
            return true;
        } else {
            return false;
        }
    }
}
