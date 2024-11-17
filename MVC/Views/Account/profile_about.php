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

        .intro-edit-buttons {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .intro-edit-buttons i {
            color: #007bff;
            cursor: pointer;
            margin-left: 0;
        }

        .intro-add {
            color: #007bff;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 10px;
        }

        .intro-add i {
            margin-right: 10px;
        }

        .intro-add button {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            /* font-weight: bold; */
            display: flex;
            align-items: center;
        }

        .intro-item button {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .intro-item button i {
            margin-right: 5px;
        }

        .intro-edit-buttons i {
            margin-left: 10px;
            cursor: pointer;
        }

        #bioInputBox {
            margin-top: 10px;


        }

        #bioTextArea {
            width: 500px;
            margin-bottom: 10px;
            display: block;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background-color: #e9ecef;
            color: #000;
            font-size: 16px;
            appearance: none;
            margin-right: -90px;
        }

        #saveBioButton,
        #cancelBioButton {
            display: inline-block;
            margin-right: 4px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 3px;
            padding: 5px 10px;
            cursor: pointer;
        }

        #cancelBioButton {
            background-color: var(--button-submit-hover);
        }

        #saveGenderButton,
        #cancelGenderButton {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            border-radius: 3px;
            padding: 5px 10px;
            cursor: pointer;
            /* margin-left: 50px;  */
            /* Khoảng cách bên trái cho nút */
        }

        #saveDateButton,
        #cancelDateButton,
        #savePhoneButton,
        #cancelPhoneButton {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            border-radius: 3px;
            padding: 5px 10px;
            cursor: pointer;
            /* margin-left: 50px;  */
        }

        .intro-edit-buttons {
            display: flex;
            align-items: center;
        }

        .gender-combobox {
            display: block;
            width: 400px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background-color: #e9ecef;
            color: #000;
            font-size: 16px;
            appearance: none;
            margin-right: -90px;
            margin-bottom: 10px;
        }

        .date-input {
            display: block;
            width: 400px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background-color: #e9ecef;
            color: #000;
            font-size: 16px;
            appearance: none;
            margin-right: -90px;
            margin-bottom: 10px;
        }

        .phone-input {
            display: block;
            width: 400px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background-color: #e9ecef;
            color: #000;
            font-size: 16px;
            appearance: none;
            margin-right: -90px;
            margin-bottom: 10px;
        }

        .text-muted {
            font-size: 12px;
            margin-top: 6px;
            margin-left: 33px;
        }
    </style>
</head>

<body>
    <form method="post" action="../../Process/profile_process.php">
        <div class="intro-section">
            <div class="intro-item">
                <div>
                    <?php
                    $bio = $user->getBio();
                    if ($bio != null) :
                    ?>
                        <div id="bioDisplay">
                            <i class="fas fa-info-circle" style="color: var(--primary-color);"></i>
                            <span class="intro-text"><?php echo $bio; ?></span>
                            <p class="text-muted">Tiểu sử</p>
                            <div class="intro-edit-buttons" style="position: relative;">
                                <i class="fas fa-globe" id="ed_bio" style="position: absolute; top: -35px; left: 395px; color: #007bff;"></i>
                                <button type="button" id="editBio">
                                    <i class="fa-solid fa-pen-to-square fa-lg" style="color: #525252;position: absolute; top: -30px; left: 445px;"></i>
                                </button>
                            </div>
                        </div>
                        <div id="bioInputBox" style="display: none;">
                            <textarea id="bioTextArea" placeholder="Nhập tiểu sử của bạn..." name="bioTextArea"><?php echo htmlspecialchars($bio); ?></textarea>
                            <button type="submit" id="saveBioButton" name="saveBio">Lưu</button>
                            <button type="submit" id="cancelBioButton" name="cancelBio">Huỷ</button>
                        </div>
                    <?php
                    else :
                    ?>
                        <button type="button" id="addBioButton">
                            <i class="fas fa-plus-circle" style="color: var(--primary-color);"></i>
                            Thêm tiểu sử
                        </button>
                        <div id="bioInputBox" style="display: none;">
                            <textarea id="bioTextArea" placeholder="Nhập tiểu sử của bạn..." name="bioTextArea"></textarea>
                            <button type="submit" id="saveBioButton" name="saveBio">Lưu</button>
                            <button type="submit" id="cancelBioButton" name="cancelBio">Huỷ</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php $method = $user->getSignup_type(); ?>
            <!-- Mobile -->
            <div class="intro-item">
                <div>
                    <?php
                    $phone = $user->getPhone_numberl();
                    $registrationMethod = $user->getSignup_type(); 
                    if ($phone != null):
                    ?>
                        <div id="mobileDisplay">
                            <i class="fas fa-phone" style="color: var(--primary-color);" id="ed_phone"></i>
                            <span class="intro-text"><?php echo $phone; ?></span>
                            <p class="text-muted">Mobile</p>
                            <?php if ($registrationMethod !== 'phone'): 
                            ?>
                                <div class="intro-edit-buttons" style="position: relative;">
                                    <i class="fas fa-globe" style="position: absolute; top: -35px; left: 395px; color: #007bff;"></i>
                                    <button type="button" name="editPhone" id="editPhone">
                                        <i class="fa-solid fa-pen-to-square fa-lg" style="color: #525252;position: absolute; top: -30px; left: 445px;"></i>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div id="inputPhone" style="display: none;">
                            <input type="text" class="phone-input" id="phone" name="phone" value="<?php echo $phone ?>">
                            <button type="submit" id="savePhoneButton" name="savePhone">Lưu</button>
                            <button type="submit" id="cancelPhoneButton" name="cancelPhoneButton" style="background-color: var(--button-submit-hover);">Huỷ</button>
                        </div>
                    <?php else: ?>
                        <button type="button" id="addPhone">
                            <i class="fas fa-plus-circle" style="color: var(--primary-color);"></i>
                            Thêm số điện thoại
                        </button>
                        <div id="inputPhone" style="display: none;">
                            <input type="text" class="phone-input" id="phone" name="phone" placeholder="Nhập số điện thoại">
                            <button type="submit" id="savePhoneButton" name="savePhone">Lưu</button>
                            <button type="submit" id="cancelPhoneButton" name="cancelPhoneButton" style="background-color: var(--button-submit-hover);">Huỷ</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Email -->
            <div class="intro-item">
    <div>
        <?php
        $registrationMethod = $user->getSignup_type(); // Get registration type (phone/email)
        $email = $user->getEmail(); // Get user's email
        if ($email != null):
        ?>
            <i class="fas fa-envelope" style="color: var(--primary-color);"></i>
            <span class="intro-text"><?php echo $email; ?></span>
            <p class="text-muted">Email</p>
            <?php if ($registrationMethod !== 'email'): // Hide the edit button if signup_type is 'email' ?>
                <div class="intro-edit-buttons" style="position: relative;">
                    <i class="fas fa-globe" style="position: absolute; top: -35px; left: 400px; color: #007bff;"></i>
                    <button type="submit" name="">
                        <i class="fa-solid fa-pen-to-square fa-lg" style="color: #525252;position: absolute; top: -30px; left: 445px;"></i>
                    </button>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <button>
                <i class="fas fa-plus-circle" style="color: var(--primary-color);"></i>
                Thêm email
            </button>
        <?php endif; ?>
    </div>
</div>

            <!-- Gender -->
            <div class="intro-item">
                <div id="genderDisplay">
                    <?php $gender = $user->getGender(); ?>
                    <i class="fas fa-venus-mars" style="color: var(--primary-color);"></i>
                    <span class="intro-text"><?php echo $gender; ?></span>
                    <p class="text-muted">Gender</p>
                </div>
                <div class="intro-edit-buttons" style="width: 300px;">
                    <i class="fas fa-globe" style="margin-left: 285px;" id="ed_gender"></i>
                    <button type="button" name="editGender" id="edit">
                        <i class="fa-solid fa-pen-to-square fa-lg" style="color: #525252;"></i>
                    </button>
                    <div id="cbbGender" style="display: none;">
                        <select id="genderSelect" name="genderSelect" class="gender-combobox">
                            <option value="Nam" <?php echo $gender === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo $gender === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khác" <?php echo $gender === 'Khác' ? 'selected' : ''; ?>>Khác</option>
                        </select>
                        <button type="submit" id="saveGenderButton" name="saveGender">Lưu</button>
                        <button type="submit" id="cancelGenderButton" name="cancelGenderButton" style=" background-color: var(--button-submit-hover);">Huỷ</button>
                    </div>
                </div>
            </div>
            <!-- Date of Birth -->
            <div class="intro-item">
                <div id="DateOfBirthDisplay">
                    <?php $date_of_birth = $user->getDate_of_birth(); ?>
                    <i class="fas fa-birthday-cake" style="color: var(--primary-color);"></i>
                    <span class="intro-text"><?php echo $date_of_birth ?></span>
                    <p class="text-muted">Date of Birth</p>
                </div>
                <div class="intro-edit-buttons" style="width: 300px;">
                    <i class="fas fa-globe" id="ed_Date"></i>
                    <button type="button" name="editDatOfBirth" id="editDate">
                        <i class="fa-solid fa-pen-to-square fa-lg" style="color: #525252;"></i>
                    </button>
                    <div id="cbbDate" style="display:none;">
                        <label for="dob">Ngày tháng năm sinh:</label>
                        <input type="date" id="dob" name="dob" class="date-input" required value="<?php echo $date_of_birth; ?>">
                        <button type="submit" id="saveDateButton" name="saveDate">Lưu</button>
                        <button type="submit" id="cancelDateButton" name="cancelDateButton" style=" background-color: var(--button-submit-hover);">Huỷ</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>
<script>
    // bio
    document.addEventListener("DOMContentLoaded", function() {
        const addBioButton = document.getElementById('addBioButton');
        const editBioButton = document.getElementById('editBio');
        const inputBioDiv = document.getElementById('bioInputBox');
        const bioDisplayDiv = document.getElementById('bioDisplay');
        const edBioIcon = document.getElementById('ed_bio');
        if (addBioButton) {
            addBioButton.addEventListener('click', function() {
                inputBioDiv.style.display = 'block';
                if (editBioButton) editBioButton.style.display = 'none';
                if (edBioIcon) edBioIcon.style.display = 'none';
                if (bioDisplayDiv) bioDisplayDiv.style.display = 'none';
                addBioButton.style.display = 'none';
            });
        }
        if (editBioButton) {
            editBioButton.addEventListener('click', function() {
                inputBioDiv.style.display = 'block';
                editBioButton.style.display = 'none';
                if (edBioIcon) edBioIcon.style.display = 'none';
                if (bioDisplayDiv) bioDisplayDiv.style.display = 'none';
            });
        }
    });
    //Gender
    document.getElementById('edit').addEventListener('click', function() {
        document.getElementById('cbbGender').style.display = 'block';
        document.getElementById('edit').style.display = 'none';
        document.getElementById('ed_gender').style.display = 'none';
        document.getElementById('genderDisplay').style.display = 'none';
    });
    //date of birth
    document.getElementById('editDate').addEventListener('click', function() {
        document.getElementById('cbbDate').style.display = 'block';
        document.getElementById('editDate').style.display = 'none';
        document.getElementById('ed_Date').style.display = 'none';
        document.getElementById('DateOfBirthDisplay').style.display = 'none';

    });
    document.getElementById('cancelDateButton').addEventListener('click', function() {
        document.getElementById('cbbDate').style.display = 'none';
        document.getElementById('editDate').style.display = 'block';
        document.getElementById('ed_Date').style.display = 'block';
        document.getElementById('DateOfBirthDisplay').style.display = 'block';
    });
    //phone 
    document.addEventListener("DOMContentLoaded", function() {
        const addPhoneButton = document.getElementById('addPhone');
        const editPhoneButton = document.getElementById('editPhone');
        const inputPhoneDiv = document.getElementById('inputPhone');
        const mobileDisplayDiv = document.getElementById('mobileDisplay');
        const edPhoneIcon = document.getElementById('ed_phone');
        if (addPhoneButton) {
            addPhoneButton.addEventListener('click', function() {
                inputPhoneDiv.style.display = 'block';
                if (editPhoneButton) editPhoneButton.style.display = 'none';
                if (edPhoneIcon) edPhoneIcon.style.display = 'none';
                if (mobileDisplayDiv) mobileDisplayDiv.style.display = 'none';
                addPhoneButton.style.display = 'none';
            });
        }
        if (editPhoneButton) {
            editPhoneButton.addEventListener('click', function() {
                inputPhoneDiv.style.display = 'block';
                editPhoneButton.style.display = 'none';
                if (edPhoneIcon) edPhoneIcon.style.display = 'none';
                if (mobileDisplayDiv) mobileDisplayDiv.style.display = 'none';
            });
        }
    });
</script>