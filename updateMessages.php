<?php
require_once "connection.php";

$idUser = htmlentities(mysqli_real_escape_string($link, $_GET['id_user']));

$result = mysqli_query($link, "SELECT * FROM messages");

while ($message = mysqli_fetch_row($result))
{
    $messageId = $message[0];
    $messageIdUser = $message[1];
    $messageUserLogin = mysqli_query($link, "SELECT login FROM users WHERE id_user = '$messageIdUser'");
    $messageUserLogin = mysqli_fetch_row($messageUserLogin);
    $messageUserLogin = $messageUserLogin[0];
    $messageText = $message[2];

    $userRole = mysqli_query($link, "SELECT role FROM users WHERE id_user = '$idUser'");
    $userRole = mysqli_fetch_row($userRole);
    $userRole = $userRole[0];

    echo "<form action='' class='message'>";
        echo "<div class='loginAndButton'>";
            echo "<p class='userLogin'>$messageUserLogin</p>";
            if ($userRole == 1)
            {
                echo "<input type='submit' class='delete' name='delete' value='Удалить' data-messageid='$messageId'>";
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