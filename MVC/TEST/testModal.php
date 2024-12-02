<script>
document.getElementById("friendSearch").addEventListener("input", function() {
        const keyword = this.value;
        const idUser = <?php echo json_encode($idUser); ?>; // ID người dùng hiện tại
        const friendsListContainer = document.querySelector(".friends-list .row");

        if (keyword.trim() !== "") {
            // Gửi AJAX request đến server để tìm kiếm bạn bè theo từ khóa
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
                .then(response => response.json())
                .then(data => {
                    // Xóa danh sách bạn bè hiện tại
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
            // Nếu không có từ khóa, lấy lại danh sách bạn bè gốc
            friendsListContainer.innerHTML = ""; // Xóa danh sách bạn bè hiện tại

            // Thêm danh sách bạn bè gốc
            originalFriendsList.forEach(friend => {
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
        }
    });
    </script>