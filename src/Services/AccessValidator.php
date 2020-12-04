<?php

namespace App\Services;

class AccessValidator extends Twig
{
    public function validAccess($idUser = null)
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

    public function validAdminAccess(string $type = null)
    {
        if ($type != "Admin") {
            http_response_code(500);
            return $this->twig('500.html.twig');
        }
        return true;
    }
}