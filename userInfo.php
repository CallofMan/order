<?php
require_once "connection.php";
session_start();

if (empty($_SESSION["id_user"]))
{
    header("Location: login.php");
}

$idUser = $_SESSION["id_user"];

if (isset($_GET['update']))
{
    $firstName = htmlentities(mysqli_real_escape_string($link, $_GET['firstName']));
    $secondName = htmlentities(mysqli_real_escape_string($link, $_GET['secondName']));
    $login = htmlentities(mysqli_real_escape_string($link, $_GET['login']));

    $password = htmlentities(mysqli_real_escape_string($link, $_GET['password']));
    $pastePassword = htmlentities(mysqli_real_escape_string($link, $_GET['pastepassword']));
    $email = htmlentities(mysqli_real_escape_string($link, $_GET['email']));
    $telephone = htmlentities(mysqli_real_escape_string($link, $_GET['tel']));
    $address = htmlentities(mysqli_real_escape_string($link, $_GET['address']));

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
        mysqli_query($link, "UPDATE users SET first_name = '$firstName', second_name = '$secondName', login = '$login', 
        password = '$password', email = '$email', telephone = '$telephone', address = '$address' WHERE id_user = '$idUser'");
        header("Location: userInfo.php");
    }

}

$userRole = mysqli_query($link, "SELECT role FROM users WHERE id_user = '$idUser'");
$userRole = mysqli_fetch_row($userRole);
$userRole = $userRole[0];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Чат</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <span class="idLoginUser" style="display: none;"><?php echo $_SESSION['id_user']; ?></span>
    
    <form action="" method="GET" class="infoEdit">
        <?php
        if ($key == 1)
        {
            echo '<p>Такой логин уже есть!</p>';
        }
        else if ($key == 2)
        {
            echo "<p>Пароли не совпадают!</P>";
        }
        $user = mysqli_query($link, "SELECT * FROM users WHERE id_user = '$idUser'");
        $user = mysqli_fetch_assoc($user);
        echo "<p>Имя</p>";
        echo "<input type='text' placeholder='Введите имя' name='firstName' value='" . $user['first_name'] . "'>";
        echo "<p>Фамилия</p>";
        echo "<input type='text' placeholder='Введите фамилию' name='secondName' value='" . $user['second_name'] . "'>";
        echo "<p>Логин</p>";
        echo "<input type='text' placeholder='Введите логин' name='login' value='" . $user['login'] . "'>";
        echo "<p>Пароль</p>";
        echo "<input type='password' placeholder='Введите пароль' name='password' value='" . $user['password'] . "'>";
        echo "<p>Повторите пароль</p>";
        echo "<input type='password' placeholder='Повторите пароль' name='pastepassword' value='" . $user['password'] . "'>";
        echo "<p>Почта</p>";
        echo "<input type='text' placeholder='Введите почту' name='email' value='" . $user['email'] . "'>";
        echo "<p>Телефон</p>";
        echo "<input type='text' placeholder='Введите телефон' name='tel' value='" . $user['telephone'] . "'>";
        echo "<p>Адрес</p>";
        echo "<input type='text' placeholder='Введите адрес' name='address' value='" . $user['address'] . "'>";
        ?>
        <input type="submit" id="send" name="update" value="Обновить">
    </form>

    <div id='links'>
        <a href='chat.php'>Вернуться в чат</a>
        <a href="logout.php" id='exit'>Выйти</a>
    </div>
</body>
</html>