<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_DIR', dirname(__DIR__));
require_once BASE_DIR . '/Controllers/AccountController.php';
require_once BASE_DIR . '/Controllers/CommentController.php';
require_once BASE_DIR . '/Controllers/PostController.php';
require_once BASE_DIR . '/Controllers/PostImageController.php';


$commentController = new CommentController();
$accountController = new AccountController();
$postController =new PostController();
$postImageController = new PostImageController();

$idUser = $_SESSION['idUser'];
$user = $accountController->findUserbyId($idUser);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["UpdateAvatar"])) {
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $newAvatar = $_FILES['avatar'];
            if ($newAvatar['error'] === UPLOAD_ERR_OK) {
                $maxFileSize = 2 * 1024 * 1024;
                $fileSize = $newAvatar['size'];
                if ($fileSize > $maxFileSize) {
                    echo "Tệp quá lớn. Vui lòng chọn tệp nhỏ hơn 2MB.";
                } else {
                    $tmpName = $newAvatar['tmp_name'];
                    $imageData = file_get_contents($tmpName);
                    if (!empty($imageData)) {
                        if ($accountController->updateAvatar($idUser, $imageData)) {
                            // $successDisplayed = true;
                            echo '<script>';
                            echo 'setTimeout(function() {';
                            echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '";';
                            echo '}, 300);';
                            echo '</script>';
                        } else {
                            echo "Cập nhật thất bại.";
                        }
                    } else {
                        echo "Có lỗi xảy ra khi tải lên hình ảnh mới.";
                    }
                }
            } else {
                echo "Có lỗi xảy ra khi tải lên hình ảnh mới.";
            }
        } else {
            $currentAvatar = $user->getProfile_picture_url();
            if ($accountController->updateAvatar($idUser, $currentAvatar)) {
                echo '<script>';
                echo 'setTimeout(function() {';
                echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '";';
                echo '}, 300);';
                echo '</script>';
            } else {
                echo "Cập nhật thất bại.";
            }
        }
    }
    if (isset($_POST["UpdateCover"])) {
        if (isset($_FILES['cover'])  && $_FILES['cover']['error'] !== UPLOAD_ERR_NO_FILE) {
            $newCover = $_FILES['cover'];
            if ($newCover['error'] === UPLOAD_ERR_OK) {
                $maxFileSize = 2 * 1024 * 1024;
                $fileSize = $newCover['size'];
                if ($fileSize > $maxFileSize) {
                    echo "Tệp quá lớn. Vui lòng chọn tệp nhỏ hơn 2MB.";
                } else {
                    $tmpName = $newCover['tmp_name'];
                    $imageData = file_get_contents($tmpName);
                    if (!empty($imageData)) {
                        if ($accountController->updateCover($idUser, $imageData)) {
                            // $successDisplayed = true;
                            echo '<script>';
                            echo 'setTimeout(function() {';
                            echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '";';
                            echo '}, 300);';
                            echo '</script>';
                        } else {
                            echo "Cập nhật thất bại.";
                        }
                    } else {
                        echo "Có lỗi xảy ra khi tải lên hình ảnh mới.";
                    }
                }
            } else {
                echo "Có lỗi xảy ra khi tải lên hình ảnh mới.";
            }
        } else {
            $currentCover = $user->getCover_photo_url();
            if ($accountController->updateCover($idUser, $currentCover)) {
                echo '<script>';
                echo 'setTimeout(function() {';
                echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '";';
                echo '}, 300);';
                echo '</script>';
            } else {
                echo "Cập nhật thất bại.";
            }
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["EditProfile"])) {
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $newAvatar = $_FILES['avatar'];
            $tmpNameA = $newAvatar['tmp_name'];
            $imageDataA = file_get_contents($tmpNameA);
        } else {
            $imageDataA = $user->getProfile_picture_url();
        }

        if (isset($_FILES['cover']) && $_FILES['cover']['error'] !== UPLOAD_ERR_NO_FILE) {
            $newCover = $_FILES['cover'];
            $tmpNameC = $newCover['tmp_name'];
            $imageDataC = file_get_contents($tmpNameC);
        } else {
            $imageDataC = $user->getCover_photo_url();
        }
        $bio = $_POST["bio"];
        if (!empty($imageDataA) && !empty($imageDataC)) {
            if ($accountController->updateUserProfile($idUser, $imageDataA, $imageDataC, $bio)) {
                $successDisplayed = true;
                echo '<script>';
                echo 'setTimeout(function() {';
                echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '";';
                echo '}, 300);';
                echo '</script>';
            } else {
                echo "Cập nhật thất bại.";
            }
        } else {
            echo "Có lỗi xảy ra khi tải lên hình ảnh mới.";
        }
    }
    if (isset($_POST["Unfriend"])) {
        $friend_id = $_POST["friend_id"];
        $accountController->unfriend($idUser, $friend_id);
        echo '<script>';
        echo 'setTimeout(function() {';
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=friends_all";';
        echo '}, 300);';
        echo '</script>';
    }
    if (isset($_POST["saveBio"])) {
        $bio = $_POST["bioTextArea"];
        echo $bio;
        $phoneNumber = $user->getPhone_numberl();
        $email = $user->getEmail();
        $gender = $user->getGender();
        $dateOfBirth = $user->getDate_of_birth();
        $accountController->updateUserInfo($idUser, $bio, $phoneNumber, $email, $gender, $dateOfBirth);
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=about";';
        echo '</script>';
    }
    if (isset($_POST["savePhone"])) {
        $bio = $user->getBio();
        $phoneNumber = $_POST["phone"];
        $email = $user->getEmail();
        $gender = $user->getGender();
        $dateOfBirth = $user->getDate_of_birth();
        $accountController->updateUserInfo($idUser, $bio, $phoneNumber, $email, $gender, $dateOfBirth);
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=about";';
        echo '</script>';
    }
    if (isset($_POST["saveGender"])) {
        $bio = $user->getBio();
        $phoneNumber = $user->getPhone_numberl();
        $email = $user->getEmail();
        $gender = $_POST["genderSelect"];
        $dateOfBirth = $user->getDate_of_birth();
        $accountController->updateUserInfo($idUser, $bio, $phoneNumber, $email, $gender, $dateOfBirth);
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=about";';
        echo '</script>';
    }
    if (isset($_POST["saveDate"])) {
        $bio = $user->getBio();
        $phoneNumber = $user->getPhone_numberl();
        $email = $user->getEmail();
        $gender = $user->getGender();
        $dateOfBirth = $_POST["dob"];
        $accountController->updateUserInfo($idUser, $bio, $phoneNumber, $email, $gender, $dateOfBirth);
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=about";';
        echo '</script>';
    }
    if (isset($_POST["cancelBio"]) || isset($_POST["cancelPhoneButton"]) || isset($_POST["cancelGenderButton"]) || isset($_POST["cancelDateButton"])) {
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=about";';
        echo '</script>';
    }
    if (isset($_POST["btnCreatePost"])) {
        if (!empty($_FILES['images']['name'][0])) { // Kiểm tra file upload
            echo '<pre>';
            print_r($_FILES['images']);
            echo '</pre>';
        } else {
            echo "Không có file nào được tải lên.";
        }
    }
        // $content = $_POST["PostContent"] ?? ''; // Nội dung bài viết
        // $emotion_id = $_POST["id_icon"] ?? null; // Icon cảm xúc
        // date_default_timezone_set('Asia/Ho_Chi_Minh');
        // $created_at = (new DateTime())->format('Y-m-d H:i:s');
    
        // try {
        //     // Tạo bài đăng và lấy postId
        //     $postId = $postController->CreatePost($idUser, $content, $created_at, $emotion_id);
    
        //     // Kiểm tra nếu có ảnh được tải lên
        //     if (!empty($_FILES['images']['tmp_name'][0])) {
        //         foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        //             $fileTmpName = $_FILES['images']['tmp_name'][$key];
        //             $fileName = $_FILES['images']['name'][$key];
    
        //             try {
        //                 // Đọc dữ liệu ảnh
        //                 $imageData = file_get_contents($fileTmpName);
        //                 if ($imageData === false) {
        //                     throw new Exception("Error reading file: " . $fileName);
        //                 }
    
        //                 // Thêm ảnh vào cơ sở dữ liệu
        //                 $postImageController->AddPostImage($postId, $imageData);
        //                 echo "Uploaded: $fileName<br>"; // Debug: Hiển thị ảnh đã upload
        //             } catch (Exception $e) {
        //                 echo "Error adding image: " . $fileName . ". " . $e->getMessage();
        //             }
        //         }
        //     }
    
        //     // Chuyển hướng tới trang profile
        //     echo '<script>window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=posts";</script>';
        // } catch (Exception $e) {
        //     echo "Error: " . $e->getMessage();
        // }
    
    
    if (isset($_POST["btnCloseModal"])) {
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=posts";';
        echo '</script>';
    }
    if (isset($_POST["btnDeletePost"])) {
        $post_id = $_POST["post_id"];
        $postController->deletePost($post_id);
        echo '<script>';
        echo '    window.location.href = "/MVC/Views/Profile/profile.php?id=' . $idUser . '&sk=posts";';
        echo '</script>';
    }
    
}
