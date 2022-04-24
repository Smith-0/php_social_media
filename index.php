<?php
include './assets/database/db.php';

session_start();

$login = false;

if (isset($_SESSION['id'])) {
  $login = true;

  $user_id = $_SESSION['id'];

  $sql = "SELECT * FROM users WHERE id = '$user_id'";
  $result = mysqli_query($conn , $sql);

  $user_info = mysqli_fetch_array($result);


  // for name
  if ($user_info['name'] == '') {
    $user_name = $user_info['email'];
  } else {
    $user_name = $user_info['name'];
  }

  // for profile photo
  if ($user_info['profile_pic'] == '') {
    $user_profile_pic =  './assets/images/default/profile_pic.png';
  } else {
    $dirname = "./assets/user";
    $user_profile_pic =  glob("{$dirname}*.png, {$dirname}*.jpeg , {$dirname}*.jpg, {$dirname}*.gif");
  }

  
}

?>

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

    <!-- Main Css -->
    <link rel="stylesheet" href="assets/css/index.css">

    <title>Memories</title>
  </head>
  <body>
    <nav class="py-2 navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <img class="logo" src="assets/images/logo.png" alt="Memories">
        <a class="navbar-brand" href="#">Memories</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            
          </ul>

          <?php
            if (!$login) {
              echo '<div class="d-grid gap-2">
                      <a href="./login.php" class="login_register_btn btn btn-primary mx-lg-3 btn-block" type="submit">LogIn / Register</a>
                    </div>';
            } else {
              echo '
                    <div class="dropdown mx-lg-3 profile_dropdown">
                        <button class="btn py-2 btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                          <img class="profile_pic" src="'.$user_profile_pic.'" alt="Profile Photo" /> &nbsp; '.$user_name.'
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                          <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle"></i> &nbsp; Profile</a></li>
                          <li><a class="dropdown-item" href="#"><i class="bi bi-file-post"></i> &nbsp; Posts</a></li>
                          <li><a class="dropdown-item" href="#"><i class="bi bi-bookmark-fill"></i> &nbsp; Saved</a></li>
                          <li><a class="dropdown-item" href="./logout.php"><i class="bi bi-box-arrow-right"></i> &nbsp; Logout</a></li>
                        </ul>
                    </div>';
            }
          ?>
          
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

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