<?php

namespace App\Services;

use PDO;
use PDOException;

class DbManager
{
    public function dbConnect(): \PDO
    {
        try {
            $db = new PDO(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_OPTION);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
        return $db;
    }
}
