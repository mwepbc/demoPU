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
    <link rel="stylesheet" href="resources/css/style.css">
</head>

<body>
    <img src="resources/media/image01.webp" alt="logo" class="logo">
    <h1>Заявки</h1>
    <a href="createOrder.php">Создать заявку</a>
    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>Курс</th>
                    <th>Дата</th>
                    <th>Оплата</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($orders)) {
                    echo "
                <tr>
                    <td colspan='4'>У вас пока нет ни одной заявки</td>
                </tr>
            ";
                }


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
            </tbody>
        </table>
    </div>
    <form action="">
        <h2>
            Оставить отзыв о качестве образовательных услуг
        </h2>
        <div>
            <label for="feedback">Курс:</label>
            <select name="courses">
                <?php
                foreach ($orders as $o) {
                    if ($o['status_id'] == 6) {
                        echo "<option value='{$o['course_id']}'>{$courses->findCourse($o['course_id'])['name']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div>
            <label for="feedback">Текст:</label>
            <input type="text" name="feedback" required>
        </div>
        <button type="submit">Отправить</button>
    </form>
</body>

</html>