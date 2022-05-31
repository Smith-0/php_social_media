<?php
include './assets/database/db.php';

session_start();

$login = false;

if (isset($_SESSION['id'])) {
  $login = true;

  $current_user_id = $_SESSION['id'];

  $sql = "SELECT * FROM users WHERE id = '$current_user_id'";
  $result = mysqli_query($conn , $sql);

  $current_user_info = mysqli_fetch_array($result);


  // for name
  if ($current_user_info['display_name'] == '') {
    $current_user_name = $current_user_info['email'];
  } else {
    $current_user_name = $current_user_info['display_name'];
  }

  // for profile photo
  if ($current_user_info['profile_pic'] == '') {
    $current_user_profile_pic =  './assets/images/default/profile_pic.png';
  } else {
    $dirname = "./assets/user";
    $current_user_profile_pic =  $current_user_info['profile_pic'];
  }

  
} else {
  header("Location: ./login.php");
}

?>

    <nav class="navbar navbar-light bg-white shadow-sm fixed-top">
      <div class="container d-flex justify-content-around">

        <div class="logo_container pt-1">
          <a class="navbar-brand" href="./">
            <img class="logo animate__animated animate__pulse" src="assets/images/logo.png" alt="Memories">
              Memories
          </a>
        </div>

        <div class="search_container d-none d-lg-block d-xl-block d-xxl-block">
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-dark" type="submit">Search</button>
          </form>
        </div>

        <div class="menu_container d-flex pt-1">
            
          <a href="./index.php"><h3><i class="bi bi-house-door"></i></h3></a>
          <h3><i class="bi bi-plus-circle ps-3 ps-md-4" data-bs-toggle="modal" data-bs-target="#create_post_modal"></i></h3>
          <div class="dropdown profile_dropdown ps-3 ps-md-4 pt-1" style="cursor: pointer;">
              <span id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="profile_pic_navbar shadow-sm" id="profile_pic_navbar" src="<?php echo $current_user_profile_pic; ?>" alt="Profile Photo" />
              </span>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="./profile.php?user_id=<?php echo $current_user_id; ?>"><i class="bi bi-person-circle"></i> &nbsp; Profile</a></li>
                <li><a class="dropdown-item" href="./profile.php?user_id=<?php echo $current_user_id; ?>"><i class="bi bi-file-post"></i> &nbsp; Posts</a></li>
                <li><a class="dropdown-item" href="./?saved_posts"><i class="bi bi-bookmark-fill"></i> &nbsp; Saved</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="./logout.php"><i class="bi bi-box-arrow-right"></i> &nbsp; Logout</a></li>
              </ul>
          </div>
                      
        </div>

      </div>
    </nav> <br><br>

    <?php
      include './partials/create_post.php';
    ?>