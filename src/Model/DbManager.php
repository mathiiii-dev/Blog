<?php

namespace App\Model;

class DbManager
{
    public function dbConnect()
    {
        try
        {
            $pdo = new \PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
            return $pdo;
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }

    }
}
