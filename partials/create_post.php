<?php

if (isset($_POST['share_post'])) {
    $caption = $_POST['caption'];
    $location = $_POST['location'];

    // image details
    $name = $_FILES['post_image']['name'];
    $tmp_name = $_FILES['post_image']['tmp_name'];
    $size = $_FILES['post_image']['size'];
    $type = $_FILES['post_image']['type'];
    $error = $_FILES['post_image']['error'];

    if ($error === 0) {

        // unique name of image 
        $unique_image_name = time()."_".$name;

        $current_user_id = $_SESSION['id'];
        
        $sql = "INSERT INTO `posts` ( `user_id`, `caption`, `location` , `image` ) VALUES ('$current_user_id', '$caption', '$location', './assets/images/post/$current_user_id/$unique_image_name')";

            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            if ($result) {

                // Make folder of user id if it doesn't exist
                if (!file_exists('./assets/images/post/'.$current_user_id)) {
                    mkdir('./assets/images/post/'.$current_user_id, 0755, true);
                }

                move_uploaded_file($tmp_name, "./assets/images/post/$current_user_id/$unique_image_name");
                echo '
                <script type="text/javascript">
                swal("Added", "Post shared successfully.", "success");
                if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                }
                </script>';

            } else {
                echo '
                <script type="text/javascript">
                swal("Error", "Something went worng! try again later.", "error");
                </script>';
            }

            
            
        } else {
            echo '
                <script type="text/javascript">
                swal("Error", "Something went worng! try again later.", "error");
                </script>';
        }
    


}


?>



    <!-- create post modal -->
    <div class="modal fade" id="create_post_modal" tabindex="-1" aria-labelledby="create_post_modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="create_post_modalLabel">Create Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">


            <div class="container rounded bg-white">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 border-right">
                            <div class="p-5" >
                                <div class="post_image_container">
                                <label class="-label" for="post_image">
                                    <i class="bi bi-camera"></i> &nbsp;
                                    <span>Choose Image</span>
                                </label>
                                <input id="post_image" name="post_image" type="file" onchange="loadFile(event)" accept="image/png, image/jpg, image/jpeg"/>
                                <img
                                    src="./assets/images/default/default_image.png"
                                    id="output"
                                    width="200"
                                />
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-8">
                            <div class="p-5">
                                <div class="row mt-2">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="write a caption ....." name="caption" id="Caption" style="height: 150px"></textarea>
                                    <label for="Caption">Caption</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="location" name="location" placeholder="ex. panipat , Haryana">
                                    <label for="location">location</label>
                                </div>
                                </div>
                                <div class="float-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Discard</button>
                                <button type="submit" name="share_post" class="btn btn-primary">Share</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
              
            </div>


          </div>
        </div>
      </div>
    </div>