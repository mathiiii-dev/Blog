<?php

namespace App\Services;

class AccessValidator extends Twig
{
    public function validAccess($idUser)
    {
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $cookieId = $cookie[0] ?? null;
        $sessionId = $_SESSION['id'] ?? null;

        if (!$cookieId && !$sessionId) {
            return false;
        }

        if ($idUser != $sessionId ? NULL : $cookieId) {
            return false;
        }

        return true;
    }
}