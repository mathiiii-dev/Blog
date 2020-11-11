<?php

namespace App\Model;

class DbManager
{
    public function dbConnect()
    {
        try
        {
            return  new \PDO(Config::DB_HOST,Config::DB_USER, Config::DB_PASSWORD, Config::DB_OPTION);
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
