<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/Account.php';
$accountController = new AccountController();
$idUser = $_SESSION['idUser'];
$user = $accountController->findUserbyId($idUser);
$user->getProfile_picture_url();
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'post';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png">
    <link rel="stylesheet" href="/assets/CSS/variables.css">s
    <link rel="stylesheet" href="/assets/CSS/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
      

    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="profile-container">
    <div class="cover-photo">
            <img src="https://via.placeholder.com/850x250" alt="Cover Photo">
            <div class="avatar-profile">
                <?php
                $img = $user->getProfile_picture_url();
                $avatarSrc = '/assets/images/' . $img;
                echo '<img id="avatar_img" class="avatar" src="' . $avatarSrc . '" alt="">';
                ?>
                <!-- Avatar Upload Icon -->
                <label for="avatar-upload" class="avatar-upload-icon">
                    <i class="fas fa-camera" style="font-size: 20px; color: black;"></i>
                </label>
                <input type="file" id="avatar-upload" accept="image/*" style="display: none;" onchange="previewImage(event)">
            </div>
        </div>
        <div class="profile-info">
            <div class="user-details">
                <h2><?php echo $user->getFull_name(); ?></h2>
                <p>100 friends</p>
                <button class="edit-information-btn">Chỉnh sửa trang cá nhân</button>
            </div>
        </div>

        <div class="profile-nav">
            <form method="GET" action="">
                <ul>
                    <li>
                        <button type="submit" name="tab" value="posts" class="nav-button <?php echo ($activeTab == 'posts') ? 'active' : ''; ?>">
                            <i class="fas fa-th"></i> Bài viết
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="tab" value="about" class="nav-button <?php echo ($activeTab == 'about') ? 'active' : ''; ?>">
                            <i class="fas fa-info-circle"></i> Giới thiệu
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="tab" value="friends" class="nav-button <?php echo ($activeTab == 'friends') ? 'active' : ''; ?>">
                            <i class="fas fa-user-friends"></i> Bạn bè
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="tab" value="photos" class="nav-button <?php echo ($activeTab == 'photos') ? 'active' : ''; ?>">
                            <i class="fas fa-camera"></i> Ảnh
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="tab" value="more" class="nav-button <?php echo ($activeTab == 'more') ? 'active' : ''; ?>">
                            <i class="fas fa-ellipsis-h"></i> Xem thêm
                        </button>
                    </li>
                </ul>
            </form>
        </div>

        <div class="content-section">
            <?php
            if ($activeTab == 'posts') {

            ?>
            <div class="container mt-3">
  <!-- Thanh tạo bài viết -->
  <div class="create-post-section">
    <div class="create-post">
      <img src="https://via.placeholder.com/50" alt="User Avatar" class="user-avatar">
      <input type="text" placeholder="Bạn đang nghĩ gì?" class="post-input" data-bs-toggle="modal" data-bs-target="#createPostModal">
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="createPostModalLabel">Tạo bài viết</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <div class="d-flex mb-3">
          <img src="https://via.placeholder.com/50" alt="User Avatar" class="user-avatar">
          <div class="ms-3">
            <h6>Mỹ Ly</h6>
            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Công khai
            </button>
          </div>
        </div>
        <textarea class="form-control" rows="4" placeholder="Bạn đang nghĩ gì?"></textarea>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <div class="d-flex justify-content-between w-100">
          <div>
            <button class="btn btn-light"><i class="fas fa-photo-video"></i> Ảnh/Video</button>
            <button class="btn btn-light"><i class="fas fa-smile"></i> Cảm xúc</button>
            <button class="btn btn-light"><i class="fas fa-location-arrow"></i> Địa điểm</button>
          </div>
          <button class="btn btn-primary">Đăng</button>
        </div>
      </div>
    </div>
  </div>
</div>

                <div class="post">
                    <div class="post-header">
                        <img src="https://via.placeholder.com/50" alt="User Avatar">
                        <div class="post-user">
                            <p><strong>John Doe</strong></p>
                            <p>1 hour ago</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>This is an example post content just like Facebook.</p>
                    </div>
                    <div class="post-footer">
                        <button><i class="fas fa-thumbs-up"></i> Thích</button>
                        <button><i class="fas fa-comment"></i> Bình luận</button>
                        <button><i class="fas fa-share"></i> Chia sẻ</button>
                    </div>
                </div>
            <?php
            } elseif ($activeTab == 'about') {
            ?>
                <div class="about-section">
                    <h3>About</h3>
                    <p>This is the About section. Here you can add more information about yourself.</p>
                </div>
            <?php
            } elseif ($activeTab == 'friends') {
                // Nội dung cho tab Friends
            ?>
                <div class="friends-section">
                    <h3>Friends</h3>
                    <p>This is the Friends section. List of your friends will appear here.</p>
                </div>
            <?php
            } elseif ($activeTab == 'photos') {
                // Nội dung cho tab Photos
            ?>
                <div class="photos-section">
                    <h3>Photos</h3>
                    <p>This is the Photos section. Your photos will be displayed here.</p>
                </div>
            <?php
            } elseif ($activeTab == 'more') {
                // Nội dung cho tab More
            ?>
                <div class="more-section">
                    <h3>More</h3>
                    <p>This is the More section. Additional information and options can be added here.</p>
                </div>
            <?php
            } else {
                // Nội dung mặc định nếu không tìm thấy tab
            ?>
                <div class="post">
                    <div class="post-header">
                        <img src="https://via.placeholder.com/50" alt="User Avatar">
                        <div class="post-user">
                            <p><strong>John Doe</strong></p>
                            <p>1 hour ago</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p>This is an example post content just like Facebook.</p>
                    </div>
                    <div class="post-footer">
                        <button><i class="fas fa-thumbs-up"></i> Like</button>
                        <button><i class="fas fa-comment"></i> Comment</button>
                        <button><i class="fas fa-share"></i> Share</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>
<script>
    function previewImage(event) {
        const image = document.querySelector('.avatar-profile img');
        image.src = URL.createObjectURL(event.target.files[0]); // Preview the selected image
    }
</script> 