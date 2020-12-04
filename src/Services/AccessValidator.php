<?php

namespace App\Services;

class AccessValidator extends Twig
{
    public function isValid($idUser = null): bool
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

    public function isValidAdmin(string $type = null): bool
    {
        if ($type != "Admin") {
            http_response_code(500);
            $this->twig('500.html.twig');
            return false;
        }
        return true;
    }
}