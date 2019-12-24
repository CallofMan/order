<?php
require_once "connection.php";

$idMessage = $_GET['id_message'];
mysqli_query($link, "DELETE FROM messages WHERE id = '$idMessage'");

?>