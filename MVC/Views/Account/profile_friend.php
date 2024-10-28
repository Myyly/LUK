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
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 850px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cover-photo {
            position: relative;
            width: 100%;
            height: 250px;
            background-color: #ddd;
        }

        .cover-photo img {
            width: 100%;
            height: auto;
        }

        .avatar-profile {
            position: absolute;
            top: 230px;
            left: 10%;
            transform: translateX(-50%);
            z-index: 1;
        }

        .avatar-profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .profile-info {
            padding-top: 100px;
            text-align: center;
        }

        .user-details {
            text-align: left;
            padding-left: 170px;
            margin-top: -95px;
        }

        .add-friend-btn,
        .message-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            margin-right: 10px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .add-friend-btn:hover,
        .message-btn:hover {
            background-color: var(--link-hover-color);
        }

        .profile-nav {
            margin: 20px 0;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            background-color: #fff;
        }

        .profile-nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            margin: 0;
        }

        .profile-nav li {
            margin: 0;
        }

        .nav-button {
            background: none;
            border: none;
            color: #65676b;
            font-size: 16px;
            cursor: pointer;
            padding: 15px 20px;
            transition: color 0.3s, border-bottom 0.3s;
            position: relative;
        }

        .nav-button:hover {
            color: var(--link-hover-color);
            border-radius: 5px;
            background: #d1d3d5;
        }

        .nav-button.active {
            color: var(--link-hover-color);
            font-weight: bold;
        }

        .nav-button.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 3px;
            background-color: var(--link-hover-color);
        }

        .content-section {
            padding: 20px;
        }

        .post {
            background-color: #f7f7f7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .post-header {
            display: flex;
            align-items: center;
        }

        .post-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .post-user p {
            margin: 0;
            font-size: 14px;
            color: #606770;
        }

        .post-content {
            margin: 10px 0;
            font-size: 16px;
            color: #1c1e21;
        }

        .post-footer {
            display: flex;
            justify-content: space-between;
        }

        .post-footer button {
            background-color: #e4e6eb;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
            color: #050505;
            display: flex;
            align-items: center;
        }

        .post-footer button:hover {
            background-color: #d1d3d5;
        }

        .post-footer button i {
            margin-right: 5px;
        }

        @media (max-width: 600px) {
            .profile-nav ul {
                flex-direction: column;
                align-items: center;
            }

            .profile-nav li {
                margin: 10px 0;
            }

            .nav-button {
                padding: 10px 0;
                width: 100%;
                text-align: center;
            }

            .avatar-profile {
                position: relative;
                margin: -75px auto 20px;
                text-align: center;
            }

            .avatar-profile img {
                margin: 0 auto;
            }

            .profile-info {
                padding: 80px 10px 20px 10px;
            }
        }

        /* Updated CSS for the avatar upload icon */
        .avatar-upload-icon {
            position: absolute;
            bottom: 20px;
            right: 20px; /* Adjust this to move the icon left */
            cursor: pointer;
            color: black;
            transition: transform 0.3s ease, font-size 0.3s ease;
        }

        /* Mobile-specific adjustments */
        @media (max-width: 600px) {
            .avatar-upload-icon {
                right: 15px; /* Mobile adjustment */
            }
        }
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
                <button class="add-friend-btn">Add Friend</button>
                <button class="message-btn">Message</button>
            </div>
        </div>

        <div class="profile-nav">
            <form method="GET" action="">
                <ul>
                    <li>
                        <button type="submit" name="tab" value="posts" class="nav-button <?php echo ($activeTab == 'posts') ? 'active' : ''; ?>">
                            <i class="fas fa-th"></i> Posts
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="tab" value="about" class="nav-button <?php echo ($activeTab == 'about') ? 'active' : ''; ?>">
                            <i class="fas fa-info-circle"></i> About
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="tab" value="friends" class="nav-button <?php echo ($activeTab == 'friends') ? 'active' : ''; ?>">
                            <i class="fas fa-user-friends"></i> Friends
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="tab" value="photos" class="nav-button <?php echo ($activeTab == 'photos') ? 'active' : ''; ?>">
                            <i class="fas fa-camera"></i> Photos
                        </button>
                    </li>
                    <li>
                        <button type="submit" name="tab" value="more" class="nav-button <?php echo ($activeTab == 'more') ? 'active' : ''; ?>">
                            <i class="fas fa-ellipsis-h"></i> More
                        </button>
                    </li>
                </ul>
            </form>
        </div>
        <div class="content-section">
    <?php
    // Debug: Kiểm tra giá trị của activeTab
    var_dump($activeTab); // Thêm dòng này để kiểm tra giá trị của activeTab

    // Hiển thị nội dung cho tab friends_all trước
    if ($activeTab == 'friends_all') {
        echo '<h4>Danh sách bạn bè</h4>'; // Tiêu đề cho danh sách bạn bè
        ?>
        <div class="friends-list mt-4">
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
            <!-- Thêm các bạn khác vào đây -->
        </div>
        <?php
    } elseif ($activeTab == 'friends') {
        // Nội dung cho tab Friends
        ?>
        <div class="friends-section">
            <h3>Bạn bè</h3>
            <div class="search-friends">
                <input type="text" class="form-control" placeholder="Tìm kiếm bạn bè">
            </div>

            <!-- Tabs lọc danh sách bạn bè -->
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
    } elseif ($activeTab == 'photos') {
        // Nội dung cho tab Photos
    } elseif ($activeTab == 'more') {
        // Nội dung cho tab More
    } else {
        // Nội dung cho các tab khác
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