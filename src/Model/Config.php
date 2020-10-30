<?php

namespace App\Model;

class Config
{

    const DB_HOST = 'mysql:dbname=blog;host=127.0.0.1';
    const DB_USER = 'root';
    const DB_PASSWORD = '';
    const DB_OPTION = [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];

}
