<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lux</title>
    <link rel="icon" href="/images/LuxLogo.png" type="image/png"> 
    <link rel="stylesheet" href="/CSS/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
<?php include 'header.php'; ?>
    <div class="profile-container">
        <!-- Cover Photo -->
        <div class="cover-photo">
            <img src="https://via.placeholder.com/850x250" alt="Cover Photo">
        </div>

        <!-- Profile Info Section -->
        <div class="profile-info">
            <!-- Avatar -->
            <div class="avatar-profile">
                <img src="https://via.placeholder.com/150" alt="Profile Picture">
            </div>

            <!-- User Details -->
            <div class="user-details">
                <h2>Mỹ Ly</h2>
                <p>100 friends</p>
                <button class="add-friend-btn">Add Friend</button>
                <button class="message-btn">Message</button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="profile-nav">
            <ul>
                <li><a href="#">Posts</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Friends</a></li>
                <li><a href="#">Photos</a></li>
                <li><a href="#">More</a></li>
            </ul>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <!-- Example Post -->
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
                    <button>Like</button>
                    <button>Comment</button>
                    <button>Share</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
