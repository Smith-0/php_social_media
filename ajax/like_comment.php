<?php
    include '../assets/database/db.php';

    session_start();
    $current_user_id = $_SESSION['id'];

    $comment_id = $_POST['comment_id'];

    $sql = "SELECT * FROM comments WHERE id = $comment_id";
    $result = mysqli_query($conn,$sql);

    $comment_info = mysqli_fetch_array($result);

    $likes = unserialize($comment_info['likes']);

    if (in_array($current_user_id , $likes)) {
        if (($index = array_search($current_user_id, $likes)) !== false) {
            unset($likes[$index]);
        }
    } else {
        array_push($likes, $current_user_id);
    }

    $newLikes = serialize($likes);

    $update_sql = "UPDATE `comments` SET `likes` = '$newLikes' WHERE `comments`.`id` = '$comment_id'";
    
    $result = mysqli_query($conn , $update_sql);

    if ($result) {
        echo 'success';
    } else {
        echo 'failed';
    }









?>