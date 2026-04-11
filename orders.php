<?php

namespace App;

use App\Database;
use App\Entity\Course;
use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\Status;

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/Entity/Order.php';
require_once __DIR__ . '/src/Entity/Course.php';
require_once __DIR__ . '/src/Entity/Payment.php';
require_once __DIR__ . '/src/Entity/Status.php';

$db = new Database();

$orders = new Order($db);
$orders = $orders->fetchUsersOrders($_COOKIE['user']);

$courses = new Course($db);
$payments = new Payment($db);
$statuses = new Status($db);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявки</title>
</head>

<body>
    <h1>Заявки</h1>
    <table>
        <tr>
            <th>Курс</th>
            <th>Дата</th>
            <th>Оплата</th>
            <th>Статус</th>
        </tr>

        <?php
        array_walk($orders, function ($o) use ($courses, $payments, $statuses) {
            echo "
                    <tr>
                        <td>{$courses->findCourse($o['course_id'])['name']}</td>
                        <td>{$o['date']}</td>
                        <td>{$payments->findPayment($o['payment_id'])['title']}</td>
                        <td>{$statuses->findStatus($o['status_id'])['name']}</td>
                    </tr>
            ";
            // ;
        });
        ?>
    </table>
    <form action="">
        <div>
            <label for="feedback">Оставить отзыв о качестве образовательных услуг</label>
            <input type="text" name="feedback" required>
        </div>
        <button type="submit">Отправить</button>
    </form>
</body>

</html>