<?php

namespace App\Services;

class AccessValidator extends Twig
{
    public function isValid($idUser = null): bool
    {
        $cookie = $_COOKIE['auth'] ?? null;
        $cookie = explode('-----', $cookie);
        $sessionId = $_SESSION['id'] ?? $cookie[0]?? null;

        if (!$sessionId) {
            return false;
        }


        if ($idUser != $sessionId) {
            return false;
        }

        return true;
    }

    public function isValidAdmin(string $type = null): bool
    {
        if ($type != "Admin") {
            http_response_code(500);
            $this->renderView('500.html.twig');
            exit();
        }
        return true;
    }
}
