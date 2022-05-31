


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- tab icon -->
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />

    <!-- profile Css -->
    <link rel="stylesheet" href="assets/css/profile/profile.css" />

    <!-- Navbar Css -->
    <link rel="stylesheet" href="assets/css/index/index.css">

    <!-- Swaet Alert JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="./assets/js/moment.js"></script>

    <title>Memories</title>
</head>

<body>

    

    <?php
    


        include "./partials/navbar.php";

        // getting user info current singed in user or other

        if(isset($_GET['user_id'])) {
            if ($_GET['user_id'] == $current_user_info['id']) {
                $user_id = $_GET['user_id'];
                include "./partials/edit_profile.php";
                $user_info = $current_user_info;
                $current_user = true;
                $user_profile_pic = $current_user_profile_pic;
            } else {
                $user_id = $_GET['user_id'];
                $result = mysqli_query($conn , "SELECT * FROM users WHERE id = '$user_id'");
                $user_info = mysqli_fetch_array($result);
                if ($user_info) {
                    $current_user = false;
                    $user_profile_pic = $user_info['profile_pic'];
                } else {
                    echo '<br><br><br><br><h1 class="text-center">no user exist with this id</h1>';
                    die();
                }
                
            }
        } else {
            include "./partials/edit_profile.php";
                $user_id = $current_user_id;
                $user_info = $current_user_info;
                $current_user = true;
                $user_profile_pic = $current_user_profile_pic;
        }

        $followers = unserialize($user_info['followers']);
        $following = unserialize($user_info['following']);

        $no_of_followers = count($followers);
        $no_of_following = count($following);

    ?>

    


    <!-- followers modal -->
    <div class="modal fade" id="show_followers" tabindex="-1" aria-labelledby="show_followers_label" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="show_followers_label">Followers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-4">
                    <div class="row">
                        <?php
                            foreach ($followers as $person_user_id) {

                                $person_info = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM users WHERE id = '$person_user_id'"));

                                echo '    
                                    <div class="col-12 pt-3">
                                        <img class="show_people_image" src="'.$person_info['profile_pic'].'" alt="">
                                        <a href="./profile.php?user_id='.$person_user_id.'"><h6 class="px-2 pt-2 d-inline">'.$person_info['display_name'].'</h6>   </a>
                                    </div>
                                    ';
                                  }

                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- following modal -->
    <div class="modal fade" id="show_following" tabindex="-1" aria-labelledby="show_following_label" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="show_following_label">Following</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-4">
                    <div class="row">
                        <?php
                            foreach ($following as $person_user_id) {

                                $person_info = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM users WHERE id = '$person_user_id'"));

                                echo '    
                                    <div class="col-12 pt-3">
                                        <img class="show_people_image" src="'.$person_info['profile_pic'].'" alt="">
                                        <a href="./profile.php?user_id='.$person_user_id.'"><h6 class="px-2 pt-2 d-inline">'.$person_info['display_name'].'</h6>   </a>
                                    </div>
                                    ';
                                  }

                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row py-5">
        <div class="col-md-8 mx-auto">
            <!-- Profile widget -->
            <div class="bg-white shadow rounded">
                <div class="px-md-4 px-2 pt-0 pb-4 cover">
                    <div class="media align-items-end profile-head">
                        <div class="profile mr-3">
                            <div class="profile_image_section">
                                <img id="profile_pic" src="<?php echo $user_profile_pic; ?>" alt="..." width="130" class="rounded mb-2 img-thumbnail">
                                <?php

                                    // change profile pic

                                    if ($current_user) {
                                        echo '<label class="label_profile_pic_input" for="profile_pic_input">
                                                    <i class="bi bi-camera"></i> &nbsp; Change Photo
                                                </label>
                                                <form id="profile_pic_edit" onsubmit="return false;">
                                                    <input type="file" class="d-none" name="profile_pic_input" id="profile_pic_input" onchange="uploadImage(event)">
                                                </form>';
                                    }
                                    
                                ?> 
                                
                            </div>
                            
                            <div>
                                <?php

                                    // follow or edit profile btn

                                    if ($current_user) {
                                        echo '<a class="btn btn-outline-dark btn-sm d-block" data-bs-toggle="offcanvas" data-bs-target="#edit_profile_offcanvas" aria-controls="edit_profile_offcanvas">Edit profile</a>';
                                    } else {
                                        if (in_array($current_user_id , $followers)) {
                                            echo '<div 
                                                class="btn btn-outline-secondary btn-sm d-block"
                                                id="follow_toggle_btn_'.$user_id.'"
                                                onclick="followToggle('.$current_user_id.' , '.$user_id.')"    >Following
                                                </div>';
                                        } else {
                                            echo '<div 
                                                class="btn btn-primary btn-sm d-block"
                                                id="follow_toggle_btn_'.$user_id.'"
                                                onclick="followToggle('.$current_user_id.' , '.$user_id.')"    >Follow
                                                </div>';
                                        }
                                        
                                        
                                    }

                                ?> 
                                
                            </div>
                        </div>
                        <div class="media-body pb-5 ps-3 mb-2 text-white">
                            <h4 class="mt-0 mb-0"><?php echo $user_info['display_name']; ?></h4>
                            <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i><?php echo '@'.$user_info['username']; ?></p>
                        </div>
                        <div class="d-flex user_argu_counts">
                            <div class="px-2">
                                <h5 class="font-weight-bold mb-0 d-block text-center">
                                    <?php
                                        echo $no_of_posts = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts WHERE user_id = $user_id"));
                                    ?>
                                </h5>
                                <small class="text-muted"> <i class="fas fa-image mr-1"></i>
                                    <?php
                                        if ($no_of_posts > 1) {
                                            echo "Posts";
                                        } else {
                                            echo "Post";
                                        }
                                        
                                    ?>
                                </small>
                            </div>
                            <?php
                            echo'
                                <div class="px-2"' ; if($no_of_followers!=0) {echo ' data-bs-toggle="modal" data-bs-target="#show_followers" style="cursor: pointer"'; } echo' >
                                    <h5 class="font-weight-bold mb-0 d-block text-center" id="no_of_followers_'.$user_id.'" > '.$no_of_followers.' </h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Followers</small>
                                </div>
                                <div class="px-2"'; if($no_of_following!=0) {echo ' data-bs-toggle="modal" data-bs-target="#show_following" style="cursor: pointer"'; } echo' >
                                    <h5 class="font-weight-bold mb-0 d-block text-center">'.$no_of_following.'</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Following</small>
                                </div>';
                            ?>
                        </div>
                    </div>
                </div>
                

                <?php
                    if ($user_info['website'] !== '' || $user_info['bio'] !== '') {
                        echo '<br><br><br><div class="px-md-4 px-2 py-3">
                                    <div class="bg-light px-4 pt-4 pb-1 rounded shadow-sm">
                                    <p class="font-italic mb-0"><pre>'.$user_info['bio'].'</pre></p>
                                    <u><a href="https://'.$user_info['website'].'" class="font-italic mb-0 text-primary">'.$user_info['website'].'</a></u>
                                    </div>
                                </div>';
                    }
                    
                ?>

                    
                
                
                        <?php
                            include './partials/post.php';
                        ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    


  <!-- Main js  -->
    <script src="./assets/js/index.js"></script>

    <script>
        var uploadImage = function(event) {
            let img = document.getElementById("profile_pic");
            let profile_img_navbar = document.getElementById('profile_pic_navbar');
            profile_img_navbar.src = URL.createObjectURL(event.target.files[0]);
            img.src = URL.createObjectURL(event.target.files[0]);


            fetch('./ajax/edit_profile_pic.php', {
                method: 'POST',
                body: new FormData(document.getElementById('profile_pic_edit'))

            }).then(function(response) {
                if (response.status >= 200 && response.status < 300) {
                    return response.text();
                }
                throw new Error(response.statusText)
            }).then(function(response) {
                // if need response text
                // console.log(response);
            })

        }
    </script>

</body>

</html>