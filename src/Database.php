<?php

namespace App;

use PDO;

class Database
{
    private PDO $dbh;

    public function __construct()
    {
        // для хоста
        // $dsn = "mysql:dbname=f1257984_db;host=localhost";
        // $user = "f1257984_db";
        // $password = "f1257984_db";

        $dsn = "mysql:dbname=demopa;host=localhost";
        $user = "root";
        $password = "";

        $this->dbh = new PDO($dsn, $user, $password);
    }

    public function getDbh(): PDO
    {
        return $this->dbh;
    }
}
