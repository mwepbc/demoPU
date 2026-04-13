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
    <title>Авторизация</title>
    <link rel="stylesheet" href="resources/css/style.css">
</head>

<body>
    <img src="resources/media/image01.webp" alt="logo" class="logo">
    <h1>Авторизация</h1>
    <form method="post">
        <div>
            <label for="login">Логин</label>
            <input type="text" name="login" required>
        </div>
        <div>
            <label for="password">Пароль</label>
            <input type="password" name="password" required>
        </div>
        <p class="error"><?php echo $error ?? ""; ?></p>
        <button type="submit">Войти</button>
        <a href="register.php">Ещё не зарегистрированы? Регистрация</a>
    </form>
</body>

</html>