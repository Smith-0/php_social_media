<?php
    include '../assets/database/db.php';

    session_start();
    $current_user_id = $_SESSION['id'];

    $comment_value = $_POST['comment_value'];
    $post_id = $_POST['post_id'];

    $sql = "INSERT INTO `comments` (`comment`, `post_id`, `user_id`) VALUES ('$comment_value' , $post_id , $current_user_id)";
    $result = mysqli_query($conn , $sql);

    if ($result) {
        echo 'success';
    } else {
        echo 'failed';
    }











?>