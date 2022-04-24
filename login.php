<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- tab icon -->
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- Login /Register Css -->
    <link rel="stylesheet" href="assets/css/login_register.css">

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <title>Memories</title>
  </head>
  <body>

  <?php 

    // tabs active logic

    if (isset($_POST['login_submit'])) {
      $login_tab = 'active';
      $login_tab_area = 'true';
      $login_tab_area_show = 'show active';
      $register_tab = '';
      $register_tab_area = 'false';
      $register_tab_area_show = '';
    } else {
      $login_tab = '';
      $login_tab_area = 'false';
      $login_tab_area_show = '    ';
      $register_tab = 'active';
      $register_tab_area = 'true';
      $register_tab_area_show = 'show active';
    }

    include './assets/database/db.php';


    // for register

    if (isset($_POST['register_submit'])) {

      $email = $_POST['email'];
      $password = $_POST['password'];
      $cpassword = $_POST['cpassword'];

      // check email exist or not
      $num_of_users = mysqli_num_rows(mysqli_query($conn , "SELECT * FROM users WHERE email = '$email'"));

      if ($num_of_users === 0 ) {

        // passwords same check
        if ($password === $cpassword) {

          $hashPassword = password_hash($password, PASSWORD_DEFAULT);

          $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashPassword')";
          $result = mysqli_query($conn , $sql);
          
          if ($result) {

            session_start();
            $_SESSION['email'] = $user_info['email'];
            $_SESSION['id'] = $user_info['id'];
            header('location: ./index.php');

            // remember_me checked or not
            if(isset($_POST['remember_me'])) {
              $hour = time() + 3600 * 24 * 30; // 30 days
              setcookie('username', $email, $hour);
              setcookie('password', $password, $hour);
            }

          } else {
            echo '<script>swal("Internal Error!", "Please try after some time!", "error");</script>';
          }
          
        } else {
          echo '<script>swal("Not Match!", "Password and confirm password must be same!", "warning");</script>';
        }

      } else {
        echo '<script>swal("Already Exist!", "Try with another email!", "warning");</script>';
      }
      

    }


    // for login

    if (isset($_POST['login_submit'])) {

      $email = $_POST['email'];
      $password = $_POST['password'];

      // check email exist or not
      $result = mysqli_query($conn , "SELECT * FROM users WHERE email = '$email'");
      $num_of_users = mysqli_num_rows($result);

      if ($num_of_users === 1 ) {

        // database password
        $user_info = mysqli_fetch_assoc($result);
        $user_password = $user_info['password'];

        // password check
        if (password_verify($password, $user_password)) {
          
          if ($result) {
            
            session_start();
            $_SESSION['email'] = $user_info['email'];
            $_SESSION['id'] = $user_info['id'];
            header('location: ./index.php');

            // remember_me checked or not
            if(isset($_POST['remember_me'])) {
              $hour = time() + 3600 * 24 * 30; // 30 days
              setcookie('username', $email, $hour);
              setcookie('password', $password, $hour);
            }

          } else {
            echo '<script>swal("Internal Error!", "Please try after some time!", "error");</script>';
          }
          
        } else {
          echo '<script>swal("Not Match!", "Password and confirm password must be same!", "warning");</script>';
        }

      } else {
        echo '<script>swal("Not Exist!", "First register with this email!", "warning");</script>';
      }
      

    }

  ?>




      <div class="page">
        <div class="main_container card">
          <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
            <li class="nav-item login_tab <?php echo $login_tab; ?>" role="presentation">
              <button class="btn btn-outline-primary <?php echo $login_tab ; ?>" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-login" aria-selected="<?php echo $login_tab_area; ?>">Login</button>
            </li>
            <li class="nav-item register_tab <?php echo $register_tab; ?> " role="presentation">
              <button class="btn btn-outline-primary <?php echo $register_tab; ?>" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab" aria-controls="pills-register" aria-selected="<?php echo $register_tab_area; ?>">Register</button>
            </li>
          </ul>

          <!-- Login Tab -->
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade <?php echo $login_tab_area_show; ?>" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
              <form method="post" action="">
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" placeholder="name@example.com">
                  <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="password" placeholder="password">
                  <label for="password">Password</label>
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" name="remember_me">
                  <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>
                <button type="submit" name="login_submit" class="btn btn-primary">Login</button>
              </form>
            </div>

            <!-- Register Tab -->
            <div class="tab-pane fade <?php echo $register_tab_area_show; ?>" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
              <form method="POST" action="">
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" placeholder="name@example.com">
                  <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="password" placeholder="password">
                  <label for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="cpassword" placeholder="password">
                  <label for="cpassword">Password</label>
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" name="remember_me">
                  <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>
                <button type="submit" name="register_submit" class="btn btn-primary">Register</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    
  
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>