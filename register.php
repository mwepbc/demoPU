<?php

namespace App;

use App\Database;
use App\Entity\User;

require_once __DIR__ . '/src/Entity/User.php';
require_once __DIR__ . '/src/Database.php';

$user = new User(new Database());

$error = "";

if ($_POST) {
    $error = $user->createUser(
        $_POST['login'],
        $_POST['password'],
        $_POST['SFM'],
        $_POST['phone'],
        $_POST['email'],
    );

    if (!$error)
        header("Location: auth.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="resources/css/style.css">
</head>

<body>
    <img src="resources/media/image01.webp" alt="logo" class="logo">
    <h1>Регистрация</h1>
    <form method="post">
        <div>
            <label for="login">Логин</label>
            <input type="text" name="login" required>
        </div>
        <div>
            <label for="password">Пароль</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="SFM">ФИО</label>
            <input type="text" name="SFM" required>
        </div>
        <div>
            <label for="phone">Телефон</label>
            <input type="text" name="phone" required>
        </div>
        <div>
            <label for="email">Адрес электронной почты</label>
            <input type="text" name="email" required>
        </div>
        <p class="error"><?php echo $error; ?></p>
        <button type="submit">Создать пользователя</button>
        <a href="auth.php">Уже зарегистрированы? Вход</a>
    </form>
</body>

</html>