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
    $email = htmlentities(mysqli_real_escape_string($link, $_GET['email']));
    $telephone = htmlentities(mysqli_real_escape_string($link, $_GET['tel']));
    $address = htmlentities(mysqli_real_escape_string($link, $_GET['address']));

    mysqli_query($link, "UPDATE users SET first_name = '$firstName', second_name = '$secondName', login = '$login', 
    password = '$password', email = '$email', telephone = '$telephone', address = '$address' WHERE id_user = '$idUser'");
    header("Location: userInfo.php");
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
    <link rel="stylesheet" href="chat.css">
</head>
<body>
    <span class="idLoginUser" style="display: none;"><?php echo $_SESSION['id_user']; ?></span>
    
    <form action="" method="GET" class="infoEdit">
        <?php
        $user = mysqli_query($link, "SELECT * FROM users WHERE id_user = '$idUser'");
        $user = mysqli_fetch_assoc($user);
        echo "<input type='text' name='firstName' value='" . $user['first_name'] . "'>";
        echo "<input type='text' name='secondName' value='" . $user['second_name'] . "'>";
        echo "<input type='text' name='login' value='" . $user['login'] . "'>";
        echo "<input type='text' name='password' value='" . $user['password'] . "'>";
        echo "<input type='text' name='email' value='" . $user['email'] . "'>";
        echo "<input type='text' name='tel' value='" . $user['telephone'] . "'>";
        echo "<input type='text' name='address' value='" . $user['address'] . "'>";
        ?>
        <input type="submit" id="send" name="update" value="Обновить">
    </form>

    <div id='links'>
        <a href='chat.php'>Вернуться в чат</a>
        <a href="logout.php" id='exit'>Выйти</a>
    </div>
</body>
</html>