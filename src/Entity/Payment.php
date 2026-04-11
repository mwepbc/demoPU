<?php

namespace App\Entity;

use App\Database;
use PDO;

class Payment
{
    private PDO $dbh;

    public function __construct(
        private Database $db
    ) {
        $this->dbh = $db->getDbh();
    }

    function fetchAllPayments(): ?array
    {
        $sth = $this->dbh->prepare("SELECT * FROM `payments`");
        $sth->execute([]);
        return $sth->fetchAll();
    }

    function findPayment(int $id): ?array
    {
        $sth = $this->dbh->prepare("SELECT * FROM `payments` WHERE id = ?");
        $sth->execute([$id]);
        return $sth->fetch();
    }
}
