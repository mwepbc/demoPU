<?php

include_once('assets/functions/connect.php');
include_once('assets/functions/users.php');

if ($_POST) {
    $error = loginCheck($dbh, $_POST['login']);
    echo $error;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>

<body>
    <h1>Регистрация</h1>
    <form method="post">
        <div>
            <label for="login">Логин</label>
            <input type="text" name="login" required>
        </div>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>

</html>