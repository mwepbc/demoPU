<?php

namespace App;

use App\Database;
use App\Entity\User;

require_once __DIR__ . '/src/Entity/User.php';
require_once __DIR__ . '/src/Database.php';

$user = new User(new Database());

if ($_POST) {
    $user = $user->auth(
        $_POST['login'],
        $_POST['password']
    );

    if(!$user)
        $error = 'Неверный логин или пароль';
    else{
        setcookie('user', $user);
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
</head>

<body>
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
        <p style="color: red"><?php echo $error ?? ""; ?></p>
        <button type="submit">Войти</button>
        <div>
            <p>Ещё не зарегистрированы? </p>
            <a href="register.php">Регистрация</a>
        </div>
    </form>
</body>

</html>