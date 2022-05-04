<?php

include '../assets/database/db.php';

$img_name = $_FILES['profile_pic_input']['name'];
$img_tmp_name = $_FILES['profile_pic_input']['tmp_name'];

session_start();
$user_id = $_SESSION['id'];

$sql = "UPDATE `users` SET `profile_pic` = './assets/images/profile_pics/$user_id/$img_name' WHERE `users`.`id` = $user_id";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if ($result) {

    // Make folder of user id if it doesn't exist
    if (!file_exists('../assets/images/profile_pics/'.$user_id)) {
        mkdir('../assets/images/profile_pics/' . $user_id, 0755, true);
    } else {
        $files = glob('../assets/images/profile_pics/'.$user_id.'/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }
    }

    move_uploaded_file($img_tmp_name, "../assets/images/profile_pics/$user_id/$img_name");
    
}