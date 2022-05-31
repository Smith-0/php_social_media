<?php

    include '../assets/database/db.php';

    $current_user_id = $_POST['current_user_id'];
    $user_id = $_POST['user_id'];

    // user wha has been follwed/unfollowed by current user
    $user_info = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM `users` WHERE `id`='$user_id'"));
    $user_followers = unserialize($user_info['followers']);

    // current user who is googing to follow or unfollow
    $current_user_info = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM `users` WHERE `id`='$current_user_id'"));
    $current_user_following = unserialize($current_user_info['following']);

    if(in_array($user_id, $current_user_following)) {
        echo 'unfollow';

        // remove user from following list of current user
        $current_user_index = array_search($user_id, $current_user_following);
        unset($current_user_following[$current_user_index]);

        // remove current user from followers list of user
        $user_index = array_search($current_user_id, $user_followers);
        unset($user_followers[$user_index]);


    } else {
        echo 'follow'; 

        // add in following list of current user
        array_push($current_user_following, $user_id);

        // add in followers list of user
        array_push($user_followers, $current_user_id);

    }

    $new_following = serialize($current_user_following);
    $new_followers = serialize($user_followers);

    // update db for current user
    $current_user_result = mysqli_query($conn , "UPDATE `users` SET `following` = '$new_following' where `users`.`id` = '$current_user_id'");

    // update db for user
    $user_result = mysqli_query($conn , "UPDATE `users` SET `followers` = '$new_followers' where `users`.`id` = '$user_id'");





?>