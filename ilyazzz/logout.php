<?php
session_start();

unset($_SESSION['id_user']);
unset($_SESSION['role']);
session_destroy();

header('Location: index.php');
exit();
