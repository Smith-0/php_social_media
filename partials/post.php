<?php

  $sql = "SELECT * FROM `posts` ORDER BY created_at DESC";
  $result = mysqli_query($conn, $sql);

?>

<script>
      function get_time_fn (id , time) {
        let time_span = document.getElementById(id);
        time_span.innerHTML = moment(time).startOf("second").fromNow();
        time_span.title = moment(time).format('MMMM Do YYYY, h:mm:ss a');
      }
    </script>




<div class="post_container my-5 py-3">
      <div class="row">
        

      <?php
        
        while ($post_info = mysqli_fetch_array($result)) {

          $post_id = $post_info['id'];

          // logged in user id
          $current_user_id = $_SESSION['id'];

          // This post user info
          $post_user_id = $post_info['user_id'];
          $post_user_info  = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM `users` where id = $post_user_id"));

          if ($post_user_info['display_name'] === '') {
            $email = $post_user_info['email'];
            $display_name =  explode("@",$email)[0];
          } else {
            $display_name = $post_user_info['display_name'];
          }

          if ($post_user_info['profile_pic'] === '') {
            $post_user_profile_pic = './assets/images/default/profile_pic.png';
          } else {
            $post_user_profile_pic = $post_user_info['profile_pic'];
          }

          // like count and display likes
          $likes = unserialize($post_info['likes']);
          $like_count = count($likes);
          $your_like_exist = in_array($current_user_id , $likes);
          if($your_like_exist) { $your_like_exist = 'exist';} else {$your_like_exist = 'not exist';};

          if ($like_count == 0) {
            $like_text = '<input type="hidden" value="'.$like_count.'" id="likeCount_'.$post_id.'" /> <span class="text-muted fw-lighter fs-6">be the first one to </span>Like This';
          } else if ($like_count == 1) {
            $like_text = '<input type="hidden" value="'.$like_count.'" id="likeCount_'.$post_id.'" /> '.$like_count.' like';
          } else if ($your_like_exist === 'exist'){
            if ($like_count === 2) {
              $like_text = '<input type="hidden" value="'.$like_count.'" id="likeCount_'.$post_id.'" /> you and '.($like_count-1).' other';
            } else {
              $like_text = '<input type="hidden" value="'.$like_count.'" id="likeCount_'.$post_id.'" /> you and '.($like_count-1).' others';
            }
            
          } else {
            $like_text = '<input type="hidden" value="'.$like_count.'" id="likeCount_'.$post_id.'" />'.$like_count.' likes';
          }

          // save post
          $current_user_info = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM users WHERE id=$current_user_id"));
          $saved_posts = unserialize($current_user_info['saved_posts']);
          $is_saved = 'false';

          if (in_array($post_id, $saved_posts)) {
            $is_saved = 'true';
          }


          // comments info
          $comments_result  = mysqli_query($conn, "SELECT * FROM `comments` WHERE `post_id` = '$post_id' ORDER BY created_at DESC");
          $no_of_comments = mysqli_num_rows($comments_result);

          // highest comment id
          $highest_comment_id = mysqli_fetch_assoc(mysqli_query($conn ,"SELECT max(id) AS id FROM `comments`"))['id'];

          // highest_comment_id_input_hideen_field
          echo '                   
          <input type="hidden" id="highest_comment_id_input_hidden_field_'.$post_id.'" value="'.$highest_comment_id.'">';
          





          echo'

          <div class="col-lg-8">
            <div class="card mb-5">
                  <div class="border-bottom py-2 px-3 d-flex justify-content-between">
                    <div class="profile_pic_display_name">
                      <img class="profile_pic_post shadow-sm" src="'.$post_user_profile_pic.'" alt="Profile Photo" />
                      <div class="location_display_name_container d-inline">
                      &nbsp; &nbsp; <a href="./user_profile" class="display_name_header">'.$display_name.'</a>
                            <span class="location">';
                              if($post_info['location'] !== '' ){ echo $post_info['location'] ;};
                      echo  '</span>
                      </div>
                       
                    </div>
                    <div class="options">
                      <h3><i class="bi bi-three-dots-vertical"></i></h3>
                    </div>
                  </div>
                  <img class="post_image" src="'.$post_info['image'].'" class="card-img-top" alt="default_image" />
                  <div class="card-body">
                    <div class="icon_container d-flex justify-content-between">
                      <div class="like_comment_logo_div">
                        <h4 class="d-inline">
                          <i ';
                            if ($your_like_exist === 'exist') {echo 'class="post_icon bi bi-suit-heart-fill text-danger like_icon" '; }
                            else {echo 'class="post_icon bi bi-suit-heart like_icon" ';}
                            echo 'id="likeBtn_'.$post_id.'"
                            onclick="likePost('.$post_id.' ,'.$current_user_id.', `likeBtn_'.$post_id.'`, `likeCount_'.$post_id.'`, `likeText_'.$post_id.'`)">
                          </i>
                        </h4> &nbsp; 
                        <label for="comment_input_'.$post_id.'">
                          <h4 class="d-inline"><i class="bi bi-chat"></i></h4>
                        </label>
                      </div>
                      <div class="save_post_logo_div">
                        <h4 class="d-inline">
                          <i ';
                            if ($is_saved === 'true') {echo 'class="post_icon bi bi-bookmark-fill save_post_icon" '; }
                            else {echo 'class="post_icon bi bi-bookmark save_post_icon" ';}
                            echo 'id="save_post_btn_'.$post_id.'"
                            onclick="savePost('.$post_id.' ,'.$current_user_id.' , `save_post_btn_'.$post_id.'`)"
                          ></i>
                        </h4>
                      </div>
                    </div>
                    <span class="like_count d-block mt-2" id="likeText_'.$post_id.'">'.$like_text.'</span>
                    <a href="./user_profile" class="display_name">'.$display_name.'</a> 
                          ';
                            if(strlen($post_info['caption'] < 150 )) {
                              echo '<span class="caption">'.$post_info['caption'].'</span>';
                            } else {
                              echo '<span class="caption">'.substr($post_info['caption'] , 0 , 150).'</span>
                              <span class="caption caption_more text-muted">...more</span>';
                            }
                    
                    echo '
                    <span class="view_comments d-block text-muted" data-bs-toggle="modal" data-bs-target="#post_details_'.$post_info["id"].'">View all '.$no_of_comments.' comments</span>
                      <span id="time_'.$post_id.'" class="badge bg-light text-dark time" data-bs-toggle="tooltip" data-bs-placement="top" title="">';
                        echo '<script>get_time_fn("time_'.$post_info["id"].'" , "'.$post_info["created_at"].'");</script>';
                      
                      
                     echo '</span>
                  </div>
                  <div class="border-top p-2">
                    <div class="input-group">
                      <input type="text" id="comment_input_'.$post_id.'" class="form-control" placeholder="Add a comment..." aria-label="Recipient\'s username" aria-describedby="basic-addon2">
                      <button 
                        class="btn btn-outline-secondary" 
                        type="button" 
                        onclick="comment(`comment_input_'.$post_id.'` , '.$post_id.' , `'.$current_user_info['display_name'].'` , `'.$current_user_info['profile_pic'].'` , `post_details_'.$post_id.'`)">
                          <i class="bi bi-send"></i>
                      </button>
                    </div>
                  </div>
            </div>
          </div>';



          // post details modal
          


                echo '<!-- Modal -->
                <div class="modal fade" id="post_details_'.$post_id.'" data-bs-keyboard="false" tabindex="-1" aria-labelledby="post_details_'.$post_id.'Label" aria-hidden="true">
                  <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                      <div class="row">

                        <div class="col-lg-7 d-none d-sm-none d-md-none d-lg-block d-xl-block d-xxl-block">
                          <img class="post_details_image" src="'.$post_info['image'].'">
                        </div>

                        <div class="col-lg-5 col-12 postion-relative">

                          

                          <div class="col-lg-5 col-12 border-top p-2 position-absolute bottom-0 bg-light">
                            <div class="input-group">
                              <input type="text" id="post_details_comment_input_'.$post_id.'" class="form-control" placeholder="Add a comment..." aria-label="Recipient\'s username" aria-describedby="basic-addon2">
                              <button 
                                class="btn btn-outline-secondary" 
                                type="button" 
                                onclick="comment(`post_details_comment_input_'.$post_id.'` , '.$post_id.' , `'.$current_user_info['display_name'].'` , `'.$current_user_info['profile_pic'].'` )">
                                  <i class="bi bi-send"></i>
                              </button>
                            </div>
                          </div>

                          <div class="card">
                            <div class="border-bottom py-2 px-3 d-flex justify-content-between">
                              <div class="profile_pic_display_name">
                                <img class="profile_pic_post shadow-sm" src="'.$post_user_profile_pic.'" alt="Profile Photo" />
                                <div class="location_display_name_container d-inline">
                                &nbsp; &nbsp; <a href="./user_profile" class="display_name_header">'.$display_name.'</a>
                                      <span class="location">';
                                        if($post_info['location'] !== '' ){ echo $post_info['location'] ;};
                                echo  '</span>
                                </div>
                                
                              </div>
                              <div class="options">
                                <h3><i class="bi bi-three-dots-vertical"></i></h3>
                              </div>
                            </div>
                          </div>  

                          
                          <div class="all_comments_caption_container"   id="all_comments_caption_container_'.$post_id.'">
                          
                            <div class="row mb-5">
                              <div class="col-1">
                                <img class="profile_pic_post_comment shadow-sm float-start" src="'.$post_user_profile_pic.'" alt="Profile Photo" />
                              </div>
                              <div class="col-11 ps-3">
                                
                                <div class="caption text-muted"><a href="./user_profile" class="fw-bold">'.$display_name.'</a>  &nbsp;'.$post_info['caption'].'</div>
                              </div>
                            </div>

                            <div  id="all_comments_container_'.$post_id.'">';

                            

                            while ($comments_info = mysqli_fetch_array($comments_result)) {

                              echo '<div class="highest_comment_id_input_hideen_field_'.$comments_info["id"].'"></div>';

                              // comment user info 
                              $comment_user_id = $comments_info['user_id'];
                              $comment_user_info = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM `users` where `id` = '$comment_user_id'"));

                              // comment like info
                              $likes = unserialize($comments_info['likes']);
                              $no_of_likes = count($likes);

                              // current user like exist in comment or not
                              $is_you_like_comment = in_array($current_user_id , $likes);



                              echo '
                              <div class="row mb-4">

                                <div class="col-1">
                                  <img class="profile_pic_post_comment profile_pic_post shadow-sm float-start" src="'.$comment_user_info['profile_pic'].'" alt="Profile Photo" />
                                </div>

                                <div class="col-10 ps-3">  
                                  <div class="caption comment text-muted"><a href="./user_profile" class="fw-bold">'.$comment_user_info['display_name'].'</a>  &nbsp; '.$comments_info['comment'].'</div>
                                  <div class="comment_time_likes">
                                    <span style="cursor: pointer" id="comment_time_'.$comments_info["id"].'"  data-bs-toggle="tooltip" data-bs-placement="top" title="">';
                                      echo '<script>get_time_fn("comment_time_'.$comments_info["id"].'" , "'.$comments_info["created_at"].'");</script>';
                            echo'   </span> &nbsp; &nbsp;
                                    <span id="comment_like_count_div_'.$comments_info["id"].'">
                                      '.$no_of_likes.' likes
                                      <input type="hidden" value="'.$no_of_likes.'" id="like_comment_count_'.$comments_info['id'].'">
                                    
                                    </span>
                                  </div>
                                </div>

                                <div class="col-1 ps-3 pt-1">
                                  <i ';
                                    if ($is_you_like_comment) {
                                      echo 'class="bi bi-heart-fill text-danger comment_like_btn"';
                                    } else {
                                      echo 'class="bi bi-heart comment_like_btn"';
                                    }
                                    
                                    echo'
                                    id = "like_comment_btn_'.$comments_info['id'].'"
                                    onclick="like_comment('.$comments_info['id'].')">
                                  </i>

                                  
                                </div>
                            
                              </div>';
                            }
                            
                              
                            
                      echo' </div>

                          </div>



                          
                
                
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';



        }

      ?>





      </div>
    </div>





    
          
        

    