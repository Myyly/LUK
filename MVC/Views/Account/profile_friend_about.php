<?php
//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../Controllers/Account.php';
// require_once '../../Process/profile_process.php';
$accountController = new AccountController();
$idUser = $_SESSION['idUser'];
$user = $accountController->findUserbyId($idUser);
$friendsList = $accountController->getFriendsList($idUser);
$user->getProfile_picture_url();
$activeTab = isset($_GET['sk']) ? $_GET['sk'] : 'posts';
$idUser = isset($_GET['id']) ? $_GET['id'] : '';
$idFriends = isset($_GET['idFriend']) ? $_GET['idFriend'] : '';
$friend = $accountController->findUserbyId($idFriends);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/assets/CSS/variables.css">


    <style>
        .intro-section {
            width: 100%;
            max-width: 500px;
            margin: auto;
            /* font-family: Arial, sans-serif; */
        }

        .intro-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            /* height: 100px; */
        }


        .intro-item i {
            color: gray;
            margin-right: 10px;
            
        }

        .intro-text {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .noInfo {
            color: var(--secondary-text);
        }
        .text-muted {
    font-size: 12px;
    margin-top: 6px;
    margin-left: 33px;
}
    </style>
</head>

<body>
    <form method="post">
        <div class="intro-section">
            <div class="intro-item">
                <div>
                    <?php
                    $bio = $friend->getBio();
                    ?> <i class="fas fa-info-circle" style="color: var(--primary-color);"></i>
                    <?php if ($bio != null) : ?>
                        <span class="intro-text"><?php echo $bio; ?></span>
                        <p class="text-muted">Tiểu sử</p>
                    <?php
                    else :
                    ?>
                        <span class="noInfo">Không có thông tin hiển thị</span>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Gender -->
            <div class="intro-item">
                <div id="genderDisplay">
                    <?php $gender = $friend->getGender(); ?>
                    <i class="fas fa-venus-mars" style="color: var(--primary-color);"></i>
                    <span class="intro-text"><?php echo $gender; ?></span>
                    <p class="text-muted">Gender</p>
                </div>
            </div>
            <!-- Date of Birth -->
            <div class="intro-item">
                <div id="DateOfBirthDisplay">
                    <?php $date_of_birth = $friend->getDate_of_birth(); ?>
                    <i class="fas fa-birthday-cake" style="color: var(--primary-color);"></i>
                    <span class="intro-text"><?php echo $date_of_birth ?></span>
                    <p class="text-muted">Date of Birth</p>
                </div>
            </div>
        </div>
    </form>
</body>

</html>
<script>
</script>