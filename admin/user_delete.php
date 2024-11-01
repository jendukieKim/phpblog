<?php

    require '../config/config.php';

    $userid = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE userid='$userid'");
    $result = $stmt->execute();
    header("Location:user_list.php");
    

?>