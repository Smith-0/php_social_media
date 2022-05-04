<?php
    $current_user_id = $_SESSION['id'];

    if(isset($_POST['edit_profile'])) {

        $username = $_POST['username'];
        $display_name = $_POST['display_name'];
        $mobile = $_POST['mobile'];
        $website = $_POST['website'];
        $gender = $_POST['gender'];
        $bio = $_POST['bio'];

        $sql = "UPDATE `users` SET `username` = '$username' , `display_name` = '$display_name' , `mobile`  = '$mobile' , `website` = '$website' , `gender` = '$gender', `bio` = '$bio' WHERE `users`.id = $current_user_id";

        $result = mysqli_query($conn, $sql);

        if($result) {
            echo '
                <script type="text/javascript">
                swal("Updated", "Profile updated successfully.", "success");
                if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                }
                setTimeout(() => {
                    location.reload();
                }, 1000);
                </script>';
        } else {
            echo '
                <script type="text/javascript">
                swal("Error", "Something went worng! try again later.", "error");
                </script>';
        }

    }

    if(isset($_POST['change_password'])) {
        
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        if($password === $cpassword) {
            $hashPassword = password_hash($password , PASSWORD_DEFAULT);
            $sql = "UPDATE `users` SET `password` = '$hashPassword' WHERE `users`.id = '$current_user_id'";
            $result = mysqli_query($conn , $sql);
            
            if($result) {
                echo '
                    <script type="text/javascript">
                    swal("Changed", "Password changed successfully.", "success");
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
                swal("Not Match", "Password and confirm password must be match.", "error");
                </script>';
        }
    }

?>


<!-- edit profile offcanvas -->

<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="edit_profile_offcanvas" aria-labelledby="edit_profile_offcanvasLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasLabel">Edit Profile</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="" method="post" id="edit_profile" enctype="multipart/form-data">


            <div class="container rounded bg-white">
                <div class="px-4 py-3">
                    <div class="row mt-2">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" value="<?php echo $current_user_info['username']; ?>" name="username" placeholder="ex. panipat , Haryana" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="display_name" value="<?php echo $current_user_info['display_name']; ?>" name="display_name" placeholder="ex. panipat , Haryana" required>
                            <label for="display_name">Display Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="mobile" value="<?php echo $current_user_info['mobile']; ?>" name="mobile" placeholder="ex. panipat , Haryana">
                            <label for="mobile">Mobile</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="website" value="<?php echo $current_user_info['website']; ?>" name="website" placeholder="ex. panipat , Haryana">
                            <label for="Website">Website</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="gender" name="gender" value="<?php echo $current_user_info['']; ?> aria-label="Floating label select example">
                                <option value="Male" <?php if($current_user_info['gender'] == 'Male') echo 'selected'?>>Male</option>
                                <option value="Female" <?php if($current_user_info['gender'] == 'Female') echo 'selected'?>>Female</option>
                                <option value="Other" <?php if($current_user_info['gender'] == 'Other') echo 'selected'?>>Other</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="write a bio ....." name="bio" id="bio" style="height: 150px"><?php echo $current_user_info['bio']; ?></textarea>
                            <label for="bio">Bio</label>
                        </div>

                        <div class="buttons">
                            <button type="submit" name="edit_profile" class="btn btn-primary float-end">Save Changes</button>
                            <button type="button" class="btn btn-secondary me-2 float-end" data-bs-dismiss="offcanvas" aria-label="Close">Discard</button>
                        </div>

                    </div>

                </div>


            </div>

        </form>
    

    <hr>
    <form action="" method="post" id="change_password" >
            <h5 class="ps-3">Change Password</h5>

            <div class="container rounded bg-white">
                <div class="px-4 py-3">
                    <div class="row mt-2">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="ex. panipat , Haryana" required>
                            <label for="password">Password</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="ex. panipat , Haryana" required>
                            <label for="cpassword">Confirm password</label>
                        </div>

                        <div class="buttons">
                            <button type="submit" name="change_password" class="btn btn-primary float-end">Change Password</button>
                            <button type="button" class="btn btn-secondary me-2 float-end" data-bs-dismiss="offcanvas" aria-label="Close">cancel</button>
                        </div>

                    </div>

                </div>


            </div>

        </form>

        </div>
    

</div>