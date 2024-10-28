<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux</title>
    <link rel="icon" href="/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="/assets/CSS/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<!-- <style>
    /* Styles for the header and navbar */

    /* Navbar icons styling */
    .nav-icons {
        display: flex;
        align-items: center;
    }

    .nav-icons .icon {
        margin-left: 15px;
        font-size: 22px; 
        color: #606770;
        text-decoration: none;
    }

     .nav-icons .icon:hover {
        color: #1877f2;
    }

    .nav-icons .avatar {
        display: flex;
        align-items: center;
        margin-left: 15px;
    }

    .nav-icons .avatar img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .nav-icons .avatar span {
        font-size: 16px;
        color: #333;
    } */
     /* Search bar */
      .header .search {
        flex: 1;
        display: flex;
        justify-content: center;
        position: relative;
    }

    .header .search input[type="text"] {
        width: 350px;
        padding: 10px 40px 10px 20px;
        font-size: 16px;
        border-radius: 20px;
        border: 1px solid #ccc;
        outline: none;
        background-color: #f0f2f5;
    }

    .header .search i {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        color: #606770;
    } 
</style>
<body>

        <div class="nav-icons">
            <a href="#" class="icon"><i class="fas fa-home"></i></a>
            <a href="#" class="icon"><i class="fas fa-tv"></i></a>
            <a href="#" class="icon"><i class="fas fa-users"></i></a>
            <a href="#" class="icon"><i class="fas fa-comment-alt"></i></a>
            <a href="#" class="icon"><i class="fas fa-bell"></i></a>
            
</div>

        </div>
    </div> 

    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Bạn bè</a></li>
            <li><a href="#"><i class="fas fa-clock"></i> Kỷ niệm</a></li>
            <li><a href="#"><i class="fas fa-save"></i> Đã lưu</a></li>
            <li><a href="#"><i class="fas fa-users-cog"></i> Nhóm</a></li>
            <li><a href="#"><i class="fas fa-video"></i> Video</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
    <div class="stories">
            <div class="story">Story 1</div>
            <div class="story">Story 2</div>
            <div class="story">Story 3</div>
            <div class="story">Story 4</div>
        </div>
        <!-- Posts -->
        <div class="posts">
            <div class="post">
                <h3>SGUni Photography Club</h3>
                <p>SGU tôi yêu 💙🍀</p>
                <img src="image1.jpg" alt="Post image">
            </div>
        </div>
        
    </div>
</body>
</html>
  <script>
    function toggleDropdown() {
    const dropdownMenu = document.querySelector('.dropdown-menu');
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.avatar img')) {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        }
    }
}

 </script> -->