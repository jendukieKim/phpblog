<?php

    require '../config/config.php';

    $postid = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM post WHERE postid='$postid'");
    $result = $stmt->execute();
    header("Location:index.php");
    

?>