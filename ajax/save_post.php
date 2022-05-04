<?php

    include '../assets/database/db.php';

    $post_id = $_POST['post_id'];
    $current_user_id = $_POST['current_user_id'];
    $is_saved = $_POST['isSaved'];

    $current_user_info = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM users WHERE id=$current_user_id"));
    $saved_posts = unserialize($current_user_info['saved_posts']);

    if ($is_saved === 'false') {
        array_push( $saved_posts , $post_id );
    } else {
        $index = array_search($post_id, $saved_posts);
        unset($saved_posts[$index]);
    }

    $new_saved_posts = serialize($saved_posts);



    $sql = "UPDATE users SET saved_posts = '$new_saved_posts' WHERE `users`.id = $current_user_id";
    $result = mysqli_query($conn , $sql);

    if ($result) {
        echo 'success';
    } else {
        echo 'failed';
    }
    

?>