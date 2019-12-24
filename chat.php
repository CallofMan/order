<?php
require_once "connection.php";
session_start();

if (empty($_SESSION["id_user"]))
{
    header("Location: login.php");
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
    <span class="idLoginUser" style="display: none;"><?php echo $_SESSION['id_user']; ?></span>
    <a href="logout.php" id="logout">Выйти</a>
    <?php if ($_SESSION['id_user'] == 1)
    {
        echo "<a href='adminpanel.php' id='adminpanel'>Панель администратора</a>";
    } ?>
    <div class="chat">
        <div class="messages">
        </div>
        <form action="" method="GET" class="inputAndSubmit">
            <textarea name="messageText" class="messageText" placeholder="Введите сообщение"></textarea>
            <input type="submit" name="messageSubmit" value="Отправить">
        </form>
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

        let send = new XMLHttpRequest();

        send.onload = function() {
            let update = new XMLHttpRequest();

            update.onload = function() {
                messages.innerHTML = update.response;
            };

            update.open("GET", "updateMessages.php", true);

            update.send();
        };
        
        send.open("GET", "sendMessage.php?message="+messageText+"&id_user="+idUser, true);

        send.send();
    });

    setInterval(function() {
        let update = new XMLHttpRequest();

        update.onload = function() {
            messages.innerHTML = update.response;
        };

        update.open("GET", "updateMessages.php", true);

        update.send();
    }, 1000);
    </script>
</body>
</html>