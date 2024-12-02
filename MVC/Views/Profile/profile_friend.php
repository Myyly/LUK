<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/AccountController.php';
$accountController = new AccountController();
$idUser = $_SESSION['idUser'];
$activeTab = isset($_GET['sk']) ? $_GET['sk'] : 'posts';
$idFriend = isset($_GET['idFriend']) ? $_GET['idFriend'] : '';
$friend = $accountController->findUserbyId($idFriend);
$friendsList = $accountController->getFriendsList($idFriend);
$status = $accountController->checkFriendshipStatus($idUser, $idFriend);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png">
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <link rel="stylesheet" href="/assets/CSS/profile_friend.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<style>
</style>

<body>
    <?php include '../header.php'; ?>
    <div class="profile-container">
        <div class="cover-photo">
            <?php
            $cover = $friend->getCover_photo_url();
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
                $img = $friend->getProfile_picture_url();
                if ($img) {
                    $base64Image = base64_encode($img);
                    $avatarSrc = 'data:image/jpeg;base64,' . $base64Image;
                    echo '<img id="avatar_img" class="avatar" src="' . $avatarSrc . '" alt="">';
                } else {
                    echo '<img id="avatar_img" class="avatar" src="https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360" alt="">';
                }
                ?>
            </div>
        </div>
        <div class="profile-info">
            <div class="user-details">
                <div class="user-info">
                    <h2><?php echo $friend->getFull_name(); ?></h2>
                    <?php
                    $MutualFriendsCount = $accountController->getMutualFriendsCount($idUser, $idFriend);
                    ?>
                    <p>
                        <?php
                        if ($MutualFriendsCount > 0) {
                            echo $MutualFriendsCount . " bạn chung";
                        }
                        ?>
                    </p>
                </div>
                <div class="user-actions">
                    <form method="POST" action="/MVC/Process/profile_friend_process.php">
                        <?php
                        if ($status == null):
                        ?>
                            <input type="hidden" name="friend_id" value="<?php echo $idFriend; ?>">
                            <button type="submit" class="add-friend-btn" name="addFriend">
                                <i class="fa-solid fa-plus fa-lg" style="color: #ffffff;margin-right: 8px;"></i>
                                Theo dõi</button>
                            <button class="message-friend-btn-new" type="submit" name="message">
                                <i class="fa-solid fa-comment-dots fa-lg" style="color: #000000;;margin-right: 8px;"></i>
                                Nhắn tin</button>
                        <?php else: ?>
                            <button type="button" class="unfriend-btn" data-bs-toggle="modal" data-bs-target="#unfriend">
                                <i class="fa-solid fa-check fa-lg" style="color: #000000;margin-right: 8px"></i>
                                Đang theo dõi
                            </button>
                            <?php
                            $name = $accountController->findUserbyId($idFriend)->getFull_name();
                            $friendAvatar = $accountController->findUserbyId($idFriend)->getProfile_picture_url();
                            if ($friendAvatar) {
                                $friendAvatarSrc= 'data:image/jpeg;base64,' . base64_encode($friendAvatar);
                            } else {
                                $friendAvatarSrc = "https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360";
                            }
                            ?>
                           <button class="message-friend-btn" type="button" name="message" 
    onclick="openChatDetail(<?php echo $idFriend; ?>, '<?php echo addslashes($name); ?>', '<?php echo $friendAvatarSrc; ?>')">
    <i class="fa-solid fa-comment-dots fa-lg" style="color: #ffffff;margin-right: 8px;"></i>
    Nhắn tin
</button>
                        <?php endif; ?>
                        <!-- ///////////////////////////////////////CHAT BOX/////////////////////////////// -->
                        <div id="chatDetail" class="chat-detail" style="display: none;">
                            <div class="chat-header-detail">
                                <img src="" alt="Avatar" class="chat-avatar">
                                <span class="chat-header-username"><strong></strong></span>
                            </div>
                            <div class="chat-messages" id="chatMessages">
                                <p>Đang tải tin nhắn...</p>
                            </div>
                            <div class="chat-input">
                                <input type="text" placeholder="Nhập tin nhắn" id="message">
                                <button type="button" class="btn-send-message" onclick="sendMessage()">Gửi</button>
                            </div>
                        </div>
                        <!-- ///////////////////////////////////////CHAT BOX/////////////////////////////// -->
                    </form>
                </div>
            </div>
        </div>
        <div class="profile-nav">
            <form method="GET" action="">
                <input type="hidden" name="idFriend" value="<?php echo $idFriend; ?>">
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
                    <div class="search-friends"
                        data-id-user="<?php echo htmlspecialchars($idUser); ?>"
                        data-id-friend="<?php echo htmlspecialchars($idFriend); ?>">
                        <input type="text" class="form-control" id="friendSearch_fr" placeholder="Tìm kiếm bạn bè">
                    </div>
                    <script src="/MVC/Views/Profile/search_friend.js"></script>
                    <form method="GET" action="">
                        <input type="hidden" name="idFriend" value="<?php echo $idFriend; ?>">
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
                                        <?php if ($friend['friend_id'] == $idUser): ?>
                                            <a href="profile.php?id=<?php echo $idFriend ?>">
                                                <img src="<?php echo $friend_avaSrc ?>"
                                                    alt="<?php echo htmlspecialchars($friend['full_name']); ?>"
                                                    class="friend-avatar rounded-circle me-3"
                                                    style="width: 60px; height: 60px;">
                                            </a>
                                        <?php else: ?>
                                            <a href="profile_friend.php?idFriend=<?php echo $friend['friend_id']; ?>">
                                                <img src="<?php echo $friend_avaSrc ?>"
                                                    alt="<?php echo htmlspecialchars($friend['full_name']); ?>"
                                                    class="friend-avatar rounded-circle me-3"
                                                    style="width: 60px; height: 60px;">
                                            </a>
                                        <?php endif; ?>
                                        <div>
                                            <h5 class="mb-0"><?php echo htmlspecialchars($friend['full_name']); ?></h5>

                                            <?php
                                            if ($idUser != $friend['friend_id']):
                                                $MutualFriendsCount = $accountController->getMutualFriendsCount($idUser, $friend['friend_id']);
                                            ?>
                                                <p class="text-muted mb-0"><?php
                                                                            if ($MutualFriendsCount > 0) { // Kiểm tra nếu có bạn chung
                                                                                echo $MutualFriendsCount . " bạn chung";
                                                                            }
                                                                            ?></p>
                                            <?php else: ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <form method="POST" action="/MVC/Process/profile_friend_process.php">
                                        <input type="hidden" name="friend_id" value="<?php echo $friend['friend_id']; ?>">
                                        <input type="hidden" name="friend_id_be" value="<?php echo $idFriend; ?>">
                                        <?php
                                        $status = $accountController->checkFriendshipStatus($idUser, $friend['friend_id']);
                                        if ($friend['friend_id'] == $idUser): ?>
                                        <?php elseif ($status === null): ?>
                                            <button type="submit" class="btn btn-danger btn-sm" name="Follow">
                                                <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
                                                Theo dõi
                                            </button>
                                        <?php elseif ($status === "accepted"): ?>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#unfriendModal_<?php echo $friend['friend_id']; ?>">
                                                <i class="fa-solid fa-check" style="color: #ffffff;"></i>
                                                Đang theo dõi
                                            </button>
                                        <?php endif; ?>
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
                                                        <input type="hidden" name="friend_id" value="<?php echo $friend['friend_id']; ?>">
                                                        <input type="hidden" name="friend_id_be" value="<?php echo $idFriend; ?>">
                                                        <button type="submit" class="btn btn-danger" name="Unfriend_list">Xác nhận</button>
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
                    <?php include 'profile_friend_about.php'; ?>
                </div>
            <?php
            } else if ($activeTab == 'posts') {
                include 'post_content.php';

            ?>

            <?php
            } else {
            ?>

            <?php } ?>
        </div>
    </div>
    <div class="modal fade" id="unfriend" tabindex="-1" aria-labelledby="unfriendModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unfriendModalLabel">
                        Huỷ theo dõi <strong><?php echo  $friend->getFull_name(); ?></strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn hủy theo dõi với <strong><?php echo  $friend->getFull_name(); ?></strong> không?
                </div>
                <div class="modal-footer">
                    <form method="POST" action="/MVC/Process/profile_friend_process.php">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger" name="Unfriend">Xác nhận</button>
                        <input type="hidden" name="friend_id" value="<?php echo $idFriend; ?>">

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php include('../Message/chat_detail.php'); ?>
