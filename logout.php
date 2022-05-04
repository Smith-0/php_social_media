<?php
    session_start();
    session_destroy();

    
    if (isset($_COOKIE['email']) || isset($_COOKIE['password'])) {
        
        unset($_COOKIE['password']);
        setcookie('password', '', time() - 3600, './index.php'); // empty value and old timestamp
        
        unset($_COOKIE['email']);
        setcookie('email', '', time() - 3600, './index.php'); // empty value and old timestamp
    }

    header('location: ./login.php');

?>