document.addEventListener("DOMContentLoaded", function () {
    const searchFriendsElement = document.querySelector(".search-friends");
    const idUser = searchFriendsElement.getAttribute("data-id-user");
    const idFriend= searchFriendsElement.getAttribute("data-id-friend");
    document.getElementById("friendSearch_fr").addEventListener("input", function () {
        const keyword = this.value.trim();
        const friendsListContainer = document.querySelector(".friends-list .row");
        if (keyword !== "") {
            fetch("/MVC/Process/search.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    idUser: idUser,
                    keyword: keyword,
                    idFriend :idFriend
                })
            })
            .then(response => response.json())
            .then(data => {
                // Xóa danh sách bạn bè hiện tại
                friendsListContainer.innerHTML = "";
                // Thêm kết quả tìm kiếm
                data.forEach(friend => {
                    const friendshipStatus = friend.friendship_status === "null" ? null : friend.friendship_status;
                    console.log(friend.friendship_status); // Kiểm tra giá trị
                
                    const friendHTML = `
                        <div class="col-md-6 mb-3">
                            <div class="friend-item d-flex align-items-center justify-content-between p-2 border rounded">
                                <div class="d-flex align-items-center">
                                    <a href="${friend.friend_id === idUser ? `profile.php?id=${idFriend}` : `profile_friend.php?idFriend=${friend.friend_id}`}">
                                        <img src="${friend.profile_picture_url ? `data:image/jpeg;base64,${friend.profile_picture_url}` : 'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360'}"
                                             alt="${friend.full_name}"
                                             class="friend-avatar rounded-circle me-3"
                                             style="width: 60px; height: 60px;">
                                    </a>
                                    <div>
                                        <h5 class="mb-0">${friend.full_name}</h5>
                                        ${friend.friend_id !== idUser && friend.mutual_friends_count > 0 ? `<p class="text-muted mb-0">${friend.mutual_friends_count} bạn chung</p>` : ""}
                                    </div>
                                </div>
                                <form method="POST" action="/MVC/Process/profile_friend_process.php">
                                    <input type="hidden" name="friend_id" value="${friend.friend_id}">
                                    <input type="hidden" name="friend_id_be" value="${idFriend}">
                                    ${
                                        friendshipStatus === null
                                            ? `<button type="submit" class="btn btn-danger btn-sm" name="Follow">
                                                   <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Theo dõi
                                               </button>`
                                            : friendshipStatus === "accepted"
                                            ? `<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#unfriendModal_${friend.friend_id}">
                                                   <i class="fa-solid fa-check" style="color: #ffffff;"></i> Đang theo dõi
                                               </button>`
                                            : ""
                                    }
                                    <!-- Modal -->
                                    ${
                                        friend.friendship_status === "accepted"
                                            ? `<div class="modal fade" id="unfriendModal_${friend.friend_id}" tabindex="-1" aria-labelledby="unfriendModalLabel_${friend.friend_id}" aria-hidden="true">
                                                   <div class="modal-dialog">
                                                       <div class="modal-content">
                                                           <div class="modal-header">
                                                               <h5 class="modal-title" id="unfriendModalLabel_${friend.friend_id}">
                                                                   Huỷ theo dõi ${friend.full_name}
                                                               </h5>
                                                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                           </div>
                                                           <div class="modal-body">
                                                               Bạn có chắc chắn muốn hủy theo dõi với ${friend.full_name} không?
                                                           </div>
                                                           <div class="modal-footer">
                                                               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                               <input type="hidden" name="friend_id" value="${friend.friend_id}">
                                                               <input type="hidden" name="friend_id_be" value="${idFriend}">
                                                               <button type="submit" class="btn btn-danger" name="Unfriend_list">Xác nhận</button>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>`
                                            : ""
                                    }
                                </form>
                            </div>
                        </div>
                    `;
                
                    friendsListContainer.insertAdjacentHTML("beforeend", friendHTML);
                });
})
            .catch(error => console.error("Error:", error));
        }else {
            // Nếu không có từ khóa tìm kiếm (tức là input bị xóa), lấy lại danh sách bạn bè gốc
            fetch("/MVC/Process/search.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    idUser: idUser,
                    keyword: null, // Gửi giá trị null để lấy lại danh sách bạn bè gốc
                    idFriend :idFriend
                })
            })
            .then(response => response.json())
            .then(data => {
                friendsListContainer.innerHTML = "";
                data.forEach(friend => {
                    const friendHTML = `
                    <div class="col-md-6 mb-3">
                        <div class="friend-item d-flex align-items-center justify-content-between p-2 border rounded">
                            <div class="d-flex align-items-center">
                                <a href="${friend.friend_id === idUser ? `profile.php?id=${idFriend}` : `profile_friend.php?idFriend=${friend.friend_id}`}">
                                    <img src="${friend.profile_picture_url ? `data:image/jpeg;base64,${friend.profile_picture_url}` : 'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360'}"
                                         alt="${friend.full_name}"
                                         class="friend-avatar rounded-circle me-3"
                                         style="width: 60px; height: 60px;">
                                </a>
                                <div>
                                    <h5 class="mb-0">${friend.full_name}</h5>
                                    ${friend.mutual_friends_count > 0 ? `<p class="text-muted mb-0">${friend.mutual_friends_count} bạn chung</p>` : ""}
                                </div>
                            </div>
                            <form method="POST" action="/MVC/Process/profile_friend_process.php">
                                <input type="hidden" name="friend_id" value="${friend.friend_id}">
                                <input type="hidden" name="friend_id_be" value="${idFriend}">
                                ${
                                    friend.friend_id === idUser
                                        ? ""
                                        : friend.friendship_status === null
                                        ? `<button type="submit" class="btn btn-danger btn-sm" name="Follow">
                                               <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Theo dõi
                                           </button>`
                                        : friend.friendship_status === "accepted"
                                        ? `<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#unfriendModal_${friend.friend_id}">
                                               <i class="fa-solid fa-check" style="color: #ffffff;"></i> Đang theo dõi
                                           </button>`
                                        : ""
                                }
                                <!-- Modal -->
                                ${
                                    friend.friendship_status === "accepted"
                                        ? `<div class="modal fade" id="unfriendModal_${friend.friend_id}" tabindex="-1" aria-labelledby="unfriendModalLabel_${friend.friend_id}" aria-hidden="true">
                                               <div class="modal-dialog">
                                                   <div class="modal-content">
                                                       <div class="modal-header">
                                                           <h5 class="modal-title" id="unfriendModalLabel_${friend.friend_id}">
                                                               Huỷ theo dõi ${friend.full_name}
                                                           </h5>
                                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                       </div>
                                                       <div class="modal-body">
                                                           Bạn có chắc chắn muốn hủy theo dõi với ${friend.full_name} không?
                                                       </div>
                                                       <div class="modal-footer">
                                                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                           <input type="hidden" name="friend_id" value="${friend.friend_id}">
                                                           <input type="hidden" name="friend_id_be" value="${idFriend}">
                                                           <button type="submit" class="btn btn-danger" name="Unfriend_list">Xác nhận</button>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>`
                                        : ""
                                }
                            </form>
                        </div>
                    </div>
                `;
                    friendsListContainer.insertAdjacentHTML("beforeend", friendHTML);
                });
            })
            .catch(error => console.error("Error:", error));
        }
    });
});