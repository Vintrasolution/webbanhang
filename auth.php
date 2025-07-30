<?php
session_start();
        //Lưu đường dẫn trước đó vào session
        $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
        if(!isset($_SESSION["username"])){
                header("Location: /admin/login/");
                exit();
        }  
?>

