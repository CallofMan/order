<?php
session_start();
require_once "connection.php";

$key = 0;

if (isset($_GET["registration"]))
{
    $firstName = $_GET['first_name'];
    $secondName = $_GET['second_name'];
    $login = $_GET["login"];
    $password = $_GET["password"];
    $pastePassword = $_GET['pastepassword'];
    $position = $_GET['position'];
    $email = $_GET['email'];
    $telephone = $_GET['telephone'];
    $address = $_GET['address'];
    if(isset($_GET['role']) )
    {
        if($_GET['role'] == "admin")
        {
            $role = 1;
        }
        else if($_GET['role'] == "user")
        {
            $role = 0;
        }
    }

    $result = mysqli_query($link, "SELECT id_user FROM users WHERE login = '$login'");
    $idUser = mysqli_fetch_row($result);
    $idUser = $idUser[0];
    if (isset($idUser))
    {
        unset($_GET["registration"]);
        $key = 1;
    }
    else if ($password != $pastePassword)
    {
        $key = 2;
    }
    else
    {
        $query = mysqli_query($link, "INSERT INTO users VALUES (NULL, '$firstName', '$secondName', '$login', '$password', $role, '$position', '$email', '$telephone', '$address')");
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
    <a class="enter" href="adminpanel.php">Обратно в админы</a>
    <form method="GET" action="" id="registration">
        <h1>РЕГИСТРАЦИЯ</h1>
        <?php
        if ($key == 1)
        {
            echo '<p>Такой логин уже есть!</p>';
        }
        else if ($key == 2)
        {
            echo "<p>Пароли не совпадают!</P>";
        }
        ?>
        <div id="radio">
            <label for="admin">Admin<input class="radio" id="admin" type="radio" name="role" value="admin" required></label>
            <label for="user">User<input class="radio" id="user" type="radio" name="role" value="user" required></label>
        </div>
        <input type="text" name="first_name" placeholder="Введите имя *" autofocus required>
        <input type="text" name="second_name" placeholder="Введите фамилию *" required>
        <input type="text" name="login" placeholder="Введите логин *" required>
        <input type="password" name="password" placeholder="Придумайте пароль *" required>
        <input type="password" name="pastepassword" placeholder="Повторите пароль *" required>
        <input type="text" name="position" placeholder="Введите должность *" required>
        <input type="email" name="email" placeholder="Введите почту">
        <input type="tel" name="telephone" placeholder="Введите телефон">
        <input type="text" name="address" placeholder="Введите адрес">
        <input id="send" type="submit" name="registration" value="Зарегистрировать">
    </form>
</body>
</html>