<?php

    include '../assets/database/db.php';

    $user_id = $_POST['current_user_id'];
    $post_id = $_POST['post_id'];
    $type = $_POST['type'];

    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn,$sql);

    $post_info = mysqli_fetch_array($result);

    $likes = unserialize($post_info['likes']);

    if ($type === 'like') {
        array_push($likes, $user_id);
    } else if ($type === 'dislike') {
        if (($index = array_search($user_id, $likes)) !== false) {
            unset($likes[$index]);
        }
    }

    $newLikes = serialize($likes);

    $update_sql = "UPDATE `posts` SET `likes` = '$newLikes' WHERE `posts`.`id` = '$post_id'";
    
    $result = mysqli_query($conn , $update_sql);

    if ($result) {
        echo 'success';
    } else {
        echo 'failed';
    }
?>