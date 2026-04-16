<?php

namespace App;

use App\Database;
use App\Entity\Order;
use App\Entity\Course;
use App\Entity\Payment;

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/Entity/Order.php';
require_once __DIR__ . '/src/Entity/Course.php';
require_once __DIR__ . '/src/Entity/Payment.php';

$db = new Database();

$courses = new Course($db);
$courses = $courses->fetchAllCourses();

$payments = new Payment($db);
$payments = $payments->fetchAllPayments();

$orders = new Order($db);

if ($_POST) {
    $orders->insertOrder(
        $_POST['course'],
        $_POST['date'],
        $_COOKIE['user'],
        $_POST['payment'],
    );
    header('Location: orders.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Формирование заявки</title>
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="shortcut icon" href="resources/media/image01.webp" type="image/x-icon">
</head>

<body>
    <img src="resources/media/image01.webp" alt="logo" class="logo">
    <h1>Создать заявку</h1>
    <form method="POST">
        <div>
            <label for="course">Наименование курса:</label>
            <select name="course">
                <?php
                foreach ($courses as $c) {
                    echo "
                        <option value='{$c['id']}'>{$c['name']}</option>
                    ";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="date">Дата начала обучения:</label>
            <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        <div>
            <label for="payment">Способ оплаты:</label>
            <select name="payment">
                <?php
                foreach ($payments as $payment) {
                    echo "
                        <option value='{$payment['id']}'>{$payment['title']}</option>
                    ";
                }
                ?>
            </select>
        </div>
        <button type="submit">Отправить</button>
    </form>
</body>

</html>