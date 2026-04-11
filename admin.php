<?php

namespace App;

use App\Database;
use App\Entity\Course;
use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\Status;
use App\Entity\User;

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/Entity/Order.php';
require_once __DIR__ . '/src/Entity/Course.php';
require_once __DIR__ . '/src/Entity/Payment.php';
require_once __DIR__ . '/src/Entity/Status.php';
require_once __DIR__ . '/src/Entity/User.php';

$db = new Database();

$orders = new Order($db);
$orders = $orders->fetchAllOrders($_COOKIE['user']);

$courses = new Course($db);
$payments = new Payment($db);
$statuses = new Status($db);
$users = new User($db);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
</head>

<body>
    <h1>Панель администратора</h1>
    <table>
        <tr>
            <th>Курс</th>
            <th>Пользователь</th>
            <th>Дата</th>
            <th>Оплата</th>
            <th>Статус</th>
        </tr>

        <td>
            
        </td>
        <?php
        array_walk($orders, function ($o) use ($courses, $payments, $statuses, $users) {
            echo "
                    <tr>
                        <td>{$courses->findCourse($o['course_id'])['name']}</td>
                        <td>{$users->findUser($o['user_id'])['FSM']}</td>
                        <td>{$o['date']}</td>
                        <td>{$payments->findPayment($o['payment_id'])['title']}</td>
                        <td>
                            <form method='post'>
                                <select name='status'>
            ";
            foreach ($statuses->fetchAllStatuses() as $s) {
                echo "
                    <option value='{$s['id']}' selected>{$s['name']}</option>
                ";
            };
            echo "
                            </select>
                        </form>
                    </td>
                </tr>
            ";
        });
        ?>
    </table>
</body>

</html>