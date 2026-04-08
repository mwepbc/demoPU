<?php

function createUser(
    $dbh,
    $login,
    $password,
    $FSM,
    $phone,
    $email
    ): ?string{

    if($error = loginCheck($dbh, $login))
        return $error;
    
    // $sql = '
    // ';
    // $sth = $dbh->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    // $sth->execute(['calories' => 150, 'colour' => 'red']);

    return null;
}

// функции валидации
function loginCheck($dbh, $login): ?string{
    if(strlen($login) < 6)
        return 'Логин должен содержать не менее 6 символов';

    if (preg_match('/(a-zA-Z\d)*/',$login))
        return 'Логин должен содержать только латиницу и цифры';

    $sth = $dbh->prepare('SELECT login FROM users WHERE ?');
    $sth->execute([$login]);
    $user = $sth->fetch();

    if($user)
        return 'Логин уже существует';

    return null;
}