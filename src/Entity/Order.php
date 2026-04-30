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

    function fetchAllOrders(?string $sortColumn): ?array {
        if($sortColumn){
            $sth = match($sortColumn){
                "id"=>$this->dbh->prepare("SELECT * FROM `orders`"),
                "user" => $this->dbh->prepare("SELECT * FROM `orders` ORDER BY `user_id`"),
                "course" => $this->dbh->prepare("SELECT * FROM `orders` ORDER BY `course_id`"),
                "date" => $this->dbh->prepare("SELECT * FROM `orders` ORDER BY `date`"),
                "payment" => $this->dbh->prepare("SELECT * FROM `orders` ORDER BY `payment_id`"),
                "status" => $this->dbh->prepare("SELECT * FROM `orders` ORDER BY `status_id`"),
            };
            $sth->execute();
            // var_dump($sth->fetchAll());
            return $sth->fetchAll();
        }

        $sth = $this->dbh->prepare("SELECT * FROM `orders`");
        $sth->execute([]);
        return $sth->fetchAll();
    
    }

    function fetchUsersOrders(int $id): ?array
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
            "user_id"=> $user_id ?? 1,
            "payment_id" => $payment_id,
        ]);
    }

    function changeStatus(int $order_id, int $status_id): int{
        $sth = $this->dbh->prepare("
            UPDATE `orders` SET `status_id` = :status_id WHERE `orders`.`id` = :order_id
        ");

        $sth->execute([
            "status_id" => $status_id,
            "order_id" => $order_id,
        ]);

        return $order_id;
    }

    function getAllUsersDoneOrders(int $user_id): array{
        $sth = $this->dbh->prepare("
        SELECT * FROM `orders` 
        WHERE `user_id` = ?
        AND `status_id` = 6");

        $sth->execute([$user_id ?? 1]);

        return $sth->fetchAll();
    }
}
