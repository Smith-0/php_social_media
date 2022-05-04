// load edited profile pic instantly

var loadFile = function (event) {
  var image = document.getElementById("output");
  image.src = URL.createObjectURL(event.target.files[0]);
};

// like Post

function likePost( post_id, current_user_id, likeBtnId, likeCountId, likeTextId ) {
  let likeBtn = document.getElementById(likeBtnId);
  let likeCount = document.getElementById(likeCountId).value;
  let likeText = document.getElementById(likeTextId).innerHTML;
  let type = "like";

  if (likeBtn.classList.contains("bi-suit-heart")) {
    type = "like";
  } else {
    type = "dislike";
  }

  $.ajax({
    type: "POST",
    url: "./ajax/like.php",
    data: { post_id, current_user_id, type },
    success: function (response) {
      if (response === "success") {
        if (type === "like") {
          likeBtn.classList.remove("bi-suit-heart");
          likeBtn.classList.add("bi-suit-heart-fill");
          likeBtn.classList.add("text-danger");

          if (likeCount == 0) {
            likeCount = 1;
            likeText = `<input type="hidden" id="${likeCountId}" value="${likeCount}">${likeCount} like`;
            document.getElementById(likeTextId).innerHTML = likeText;
          } else if (likeCount == 1) {
            likeText = `you and <input type="hidden" id="${likeCountId}" value="${
              parseInt(likeCount) + 1
            }"> ${likeCount} other`;
            document.getElementById(likeTextId).innerHTML = likeText;
          } else if (likeCount > 1) {
            likeText = `you and <input type="hidden" id="${likeCountId}" value="${
              parseInt(likeCount) + 1
            }"> ${likeCount} others`;
            document.getElementById(likeTextId).innerHTML = likeText;
          }
        } else {
          if (likeCount == 1) {
            likeCount = "";
            likeText = `<input type="hidden" id="${likeCountId}" value="${likeCount}"> <span class="text-muted fw-lighter fs-6">be the first one to </span>Like This`;
            document.getElementById(likeTextId).innerHTML = likeText;
          } else if (likeCount > 1) {
            if (likeCount == 2) {
              likeText = `<input type="hidden" id="${likeCountId}" value="${
                parseInt(likeCount) - 1
              }"> ${likeCount - 1} like`;
            } else {
              console.log("outside 2");
              likeText = `<input type="hidden" id="${likeCountId}" value="${
                parseInt(likeCount) - 1
              }"> ${likeCount - 1} likes`;
            }
            document.getElementById(likeTextId).innerHTML = likeText;
          }

          likeBtn.classList.add("bi-suit-heart");
          likeBtn.classList.remove("bi-suit-heart-fill");
          likeBtn.classList.remove("text-danger");
        }
      } else if (response === "failed") {
        swal("Error", "Something went worng! try again later.", "error");
      }
    },
  });
}


// Save Post

function savePost (post_id , current_user_id , save_post_btn_id) {

  let save_post_btn = document.getElementById(save_post_btn_id);

  if (save_post_btn.classList.contains("bi-bookmark-fill")) {
    var isSaved = true;
  } else if (save_post_btn.classList.contains("bi-bookmark")) {
    isSaved = false;
  }
  
  $.ajax({
    type: "POST",
    url: "./ajax/save_post.php",
    data : {post_id , current_user_id , isSaved},
    success: function (response) {
      if (response === "success") {

        if (isSaved) {
          save_post_btn.classList.remove("bi-bookmark-fill");
          save_post_btn.classList.add("bi-bookmark");
        } else {
          save_post_btn.classList.remove("bi-bookmark");
          save_post_btn.classList.add("bi-bookmark-fill");
        }

      } else if (response === "failed") {
        swal("Error", "Something went worng! try again later.", "error");
      }
    }
  })

}


// comment 
function comment (input_field_id , post_id , display_name , profile_pic , modal_id) {
  let comment_value = document.getElementById(input_field_id).value;

  let highest_comment_id = parseInt(document.getElementById(`highest_comment_id_input_hidden_field_${post_id}`).value) ;

  $.ajax({
    type: "POST",
    url: "./ajax/comment.php",
    data : { comment_value , post_id },
    success: function (response) {
      document.getElementById(input_field_id).value = '';
      if (modal_id) {
        var post_details_modal = new bootstrap.Modal(document.getElementById(modal_id), {
          keyboard: false
        })
        post_details_modal.show();
      }
      
        $comment_to_add = `
          <div class="row mb-3">
            <div class="col-1">
              <img
                class="profile_pic_post_comment profile_pic_post shadow-sm float-start"
                src="${profile_pic}"
                alt="Profile Photo"
              />
            </div>
          
            <div class="col-10 ps-3">
              <div class="caption comment text-muted">
                <a href="./user_profile" class="fw-bold">
                  ${display_name}
                </a>
                &nbsp; ${comment_value}
              </div>
              <div class="comment_time_likes mt-1">
                <span>a few seconds ago</span> &nbsp; &nbsp;
                <span id="comment_like_count_div_${highest_comment_id+1}">
                  0 likes
                  <input type="hidden" value="0" id="like_comment_count_${highest_comment_id+1}">
                </span>
              </div>
            </div>
          
            <div class="col-1 ps-3">
              <i class="bi bi-heart comment_like_btn" id="like_comment_btn_${highest_comment_id+1}" onclick="like_comment(${highest_comment_id+1})"></i>
            </div>
          </div>`;
          document.getElementById(`highest_comment_id_input_hidden_field_${post_id}`).value = highest_comment_id+1;
      

        $(`#all_comments_container_${post_id}`).prepend($comment_to_add);

        const comments_div = $(`#all_comments_caption_container_${post_id}`);
        comments_div.animate({
          scrollTop: 0
        }, 500);
      
    }
  })
}

// like COMMENT
function like_comment (comment_id) {
  let like_comment_btn = document.getElementById(`like_comment_btn_${comment_id}`);
  let like_comment_count = parseInt(document.getElementById(`like_comment_count_${comment_id}`).value);

  if (like_comment_btn.classList.contains('bi-heart')) {
    type = "like";
  } else {
    type = "dislike";
  }

  $.ajax({
    type: "POST",
    url: './ajax/like_comment.php',
    data: {comment_id},
    success: function (response) {
      if (response = 'success') {
        if (type == "like") {
          like_comment_count =  like_comment_count + 1;
          document.getElementById(`comment_like_count_div_${comment_id}`).innerHTML = like_comment_count + ` likes <input type="hidden" value="${like_comment_count}" id="like_comment_count_${comment_id}">` ;
          like_comment_btn.classList.remove('bi-heart');
          like_comment_btn.classList.add('bi-heart-fill');
          like_comment_btn.classList.add('text-danger');
          
        } else if (type == "dislike") {
          like_comment_count =  like_comment_count -1;
          document.getElementById(`comment_like_count_div_${comment_id}`).innerHTML = like_comment_count + ` likes <input type="hidden" value="${like_comment_count}" id="like_comment_count_${comment_id}">` ;
          like_comment_btn.classList.add('bi-heart');
          like_comment_btn.classList.remove('text-danger');
          like_comment_btn.classList.remove('bi-heart-fill');
        }

      }
    }
  })
}
