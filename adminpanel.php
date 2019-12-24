<?php
require_once "connection.php";
session_start();
if ($_SESSION['id_user'] != 1)
{
    header("Location: index.php");
}

if (isset($_GET['deleteUser']))
{
    $userId = $_GET['idUser'];
    mysqli_query($link, "DELETE FROM users WHERE id_user = '$userId'");
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
                <div class='user'>
                    <p class='listUserBlock'>".$user['first_name']." ".$user['second_name']." ".$user['position']."</p>
                </div>";
            }
            
            ?>
        </div>

        <form id="infoUser" action="" method="GET">
            <p>ntcnпра</p>
            <p>dfgdfg</p>
            <p>sdgfgdsfg</p>
            <p>sdfgsdfgdsfg</p>
            <p>sdfgsdfg</p>
            <p>gfdghfth</p>
            <p>fghfghhfgdd</p>
            <input type="submit" id='deleteUser' name='deleteUser' value='Удалить пользователя'>
            <input type="submit" id='addUser' name='addUser' value='Добавить нового пользователя'>
        </form>
    </div>
    
    

    <div id="links">
        <a href="chat.php">Вернуться в чат</a>
        <a href="logout.php" id="exit">Выйти</a>
    </div>
    
</body>
</html>