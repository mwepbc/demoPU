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

$sort = $_GET['sort'] ?? null;

$orders = new Order($db);
$ordersList = $orders->fetchAllOrders($sort);

$users = new User($db);

$user = $_COOKIE['user'];
if (!$user)
    header("Location: auth.php");
if ($users->getRole($user) != 2)
    header("Location: orders.php");

$courses = new Course($db);
$payments = new Payment($db);
$statuses = new Status($db);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="shortcut icon" href="resources/media/image01.webp" type="image/x-icon">
</head>

<body>
    <img src="resources/media/image01.webp" alt="logo" class="logo">
    <h1>Панель администратора</h1>
    <a href="auth.php">Выход</a>
    <div class="message">
    </div>
    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>ID
                        <a href="admin.php?sort=id">↓</a>
                    </th>
                    <th>Курс
                        <a href="admin.php?sort=course">↓</a>
                    </th>
                    <th>Пользователь
                        <a href="admin.php?sort=user">↓</a>
                    </th>
                    <th>Дата
                        <a href="admin.php?sort=date">↓</a>
                    </th>
                    <th>Оплата
                        <a href="admin.php?sort=payment">↓</a>
                    </th>
                    <th>Статус
                        <a href="admin.php?sort=status">↓</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($ordersList as $o) {
                    echo "
                    <tr>
                        <td>{$o['id']}</td>
                        <td>{$courses->findCourse($o['course_id'])['name']}</td>
                        <td>{$users->findUser($o['user_id'])['FSM']}</td>
                        <td>{$o['date']}</td>
                        <td>{$payments->findPayment($o['payment_id'])['title']}</td>
                        <td>
                            <form method='post' class='selectForm'>
                                <select name='status' class='status' order='{$o['id']}'>
                    ";

                    if ($o['status_id'] == 1) {
                        echo "
                            <option value='{$o['status_id']}' selected hidden disabled>Новая</option>
                        ";
                    }

                    foreach ($statuses->fetchStatuses() as $s) {
                        if ($s['id'] == $o['status_id']) {
                            echo "
                                <option value='{$s['id']}' selected>{$s['name']}</option>
                            ";
                        } else {
                            echo "
                                <option value='{$s['id']}'>{$s['name']}</option>
                            ";
                        }
                    };

                    echo "
                                    </select>
                                </form>
                            </td>
                        </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="resources/js/admin.js"></script>
</body>

</html>