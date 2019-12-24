<?php
require_once "connection.php";
$message = htmlentities(mysqli_real_escape_string($link, $_GET['message']));
$idUser = htmlentities(mysqli_real_escape_string($link, $_GET['id_user']));
$date = date("Y-m-d H:i:s");

mysqli_query($link, "INSERT INTO messages VALUES (NULL, '$idUser', '$message', '$date')");

?>