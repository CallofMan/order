<?php
require_once "connection.php";
session_start();

if (empty($_SESSION["id_user"]))
{
    header("Location: login.php");
}

if (isset($_GET['messageSubmit']))
{
    $message = $_GET["messageText"];
    $message = htmlentities(mysqli_real_escape_string($link, $message));
    $idUser = $_SESSION['id_user'];
    mysqli_query($link, "INSERT INTO messages VALUES (NULL, '$idUser', '$message')");
    header("Location: chat.php");
}

if (isset($_GET['delete']))
{
    $idMessage = $_GET['messageId'];
    mysqli_query($link, "DELETE FROM messages WHERE id_message = '$idMessage'");
    header("Location: chat.php");
}
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
    <a href="logout.php" id="logout">Выйти</a>
    <?php if ($_SESSION['id_user'] == 1)
    {
        echo "<a href='adminpanel.php' id='adminpanel'>Панель администратора</a>";
    } ?>
    <div class="chat">
        <div class="messages">
            <?php
            $result = mysqli_query($link, "SELECT * FROM messages");
            while ($message = mysqli_fetch_row($result))
            {
                $messageId = $message[0];
                $messageIdUser = $message[1];
                $messageUserLogin = mysqli_query($link, "SELECT login FROM users WHERE id_user = '$messageIdUser'");
                $messageUserLogin = mysqli_fetch_row($messageUserLogin);
                $messageUserLogin = $messageUserLogin[0];
                $messageText = $message[2];
                echo "<form action='' class='message'>";
                    echo "<div class='loginAndButton'>";
                        echo "<p class='userLogin'>$messageUserLogin</p>";
                        if ($_SESSION['id_user'] == 1)
                        {
                            echo "<input type='text' name='messageId' value='$messageId' style='display: none;'>";
                            echo "<input type='submit' class='delete' name='delete' value='Удалить'>";
                        }
                    echo "</div>";

                    echo "<hr>";

                    if ($message[1] == $_SESSION['id_user'])
                    {
                        echo "<p class='userMessage thisUser'>$messageText</p>";
                    }
                    else
                    {
                        echo "<p class='userMessage otherUser'>$messageText</p>";
                    }
                echo "</form>";
            }
            ?>
        </div>
        <form action="" method="GET" class="inputAndSubmit">
            <textarea name="messageText" placeholder="Введите сообщение"></textarea>
            <input type="submit" name="messageSubmit" value="Отправить">
        </form>
    </div>
</body>
</html>