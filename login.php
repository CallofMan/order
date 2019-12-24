<?php
session_start();
require_once "connection.php";

$key = 0;

if (isset($_GET["enter"]))
{
    $login = $_GET["login"];
    $password = $_GET["password"];
    $result = mysqli_query($link, "SELECT id_user FROM users WHERE login = '$login' AND password = '$password'");
    $idUser = mysqli_fetch_row($result);
    $idUser = $idUser[0];
    if (isset($idUser))
    {
        $_SESSION["id_user"] = $idUser;
        unset($_GET["enter"]);
        header("Location: chat.php");
    }
    else
    {
        unset($_GET["enter"]);
        $key = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login.css">
    <title>Авторизация</title>
</head>
<body>
    <div>
        <h1>АВТОРИЗАЦИЯ</h1>
        <form method="GET" action="" id="login">
            <?php
            if ($key == 1)
            {
                echo '<p>Логин или пароль введены неправильно</p>';
            }
            ?>
            <input type="text" placeholder="Введите логин" name="login">
            <input type="password" placeholder="Введите пароль" name="password">
            <input id="send" type="submit" name="enter" value="Войти">
        </form>
    </div>
</body>
</html>