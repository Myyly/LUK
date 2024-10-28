<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/Account.php';
// require_once '../../Process/profile_process.php';
$accountController = new AccountController();
$idUser = $_SESSION['idUser'];
$user = $accountController->findUserbyId($idUser);
$user->getProfile_picture_url();
$activeTab = isset($_GET['sk']) ? $_GET['sk'] : '';
$idUser = isset($_GET['id']) ? $_GET['id'] : '';
//var_dump($user->getCover_photo_url()); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png">
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <link rel="stylesheet" href="/assets/CSS/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    /* Căn giữa tiêu đề */
    .modal-header {
        display: flex;
        justify-content: center;
        /* Căn giữa theo chiều ngang */
        align-items: center;
        /* Căn giữa theo chiều dọc */
        text-align: center;
    }

    .modal-title {
        flex-grow: 1;
        /* Đảm bảo tiêu đề chiếm toàn bộ không gian và căn giữa */
    }


    /* Căn giữa ảnh đại diện */
    .modal-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        /* Căn giữa ảnh đại diện theo chiều ngang */
    }

    /* Giới hạn kích thước tối đa của ảnh */
    #avatarPreview {
        /* width: 100%;
        max-width: 300px; */
        margin-bottom: 20px;
        display: block;
        /* Đảm bảo ảnh hiển thị dưới dạng block */
    }

    .cover-img {
        width: 750px;
        height: 250px;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .avatar-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        /* Cắt tròn cho avatar */
        object-fit: cover;
        margin-bottom: 20px;
       
    }
</style>

<body>
    <?php include 'header.php'; ?>
    <div class="profile-container">
        <div class="cover-photo">
            <?php
            $cover = $user->getCover_photo_url();
            if ($cover) {
                $base64Image = base64_encode($cover);
                $coverSrc = 'data:image/jpeg;base64,' . $base64Image;
                echo '<img id="cover_img" src="' . $coverSrc . '" alt="">';
            } else {
                echo '<img id="cover_img" src="https://via.placeholder.com/850x250" alt="">';
            }
            ?>
            <div class="avatar-profile">
                <?php
                $img = $user->getProfile_picture_url();
                if ($img) {
                    $base64Image = base64_encode($img);
                    $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                    echo '<img id="avatar_img" class="avatar" src="' . $avatarSrc . '" alt="">';
                } else {
                    echo '<img id="avatar_img" class="avatar" src="/path/to/default-avatar.png" alt="">'; // Thay đường dẫn ảnh mặc định
                }
                ?>
                <label for="avatar-upload" class="avatar-upload-icon" data-bs-toggle="modal" data-bs-target="#avatarUploadModal">
                    <i class="fas fa-camera" style="font-size: 20px; color: black;"></i>
                </label>


            </div>
            <div class="cover-upload">
                <label for="cover-upload" class="cover-upload-icon" data-bs-toggle="modal" data-bs-target="#coverUploadModal">
                    <i class="fas fa-camera" style="font-size: 20px; color: black;"></i>
                </label>
            </div>
        </div>




        <div class="profile-info">
            <div class="user-details">
                <h2><?php echo $user->getFull_name(); ?></h2>
                <?php
                $total_friends = $accountController->getTotalFriends($idUser);
                ?>
                <p><?php echo  $total_friends. " người bạn" ?></p>
                <button class="edit-information-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">Chỉnh sửa trang cá nhân</button>
            </div>
        </div>
        <div class="profile-nav">
            <form method="GET" action="">
                <input type="hidden" name="id" value="<?php echo $idUser; ?>">
                <ul>
                    <li>
                        <button type="submit" name="sk" value="posts" class="nav-button <?php echo ($activeTab == 'posts') ? 'active' : ''; ?>">
                            <i class="fas fa-th"></i> Bài viết
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="sk" value="about" class="nav-button <?php echo ($activeTab == 'about') ? 'active' : ''; ?>">
                            <i class="fas fa-info-circle"></i> Giới thiệu
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="sk" value="friends" class="nav-button <?php echo ($activeTab == 'friends') ? 'active' : ''; ?>">
                            <i class="fas fa-user-friends"></i> Bạn bè
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="sk" value="photos" class="nav-button <?php echo ($activeTab == 'photos') ? 'active' : ''; ?>">
                            <i class="fas fa-camera"></i> Ảnh
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="sk" value="more" class="nav-button <?php echo ($activeTab == 'more') ? 'active' : ''; ?>">
                            <i class="fas fa-ellipsis-h"></i> Xem thêm
                        </button>
                    </li>
                </ul>
            </form>
        </div>
        <div class="content-section">
            <?php
            if ($activeTab == 'friends' || $activeTab == 'friends_all') {
            ?>
                <div class="friends-section">
                    <h3>Bạn bè</h3>
                    <div class="search-friends">
                        <input type="text" class="form-control" placeholder="Tìm kiếm bạn bè">
                    </div>
                    <form method="GET" action="">
                        <input type="hidden" name="id" value="<?php echo $idUser; ?>"> <!-- Giữ lại id trong URL -->
                        <div class="friends-filter mt-3">
                            <ul class="nav nav-pills">
                                <li>
                                    <button type="submit" name="sk" value="friends_all" class="nav-button <?php echo ($activeTab == 'friends_all') ? 'active' : ''; ?>">
                                        Tất cả bạn bè
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            <?php
            }
            if ($activeTab == 'friends_all') {
            ?>
                <div class="friends-list mt-4">
                    <h4>Danh sách bạn bè</h4>
                    <div class="friend-item d-flex align-items-center">
                        <img src="/path/to/avatar1.jpg" alt="Friend 1" class="friend-avatar rounded-circle me-3" style="width: 60px; height: 60px;">
                        <div>
                            <h5>Thủy Trâm</h5>
                            <p class="text-muted">176 bạn chung</p>
                        </div>
                    </div>
                    <div class="friend-item d-flex align-items-center mt-3">
                        <img src="/path/to/avatar2.jpg" alt="Friend 2" class="friend-avatar rounded-circle me-3" style="width: 60px; height: 60px;">
                        <div>
                            <h5>Nguyễn Đình Phong</h5>
                            <p class="text-muted">46 bạn chung</p>
                        </div>
                    </div>
                    <div class="friend-item d-flex align-items-center mt-3">
                        <img src="/path/to/avatar3.jpg" alt="Friend 3" class="friend-avatar rounded-circle me-3" style="width: 60px; height: 60px;">
                        <div>
                            <h5>Thị Ni Lê</h5>
                            <p class="text-muted">218 bạn chung</p>
                        </div>
                    </div>

                </div>
            <?php
            } elseif ($activeTab == 'photos') {
            ?>
                <div class="photos-section">
                    <h3>Photos</h3>
                    <p>This is the Photos section. Your photos will be displayed here.</p>
                </div>
            <?php
            } elseif ($activeTab == 'more') {
            ?>
                <div class="more-section">
                    <h3>More</h3>
                    <p>This is the More section. Additional information and options can be added here.</p>
                </div>
            <?php
            } elseif ($activeTab == 'about') {
            ?>
                <div class="about-section">
                    <h3>About</h3>
                    <p>This is the About section. Here you can add more information about yourself.</p>
                </div>
            <?php
            } else if ($activeTab == 'posts') {
                // Nội dung cho tab Posts
            ?>
                <div class="container mt-3">
                    <div class="create-post-section">
                        <div class="create-post">
                            <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" class="user-avatar">
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
                                    <img src="<?php echo $avatarSrc; ?>" alt="User Avatar" style="width:50px; height:50px; border-radius:50%;">
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
                </div>-
            <?php
            } else {
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
            <?php } ?>
        </div>
        <!-- Modal để chỉnh sửa ảnh đại diện -->
        <div class="modal fade" id="avatarUploadModal" tabindex="-1" aria-labelledby="avatarUploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="avatarUploadModalLabel">Chọn ảnh đại diện</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="avatarUploadForm" action="../../Process/profile_process.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="avatarPreview" class="form-label"></label>
                                <?php
                                $img = $user->getProfile_picture_url();
                                $base64Image = base64_encode($img);
                                $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                                ?>
                                <img id="avatarPreview" src="<?php echo $avatarSrc ?>" alt="Avatar preview" class="avatar-img">
                            </div>
                            <div class="mb-3">
                                <label for="avatarUpload" class="form-label">Chọn ảnh</label>
                                <input type="file" class="form-control" id="avatarUpload" name="avatar" accept="image/*" onchange="previewAvatar(event)">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-primary" form="avatarUploadForm" name="UpdateAvatar">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal để chỉnh sửa ảnh bìa -->
        <div class="modal fade" id="coverUploadModal" tabindex="-1" aria-labelledby="coverUploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="coverUploadModalLabel">Chọn ảnh bìa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="coverUploadForm" action="../../Process/profile_process.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="coverPreview" class="form-label"></label>
                                <?php
                                $cover = $user->getCover_photo_url();
                                $base64Image = base64_encode($cover);
                                $coverSrc = 'data:image/jpeg;base64,' . $base64Image;
                                ?>
                                <img id="coverPreview" src="<?php echo $coverSrc ?>" alt="cover preview" class="cover-img">
                            </div>
                            <div class="mb-3">
                                <label for="coverUpload" class="form-label">Chọn ảnh</label>
                                <input type="file" class="form-control" id="coverUpload" name="cover" accept="image/*" onchange="previewCover(event)">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" class="btn btn-primary" form="coverUploadForm" name="UpdateCover">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- chỉnh sửa trang cá nhân  -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Chỉnh sửa trang cá nhân</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProfileForm" action="../../Process/profile_process.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="profileImage" class="form-label">Chỉnh sửa ảnh đại diện</label>
                                <div class="mb-3">
                                    <label for="avatarPreview" class="form-label"></label>
                                    <?php
                                    $img = $user->getProfile_picture_url();
                                    $base64Image = base64_encode($img);
                                    $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                                    ?>
                                    <img id="avatarPreviewEdit" src="<?php echo $avatarSrc ?>" alt="Avatar preview" class="avatar-img">
                                </div>
                                <div class="mb-3">
                                    <label for="avatarUpload" class="form-label">Chọn ảnh</label>
                                    <input type="file" class="form-control" id="avatarUpload" name="avatar" accept="image/*" onchange="previewAvatarEdit(event)">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="coverImage" class="form-label">Chỉnh sửa ảnh bìa</label>
                                <div class="mb-3">
                                    <label for="coverPreview" class="form-label"></label>
                                    <?php
                                    $cover = $user->getCover_photo_url();
                                    $base64Image = base64_encode($cover);
                                    $coverSrc = 'data:image/jpeg;base64,' . $base64Image;
                                    ?>
                                    <img id="coverPreviewEdit" src="<?php echo $coverSrc ?>" alt="cover preview" class="cover-img">
                                </div>
                                <input type="file" class="form-control" id="coverUpload" name="cover" accept="image/*" onchange="previewCoverEdit(event)">
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Tiểu sử</label>
                                <textarea class="form-control" id="bio" rows="3" name="bio"><?php echo $user->getBio(); ?></textarea>
                            </div>
                        </form>
                    </div>
                    <!-- Modal Footer -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="saveChanges" form="editProfileForm" name="EditProfile">Lưu thay đổi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    function previewAvatar(event) {
        const image = document.getElementById('avatarPreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result; // Set the image source to the file data URL
            };
            reader.readAsDataURL(file); // Read the file and trigger onload function
        }
    }

    function previewAvatarEdit(event) {
        const image = document.getElementById('avatarPreviewEdit');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result; // Set the image source to the file data URL
            };
            reader.readAsDataURL(file); // Read the file and trigger onload function
        }
    }

    function previewCover(event) {
        const image = document.getElementById('coverPreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result; // Set the image source to the file data URL
            };
            reader.readAsDataURL(file); // Read the file and trigger onload function
        }
    }

    function previewCoverEdit(event) {
        const image = document.getElementById('coverPreviewEdit');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result; // Set the image source to the file data URL
            };
            reader.readAsDataURL(file); // Read the file and trigger onload function
        }
    }
    // function previewImage(event, isCover = false) {
    //     const file = event.target.files[0]; // Lấy tệp được chọn
    //     const image = isCover ? document.querySelector('#cover_img') : document.querySelector('#avatar_img');
    //     const confirmButton = isCover ? document.getElementById('cover-confirm-button') : document.getElementById('confirm-button'); // Lấy nút xác nhận tương ứng

    //     if (file) {
    //         image.src = URL.createObjectURL(file); // Hiển thị ảnh xem trước
    //         confirmButton.style.display = 'block'; // Hiện nút xác nhận
    //     } else {
    //         alert("Vui lòng chọn một tệp ảnh."); // Thông báo nếu không có tệp nào được chọn
    //         confirmButton.style.display = 'none'; // Ẩn nút xác nhận nếu không có tệp
    //     }
    // }
</script>