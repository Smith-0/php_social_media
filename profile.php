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

    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Swaet Alert JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <title>Memories</title>
</head>

<body>

    <?php
    include "./partials/navbar.php";

    include "./partials/edit_profile.php";
    ?>

    <div class="row py-5">
        <div class="col-md-8 mx-auto">
            <!-- Profile widget -->
            <div class="bg-white shadow rounded overflow-hidden">
                <div class="px-4 pt-0 pb-4 cover">
                    <div class="media align-items-end profile-head">
                        <div class="profile mr-3">
                            <div class="profile_image_section">
                                <img id="profile_pic" src="<?php echo $current_user_profile_pic; ?>" alt="..." width="130" class="rounded mb-2 img-thumbnail">
                                <label class="label_profile_pic_input" for="profile_pic_input">
                                    <i class="bi bi-camera"></i> &nbsp; Change Photo
                                </label>
                                <form id="profile_pic_edit" onsubmit="return false;">
                                    <input type="file" class="d-none" name="profile_pic_input" id="profile_pic_input" onchange="uploadImage(event)">
                                </form>
                            </div>
                            <div>
                                <a class="btn btn-outline-dark btn-sm d-block" data-bs-toggle="offcanvas" data-bs-target="#edit_profile_offcanvas" aria-controls="edit_profile_offcanvas">Edit profile</a>
                            </div>
                        </div>
                        <div class="media-body pb-5 ps-3 mb-2 text-white">
                            <h4 class="mt-0 mb-0"><?php echo $current_user_info['display_name']; ?></h4>
                            <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i><?php echo $current_user_info['username']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-light p-4 d-flex justify-content-end text-center">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">
                                <?php
                                    echo $no_of_posts = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts WHERE user_id = $current_user_id"));
                                ?>
                            </h5><small class="text-muted"> <i class="fas fa-image mr-1"></i>
                                <?php
                                    if ($no_of_posts > 1) {
                                        echo "Posts";
                                    } else {
                                        echo "Post";
                                    }
                                    
                                ?>
                            </small>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">745</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Followers</small>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">340</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Following</small>
                        </li>
                    </ul>
                </div>

                <?php
                    if ($current_user_info['website'] !== '' || $current_user_info['bio'] !== '') {
                        echo '<div class="px-4 py-3">
                                    <div class="bg-light px-4 pt-4 pb-1 rounded shadow-sm">
                                    <p class="font-italic mb-0"><pre>'.$current_user_info['bio'].'</pre></p>
                                    <u><a href="'.$current_user_info['website'].'" class="font-italic mb-0 text-primary">'.$current_user_info['website'].'</a></u>
                                    </div>
                                </div>';
                    }

                    // if ($current_user_info['website'] !== '' &&  $current_user_info['bio'] == '') {
                    //     echo '<div class="px-4 py-3">
                    //                 <div class="bg-light px-4 pt-4 pb-1 rounded shadow-sm">
                    //                 <p class="font-italic mb-0"><pre>'.$current_user_info['bio'].'</pre></p>
                    //                 <u><a href="'.$current_user_info['website'].'" class="font-italic mb-0 text-primary">'.$current_user_info['website'].'</a></u>
                    //                 </div>
                    //             </div>';
                    // }

                    // if ($current_user_info['website'] == '' &&  $current_user_info['bio'] !== '') {
                    //     echo '<div class="px-4 py-3">
                    //                 <div class="bg-light px-4 pt-4 pb-1 rounded shadow-sm">
                    //                 <p class="font-italic mb-0"><pre>'.$current_user_info['bio'].'</pre></p>
                    //                 </div>
                    //             </div>';
                    // }
                    
                ?>
                
                
                <div class="py-4 px-4">
                    <div class="row">
                        <div class="col-lg-6 p-2"><img src="https://images.unsplash.com/photo-1469594292607-7bd90f8d3ba4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80" alt="" class="img-fluid rounded shadow-sm"></div>
                        <div class="col-lg-6 p-2"><img src="https://images.unsplash.com/photo-1493571716545-b559a19edd14?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80" alt="" class="img-fluid rounded shadow-sm"></div>
                        <div class="col-lg-6 p-2"><img src="https://images.unsplash.com/photo-1453791052107-5c843da62d97?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80" alt="" class="img-fluid rounded shadow-sm"></div>
                        <div class="col-lg-6 p-2"><img src="https://images.unsplash.com/photo-1475724017904-b712052c192a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=750&q=80" alt="" class="img-fluid rounded shadow-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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