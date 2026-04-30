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
$user_id = $_COOKIE['user'];

$orders = new Order($db);
$ordersList = $orders->fetchUsersOrders($user_id);

$courses = new Course($db);
$payments = new Payment($db);
$statuses = new Status($db);

$doneOrders = $orders->getAllUsersDoneOrders($user_id) ?? null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корочки.Есть — Заявки</title>
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="shortcut icon" href="resources/media/image01.webp" type="image/x-icon">
</head>

<body>
    <img src="resources/media/image01.webp" alt="logo" class="logo">
    <h1>Заявки</h1>
    <a href="createOrder.php">Создать заявку</a>
    <a href="auth.php">Выход</a>
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
                if (empty($ordersList)) {
                    echo "
                        <tr>
                            <td colspan='4'>У вас пока нет ни одной заявки</td>
                        </tr>
                    ";
                }


                array_walk($ordersList, function ($o) use ($courses, $payments, $statuses) {
                    echo "
                        <tr>
                            <td>{$courses->findCourse($o['course_id'])['name']}</td>
                            <td>{$o['date']}</td>
                            <td>{$payments->findPayment($o['payment_id'])['title']}</td>
                            <td>{$statuses->findStatus($o['status_id'])['name']}</td>
                        </tr>
                    ";
                });
                ?>
            </tbody>
        </table>
    </div>
    <?php

    ?>
    <form action="">
        <h2>
            Оставить отзыв о качестве образовательных услуг
        </h2>
        <?php
        if ($doneOrders) {
            echo '
            <div>
                <label for="feedback">Курс:</label>
                <select name="courses">
            ';

            foreach ($ordersList as $o) {
                if ($o['status_id'] == 6) {
                    echo "<option value='{$o['course_id']}'>{$courses->findCourse($o['course_id'])['name']}</option>";
                }
            }

            echo '
                </select>
            </div>
            <div>
                <label for="feedback">Текст:</label>
                <input type="text" name="feedback" required>
            </div>
            <button type="submit">Отправить</button>
            ';
        } else {
            echo 'Похоже, у вас ещё нет законченных курсов обучения';
        }

        ?>
    </form>
</body>

</html>

<script>

</script>