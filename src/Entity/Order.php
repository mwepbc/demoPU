<?php

namespace App\Entity;

use App\Database;
use PDO;

class Order
{
    private PDO $dbh;

    public function __construct(
        private Database $db
    ) {
        $this->dbh = $db->getDbh();
    }

    function fetchAllOrders(): ?array {
        $sth = $this->dbh->prepare("SELECT * FROM `orders`");
        $sth->execute([]);
        return $sth->fetchAll();
    }

    function fetchUsersOrders($id): ?array
    {
        $sth = $this->dbh->prepare("
            SELECT * FROM `orders`
            WHERE user_id = ?;
        ");
        $sth->execute([$id]);
        return $sth->fetchAll();
    }

    function insertOrder(
        int $course_id,
        string $date,
        int $user_id,
        int $payment_id,
    ): void{
        $sth = $this->dbh->prepare("
            INSERT INTO `orders` 
            (`id`, `course_id`, `date`, `status_id`, `user_id`, `payment_id`)
            VALUES (NULL, :course_id, :date, 1, :user_id, :payment_id)
        ");
        $sth->execute([
            "course_id"=>$course_id,
            "date"=>$date,
            "user_id"=> $user_id,
            "payment_id" => $payment_id,
        ]);
    }

    function changeStatus($order_id, $status_id): int{
        $sth = $this->dbh->prepare("
            UPDATE `orders` SET `status_id` = :status_id WHERE `orders`.`id` = :order_id
        ");
        
        $sth->execute([
            "status_id" => $status_id,
            "order_id" => $order_id,
        ]);

        return $order_id;
    }
}
