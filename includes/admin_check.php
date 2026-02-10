<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=connexion');
    exit();
}


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php?page=home&error=access_denied');
    exit();
}


?>
