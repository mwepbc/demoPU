<?php

namespace App;

use App\Database;
use App\Entity\User;

require_once __DIR__ . '/src/Entity/User.php';
require_once __DIR__ . '/src/Database.php';

$user = new User(new Database());

if ($_POST) {
    $user_id = $user->auth(
        $_POST['login'],
        $_POST['password']
    );

    if (!$user_id)
        $error = 'Неверный логин или пароль';
    else {
        setcookie('user', $user_id);
        if ($user->getRole($user_id) == 2)
            header("Location: admin.php");
        else
            header("Location: orders.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корочки.Есть — Авторизация</title>
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="shortcut icon" href="resources/media/image01.webp" type="image/x-icon">
</head>

<body>
    <?php require_once __DIR__ . '/src/Include/header.php'; ?>
    <h1>Корочки.Есть — Авторизация</h1>
    <form method="post">
        <span class="error"><?php echo $error ?? ""; ?></span>
        <div>
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" required>
        </div>
        <div>
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Войти</button>
        <a href="register.php">Ещё не зарегистрированы? Регистрация</a>
    </form>
</body>

</html>