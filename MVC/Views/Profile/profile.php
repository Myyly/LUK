<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/MessageController.php';
require_once '../../Controllers/AccountController.php';

$accountController = new AccountController();
$messageController = new MessageController();
$idUser = $_SESSION['idUser'];
$activeTab = isset($_GET['sk']) ? $_GET['sk'] : 'posts';
// $idUser = isset($_GET['id']) ? $_GET['id'] : '';
$messages = $messageController->getConversations($idUser);

$user = $accountController->findUserbyId($idUser);
$friendsList = $accountController->getFriendsList($idUser);
$user->getProfile_picture_url();

//var_dump($user->getCover_photo_url()); 

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    .content-section {
        margin-left: 20px;
        /* Lùi vào 20px từ cạnh trái */
    }
</style>

<body>
    <?php include_once '../header.php'; ?>
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
                    echo '<img id="avatar_img" class="avatar" src="https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360" alt="">'; // Thay đường dẫn ảnh mặc định
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
                <p><?php echo  $total_friends . " người bạn" ?></p>
                <button class="edit-information-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fa-solid fa-pen-to-square fa-rotate-270 fa-lg" style="color: #000000; margin-right: 8px;"></i>
                    Chỉnh sửa trang cá nhân
                </button>
            </div>
        </div>
        <div class="profile-nav">
            <form method="GET" action="">
                <input type="hidden" name="id" value="<?php echo $idUser; ?>">
                <ul>
                    <li>
                        <button type="submit" name="sk" value="posts" class="nav-button <?php echo ($activeTab == 'posts') ? 'active' : ''; ?>">
                            <i class="fas fa-th"></i>
                            Bài viết
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
                        <input type="text" class="form-control" id="friendSearch" placeholder="Tìm kiếm bạn bè">
                    </div>

                    </form>
                    <form method="GET" action="">
                        <input type="hidden" name="id" value="<?php echo $idUser; ?>">
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
                    <div class="row">
                        <?php foreach ($friendsList as $friend): ?>
                            <div class="col-md-6 mb-3">
                                <div class="friend-item d-flex align-items-center justify-content-between p-2 border rounded">
                                    <div class="d-flex align-items-center">
                                        <?php $friend_ava = $friend['profile_picture_url'];
                                        if ($friend_ava) {
                                            $base64Image = base64_encode($friend_ava);
                                            $friend_avaSrc = 'data:image/jpeg;base64,' . $base64Image;
                                        } else {
                                            $friend_avaSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
                                        }
                                        ?>
                                        <a href="profile_friend.php?idFriend=<?php echo $friend['friend_id']; ?>">
                                            <img src="<?php echo $friend_avaSrc ?>"
                                                alt="<?php echo htmlspecialchars($friend['full_name']); ?>"
                                                class="friend-avatar rounded-circle me-3"
                                                style="width: 60px; height: 60px;">
                                        </a>
                                        <div>
                                            <h5 class="mb-0"><?php echo htmlspecialchars($friend['full_name']); ?></h5>
                                            <?php
                                            $MutualFriendsCount = $accountController->getMutualFriendsCount($idUser, $friend['friend_id']);
                                            ?>
                                            <p class="text-muted mb-0"><?php
                                                                        if ($MutualFriendsCount > 0) { // Kiểm tra nếu có bạn chung
                                                                            echo $MutualFriendsCount . " bạn chung";
                                                                        }
                                                                        ?></p>
                                        </div>
                                    </div>
                                    <form method="POST" action="/MVC/Process/profile_process.php">
                                        <input type="hidden" name="friend_id" value="<?php echo $friend['friend_id']; ?>">
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#unfriendModal_<?php echo $friend['friend_id']; ?>">
                                            <i class="fa-solid fa-check" style="color: #ffffff;"></i>
                                            Đang theo dõi
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="unfriendModal_<?php echo $friend['friend_id']; ?>" tabindex="-1" aria-labelledby="unfriendModalLabel_<?php echo $friend['friend_id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="unfriendModalLabel">
                                                            Huỷ theo dõi <?php echo htmlspecialchars($friend['full_name']); ?>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn hủy theo dõi với <?php echo htmlspecialchars($friend['full_name']); ?> không?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                        <!-- Form submit -->
                                                        <form method="POST" action="/MVC/Process/profile_process.php">
                                                            <input type="hidden" name="friend_id" value="<?php echo $friend['friend_id']; ?>">
                                                            <button type="submit" class="btn btn-danger" name="Unfriend">Xác nhận</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                    <?php include 'profile_about.php'; ?>
                </div>
            <?php
            } else if ($activeTab == 'posts') {
            ?>
                <?php include 'profile_post.php'; ?>

            <?php
            }
            ?>

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
                        <form id="avatarUploadForm" action="/MVC/Process/profile_process.php" method="POST" enctype="multipart/form-data">
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
                        <form id="coverUploadForm" action="/MVC/Process/profile_process.php" method="POST" enctype="multipart/form-data">
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
                        <form id="editProfileForm" action="/MVC/Process/profile_process.php" method="POST" enctype="multipart/form-data">
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

    document.getElementById("friendSearch").addEventListener("input", function() {
    const keyword = this.value.trim(); // Lấy giá trị từ ô input và loại bỏ khoảng trắng thừa
    const idUser = <?php echo json_encode($idUser); ?>; // ID người dùng hiện tại
    const friendsListContainer = document.querySelector(".friends-list .row");

    if (keyword !== "") {
        fetch("/MVC/Process/search_friends.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                idUser: idUser,
                keyword: keyword
            })
        })
        .then(response => response.json()) //// Chuyển đổi phản hồi thành JSON
        .then(data => {  // Xử lý dữ liệu đã phân tích
            // Xóa danh sách bạn bè hiện tại
            console.log(data); 
            friendsListContainer.innerHTML = "";
            // Thêm kết quả tìm kiếm vào danh sách bạn bè
            data.forEach(friend => {
                const friendHTML = `
                    <div class="col-md-6 mb-3">
                        <div class="friend-item d-flex align-items-center justify-content-between p-2 border rounded">
                            <div class="d-flex align-items-center">
                                <a href="profile_friend.php?idFriend=${friend.friend_id}">
                                    <img src="${friend.profile_picture_url ? `data:image/jpeg;base64,${friend.profile_picture_url}` : 'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360'}"
                                         alt="${friend.full_name}"
                                         class="friend-avatar rounded-circle me-3"
                                         style="width: 60px; height: 60px;">
                                </a>
                                <div>
                                    <h5 class="mb-0">${friend.full_name}</h5>
                                    <p class="text-muted mb-0">${friend.mutual_friends_count > 0 ? friend.mutual_friends_count + " bạn chung" : ""}</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#unfriendModal_${friend.friend_id}">
                                <i class="fa-solid fa-check" style="color: #ffffff;"></i> Đang theo dõi
                            </button>
                        </div>
                    </div>
                `;
                friendsListContainer.insertAdjacentHTML("beforeend", friendHTML);
            });
        })
        .catch(error => console.error("Error:", error));
    } else {
        // Nếu không có từ khóa tìm kiếm (tức là input bị xóa), lấy lại danh sách bạn bè gốc
        fetch("/MVC/Process/search_friends.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                idUser: idUser,
                keyword: null // Gửi giá trị null để lấy lại danh sách bạn bè gốc
            })
        })
        .then(response => response.json())
        .then(data => {
            // console.log(data); 
            friendsListContainer.innerHTML = "";
            data.forEach(friend => {
                const friendHTML = `
                    <div class="col-md-6 mb-3">
                        <div class="friend-item d-flex align-items-center justify-content-between p-2 border rounded">
                            <div class="d-flex align-items-center">
                                <a href="profile_friend.php?idFriend=${friend.friend_id}">
                                    <img src="${friend.profile_picture_url ? `data:image/jpeg;base64,${friend.profile_picture_url}` : 'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360'}"
                                         alt="${friend.full_name}"
                                         class="friend-avatar rounded-circle me-3"
                                         style="width: 60px; height: 60px;">
                                </a>
                                <div>
                                    <h5 class="mb-0">${friend.full_name}</h5>
                                    <p class="text-muted mb-0">${friend.mutual_friends_count > 0 ? friend.mutual_friends_count + " bạn chung" : ""}</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#unfriendModal_${friend.friend_id}">
                                <i class="fa-solid fa-check" style="color: #ffffff;"></i> Đang theo dõi
                            </button>
                        </div>
                    </div>
                `;
                friendsListContainer.insertAdjacentHTML("beforeend", friendHTML);
            });
        })
        .catch(error => console.error("Error:", error));
    }
});
</script>