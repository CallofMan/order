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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="chat.php">Вернуться в чат</a>
    <div class="users">
        <?php
        $usersQuery = mysqli_query($link, "SELECT * FROM users");
        
        while ($user = mysqli_fetch_row($usersQuery))
        {
            $userId = $user[0];
            $userLogin = $user[1];
            $userPassword = $user[2];
            echo "<form action='' method='GET' class='user'>";
                echo "<p class='userLogin'>$userLogin</p>";
                echo "<p class='userPassword'>$userPassword</p>";
                echo "<input type='text' value='$userId' name='idUser' style='display: none;'>";
                echo "<input type='submit' value='Удалить пользователя' name='deleteUser'>";
            echo "</form>";
        }
        
        ?>
    </div>
</body>
</html>