<?php
session_start();
require_once "connection.php";

$key = 0;

if (isset($_GET["registration"]))
{
    $login = $_GET["login"];
    $password = $_GET["password"];
    $result = mysqli_query($link, "SELECT id_user FROM users WHERE login = '$login'");
    $idUser = mysqli_fetch_row($result);
    $idUser = $idUser[0];
    if (isset($idUser))
    {
        unset($_GET["registration"]);
        $key = 1;
    }
    else
    {
        $query = mysqli_query($link, "INSERT INTO users VALUES (NULL, '$login', '$password')");
        $result = mysqli_query($link, "SELECT id_user FROM users ORDER BY id_user DESC");
        $idUser = mysqli_fetch_row($result);
        $idUser = $idUser[0];
        $_SESSION["id_user"] = $idUser;
        unset($_GET["registration"]);
        header("Location: chat.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="registration.css">
    <title>Регистрация</title>
</head>
<body>
    <a class="enter" href="login.php">Войти</a>
    <form method="GET" action="" id="registration">
        <h1>РЕГИСТРАЦИЯ</h1>
        <?php
        if ($key == 1)
        {
            echo '<p>Такой пользователь уже зарегистрирован</p>';
        }
        ?>
        <input type="text" placeholder="Введите логин" name="login">
        <input type="password" placeholder="Введите пароль" name="password">
        <input type="submit" name="registration" value="Зарегистрироваться">
    </form>
</body>
</html>