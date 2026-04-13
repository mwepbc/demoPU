<?php

namespace App\Entity;

use App\Database;
use PDO;

class Status
{
    private PDO $dbh;

    public function __construct(
        private Database $db
    ) {
        $this->dbh = $db->getDbh();
    }

    function fetchStatuses(): ?array
    {
        $sth = $this->dbh->prepare("SELECT * FROM `statuses` WHERE NOT `name` = 'Новая'");
        $sth->execute([]);
        return $sth->fetchAll();
    }

    function findStatus(int $id): ?array
    {
        $sth = $this->dbh->prepare("SELECT * FROM `statuses` WHERE id = ?");
        $sth->execute([$id]);
        return $sth->fetch();
    }
}
