<?php

namespace App\Services;

use App\Repository\UserRepository;
use App\Model\User;

class UserManager extends UserRepository
{
    public function isNotEmpty(User $user) : bool
    {
        $lastname = $user->getLastname();
        $firstname = $user->getFirstname();
        $email = $user->getEmail();
        $pseudo = $user->getPseudo();
        $password = $user->getPassword();

        if (empty($lastname) && empty($firstname) && empty($email) && empty($pseudo) && empty($password)) {
            return false;
        }

        return true;
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
        if (!$this->getUserByPseudo($pseudo)) {
            return false;
        }
        return true;
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

    public function setRememberMe(User $user)
    {
        if (isset($_POST["remember"])){
            $pseudo = $user->getPseudo();
            $userInfo = $this->getUserByPseudo($pseudo);
            setcookie('auth', $userInfo[0] . '-----' . sha1($userInfo['pseudo'] . $userInfo['password'] . $userInfo['type'] . $_SERVER['REMOTE_ADDR']), time() + 3600 * 24 * 30, '/', 'localhost', false, true);
        }
    }

    public function getRememberMe()
    {
        if (isset($_COOKIE['auth'])){
            $auth = $_COOKIE['auth'];
            $auth = explode('-----', $auth);
            $userManager = new UserManager();
            $userInfo = $userManager->getUserById($auth[0]);
            $key = sha1($userInfo['pseudo'] . $userInfo['password'] . $userInfo['type'] . $_SERVER['REMOTE_ADDR']);
            if ($key == $auth[1]){
                $_SESSION['Auth'] = (array)$userInfo;
                setcookie('auth', $userInfo['id'] . '-----' . $key, time() + 3000 * 24 * 30, '/', 'localhost', false, true);
            }else{
                setcookie('auth', '', time() - 3600, '/', 'localhost', false, true);
            }
        }
    }

    public function connectUser(User $user) : bool
    {
        if (!$this->checkPasswordHash($user) && !$this->checkIfPseudoExist($user)) {
            return false;
        }
        $pseudo = $user->getPseudo();
        $userInfo = $this->getUserByPseudo($pseudo);
        $_SESSION['id'] = $userInfo['id'];
        $_SESSION['pseudo'] = $userInfo['pseudo'];
        $_SESSION['password'] = $userInfo['password'];
        $_SESSION['type'] = $userInfo['type'];
        $this->setRememberMe($user);
        return true;
    }

    public function userDisconnect(){
        session_unset();
        session_destroy();
        if (isset($_COOKIE['auth'])) {
            unset($_COOKIE['auth']);
            setcookie('auth', null, -1, '/');
        }
    }
}
