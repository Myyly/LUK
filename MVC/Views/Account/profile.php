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
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux</title>
    <link rel="icon" href="/assets/images/LuxLogo.png" type="image/png">
    <link rel="stylesheet" href="/assets/CSS/variables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            background-color: var( --primary-color);
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
            background-color: var( --link-hover-color);
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
            color :var( --link-hover-color);
            border-radius: 5px;
            background: #d1d3d5;
        }

        .nav-button.active {
            color: var( --link-hover-color);;
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
            background-color:var( --link-hover-color);
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
            .avatar-upload-icon {
    position: absolute;
    bottom: 10px; /* Adjust as needed */
    right: 10px; /* Adjust as needed */
    cursor: pointer; /* Change cursor to pointer */
    color: white; /* Color of the icon */
    font-size: 24px; /* Size of the icon */
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
    <img src="<?php echo $user->getProfile_picture_url(); ?>" alt="Profile Picture">
    <label for="avatar-upload" class="avatar-upload-icon">
        <i class="fas fa-camera"></i> <!-- Change this to any icon you prefer -->
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
                        <button type="submit" name="tab" value="" class="nav-button <?php echo ($activeTab == 'posts') ? 'active' : ''; ?>">
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
            if ($activeTab == '') {

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