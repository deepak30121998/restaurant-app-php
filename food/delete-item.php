<?php require "../config/config.php" ?>
<?php require "../libs/App.php" ?>
<?php
    if(!isset($_SERVER['HTTP_REFERER'])) {
        echo "<script>window.location.href='".APPURL."'</script>";
        exit;
    }
?>
<?php

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM cart WHERE id = '$id'";
        $app = new App;
        $path = "cart.php";
        $app->delete($query, $path);
    }