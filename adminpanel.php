<?php
require_once "connection.php";
session_start();

$idUser = $_GET['id_user'];

if ($_SESSION['id_user'] != 1)
{
    header("Location: index.php");
}

if (isset($_GET['deleteUser']))
{
    $userId = $_GET['idUser'];
    mysqli_query($link, "DELETE FROM users WHERE id_user = '$userId'");
    header("Location: adminpanel.php");
}

if(isset($_GET['addUser']))
{
    Header("Location: registration.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="adminpanel.css">
    <title>Document</title>
</head>
<body>

    <div id='info'>
        <div class='listUser'>
            <?php
            $usersQuery = mysqli_query($link, "SELECT * FROM users");
            
            while ($user = mysqli_fetch_assoc($usersQuery))
            {
                echo "
                <form method='GET' action='' class='user'>
                    <input type='text' name='id_user' value='".$user['id_user']."' style='display: none;'>
                    <button class='listUserBlock'>".$user['first_name']." ".$user['second_name']." ".$user['position']."</button>
                </form>";
            }
            
            ?>
        </div>

        <form id="infoUser" action="" method="GET">
            <?php
            if(isset($idUser))
            {
            $userInfo = mysqli_query($link, "SELECT * FROM users WHERE id_user = '$idUser'");
            $user = mysqli_fetch_assoc($userInfo);

            $userId = $user['id_user'];
            $firstName = $user['first_name'];
            $secondName = $user['second_name'];
            $login = $user['login'];
            $password = $user['password'];
            $role = $user['role'];
            $position = $user['position'];
            $email = $user['email'];
            $telephone = $user['telephone'];
            $address = $user['address'];

            $role = mysqli_query($link, "SELECT name_role FROM roles WHERE role = '$role'");
            $role = mysqli_fetch_row($role);
            $role = $role[0];

            echo "
            <p>ID User -$userId</p>
            <p>Имя - $firstName</p>
            <p>Фамилия - $secondName</p>
            <p>Логин - $login</p>
            <p>Паоль - $password</p>
            <p>Роль - $role</p>
            <p>Должность - $position</p>
            <p>Email - $email</p>
            <p>Телефон - $telephone</p>
            <p>Адрес - $address</p>
            ";
            ?>
            <input type="text" name="idUser" value="<?php echo $userId; ?>" style='display: none;'>
            <input type="submit" id='deleteUser' name='deleteUser' value='Удалить пользователя'>
            <input type="submit" id='addUser' name='addUser' value='Добавить нового пользователя'>
      <?php 
            } ?>
        </form>
    </div>
    
    

    <div id="links">
        <a href="chat.php">Вернуться в чат</a>
        <a href="logout.php" id="exit">Выйти</a>
    </div>
    
</body>
</html>