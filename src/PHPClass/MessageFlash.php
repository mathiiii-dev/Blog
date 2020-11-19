<?php


namespace App\PHPClass;


class MessageFlash
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    public function setFlashMessage(string $message, string $class)
    {
        $_SESSION['flash'] = [
            'message' => $message,
            'class' => $class
        ];
    }

    public function showFlashMessage()
    {
        if (!empty($_SESSION['flash'])){
            try{
                return $_SESSION['flash'];
            }
            finally
            {
                unset($_SESSION['flash']);
            }
        }
    }
}