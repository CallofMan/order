<?php
SESSION_START();
require_once "connection.php";

if (isset($_POST['send']))
{
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = mysqli_query($link, "SELECT role, id_user, login, password FROM users WHERE login = $login AND password = $password");
    $queryResult = $query->fetch_assoc();
    
    if ($queryResult)
    {
        $_SESSION['role'] = $queryResult['role'];
        $_SESSION['id_user'] = $queryResult['id_user'];
        Header("Location: chat.php");
    }
    else $key = 1;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <title>Авторизация</title>
</head>
<body>
    <form id="registr" action="" method="POST">
        <?php
            if($key == 1)
            {
                echo "<p>Неправильный логин или пароль</p>";
            }
            else echo "<p>Авторизация</p>";
        ?>
       <input name="login" type="text" class="input" placeholder="Введите логин">
       <input name="password" type="password" class="input" placeholder="Введите пароль">
       <input name="send" type="submit" id="send" value="Войти">
    </form>
</body>
</html>