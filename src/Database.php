<?php
namespace App;

use PDO;

class Database{
    private PDO $dbh;

    public function __construct() {
        $dsn = "mysql:dbname=demopa;host=localhost";
        $user = "root";
        $password = "";

        $this->dbh = new PDO($dsn, $user, $password);
    }

    public function getDbh(): PDO{
        return $this->dbh;
    }
}