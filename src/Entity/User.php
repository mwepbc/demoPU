<?php

namespace App\Entity;

use App\Database;
use PDO;

class User
{
    private PDO $dbh;

    public function __construct(
        private Database $db
    ) {
        $this->dbh = $db->getDbh();
    }

    function createUser(
        $login,
        $password,
        $FSM,
        $phone,
        $email
    ): ?string {

        $loginError = $this->loginCheck($login);
        if($loginError)
            return $loginError;

        if (strlen($password) < 8)
            return "Пароль должен содержать не менее 8 символов";

        if(!preg_match('/^[а-яА-ЯёЁ]+ [а-яА-ЯёЁ]+ [а-яА-ЯёЁ]+$/u', $FSM))
            return "ФИО должно содержать только кириллицу и пробелы";

        if(!preg_match('/8\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}$/u', $phone))
            return "Телефон должен соответсвовать формату 8(ХХХ)ХХХ-ХХ-ХХ";

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return "Адрес электронной почты не соответствует формату электронной почты";

        $this->insertUser(
            $login,
            $password,
            $FSM,
            $phone,
            $email
        );

        return null;
    }

    // функция валидации логина
    function loginCheck($login): ?string
    {
        if (strlen($login) < 6)
            return  'Логин должен содержать не менее 6 символов';

        if (!preg_match('/^[a-z0-9]*$/i', $login))
            return  'Логин должен содержать только латиницу и цифры';

        if (!$this->userExists($login))
            return  'Такой логин уже занят';

        return null;
    }

    public function insertUser(
        $login,
        $password,
        $FSM,
        $phone,
        $email
    ): void
    {
        $sql = "
            INSERT INTO `users`
            (`id`, `login`, `password`, `FSM`, `phone`, `email`, `role_id`)
            VALUES
            (NULL, :login, :password, :FSM, :phone, :email, 1)
        ";
        $sth = $this->dbh->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([
            'login' => $login,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'FSM' => $FSM,
            'phone' => $phone,
            'email' => $email
        ]);
    }

    private function userExists(string $value): bool{
        $sth = $this->dbh->prepare("SELECT `login` FROM `users` WHERE `login` = ?");
        $sth->execute([$value]);
        $user = $sth->fetch();

        return $user ? false : true;
    }

    public function auth(string $login, string $password): ?int{
        $sth = $this->dbh->prepare("SELECT * FROM `users` WHERE login = ?");
        $sth->execute([$login]);
        $user = $sth->fetch();

        if(!$user)
            return null;

        if(!password_verify($password, $user['password']))
            return null;
        
        return $user['id'];
    }

    public function getRole(int $id): int{
        $sth = $this->dbh->prepare("SELECT role_id FROM `users` WHERE id = ?");
        $sth->execute([$id]);
        return $sth->fetch()['role_id'];
    }

    public function findUser(int $id): ?array{
        $sth = $this->dbh->prepare("SELECT * FROM `users` WHERE id = ?");
        $sth->execute([$id]);
        return $sth->fetch();
    }
}
