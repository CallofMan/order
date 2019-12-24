<?php
require_once "connection.php";
session_start();

if (empty($_SESSION["id_user"]))
{
    header("Location: login.php");
}

$idUser = $_SESSION["id_user"];
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
    <div class="chat">
        <div class="messages">
        </div>
        <form action="" method="GET" class="inputAndSubmit">
            <textarea name="messageText" class="messageText" placeholder="Введите сообщение"></textarea>
            <input type="submit" id="send" name="messageSubmit" value="Отправить">
        </form>
    </div>

    <div id='links'>
        <?php if ($_SESSION['id_user'] == 1)
        {
            echo "<a href='adminpanel.php'>Панель администратора</a>";
        } ?>
        <a href="logout.php" id='exit'>Выйти</a>
    </div>

    <script>
    var messages = document.querySelector('.messages');
    var submit = document.querySelector('input[name=messageSubmit]');
    var idUser = document.querySelector('.idLoginUser').textContent;

    submit.addEventListener('click', function(event)
    {
        event.preventDefault();
        
        var messageText = document.querySelector('.messageText').value;
        document.querySelector('.messageText').value = '';

        var send = new XMLHttpRequest();

        send.onload = function() {
            var update = new XMLHttpRequest();

            update.onload = function() {
                messages.innerHTML = update.response;
            };

            update.open("GET", "updateMessages.php?id_user="+idUser, true);

            update.send();
        };
        
        send.open("GET", "sendMessage.php?message="+messageText+"&id_user="+idUser, true);

        send.send();
    });

    setInterval(function() {
        var update = new XMLHttpRequest();

        update.onload = function() {
            messages.innerHTML = update.response;
            var allMessages = messages.querySelectorAll('form');
            allMessages.forEach((message) =>
            {
                message.querySelector('.delete').addEventListener('click', function(event)
                {
                    event.preventDefault();

                    var idMessage = event.target.dataset.messageid;
                    var deleteMsg = new XMLHttpRequest();

                    deleteMsg.open("GET", "deleteMessage.php?id_message="+idMessage, true);
                    deleteMsg.send();
                });
            });
        };

        update.open("GET", "updateMessages.php?id_user="+idUser, true);

        update.send();
    }, 1000);
    </script>
</body>
</html>