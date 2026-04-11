<?php

namespace App\Entity;

use App\Database;
use PDO;

class Course
{
    private PDO $dbh;

    public function __construct(
        private Database $db
    ) {
        $this->dbh = $db->getDbh();
    }

    function fetchAllCourses(): ?array
    {
        $sth = $this->dbh->prepare("SELECT * FROM `courses`");
        $sth->execute([]);
        return $sth->fetchAll();
    }

    function findCourse(int $id): ?array
    {
        $sth = $this->dbh->prepare("SELECT * FROM `courses` WHERE id = ?");
        $sth->execute([$id]);
        return $sth->fetch();
    }
}
