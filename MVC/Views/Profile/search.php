<style>
    .history-item {
        display: flex;
        justify-content: space-between;
        /* Đưa các phần tử về 2 phía */
        align-items: center;
        /* Căn giữa theo chiều dọc */
        padding: 8px;
        margin: 5px 0;
        border-radius: 4px;
        cursor: pointer;
        width: 300px;

    }

    .history-item:hover {
        background-color: #e9e9e9;
    }

    .history-item button {
        /* background-color: #f9f9f9;
        width: 24px;
        height: 24px;
        border: none;
        margin-left: 200px; */
    }

    .history-item button:hover {
        background-color: #f9f9f9;
        width: 24px;
        height: 24px;
        border: none;
        border-radius: 50%;
    }

    .item-container {
        display: flex;
        align-items: center;
        /* Căn giữa ảnh và văn bản theo chiều dọc */
        gap: 8px;
        /* Khoảng cách giữa ảnh và văn bản */
    }

    .item-container img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .history-item button {
        background-color: transparent;
        border: none;
        color: red;
        font-size: 16px;
        cursor: pointer;
        margin-left: 50px;
    }

    .history-container {
        position: absolute;
        z-index: 10;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        max-height: 600px;
        overflow-y: auto;
        width: 320px;
        top: 50px;


    }

    .history-container h3 {
        font-size: 16px;
        font-weight: bold;
        margin-top: 20px;
        /* position: absolute; */
        margin-left: 20px;

    }
</style>

<div class="search"
    data-id-user="<?php echo htmlspecialchars($idUser); ?>">
    <input
        type="text"
        id="searchInput"
        placeholder="Tìm kiếm trên Luk"
        onkeypress="handleKeyPress(event)">
    <div class="history-container" id="historyContainer" style="display: none;">
        <h3>Mới đây</h3>
        <div id="historyList"></div>
    </div>
</div>
<script>
    function toggleHistory(show) {
        const historyContainer = document.getElementById('historyContainer');
        historyContainer.style.display = show ? 'block' : 'none';
    }

    function loadSearchHistory() {
    const history = JSON.parse(localStorage.getItem('searchHistory')) || [];
    const historyList = document.getElementById('historyList');
    historyList.innerHTML = ''; // Xóa danh sách hiện tại
    const latestHistory = history.slice(-8); // Lấy 8 phần tử cuối
    latestHistory.reverse().forEach((user) => { // user thay vì item
        const historyItem = document.createElement('div');
        historyItem.classList.add('history-item');

        // Tạo liên kết bao bọc ảnh và tên
        const userLink = document.createElement('a');
        userLink.href = `/MVC/Views/Profile/profile_friend.php?idFriend=${user.id}`; // Điều chỉnh URL theo yêu cầu của bạn
        userLink.style.textDecoration = 'none';
        userLink.style.color = 'black'; // Loại bỏ gạch dưới mặc định

        const itemContainer = document.createElement('div');
        itemContainer.classList.add('item-container');

        // Ảnh đại diện
        const itemImg = document.createElement('img');
        itemImg.src = user.profile_picture_url
            ? 'data:image/jpeg;base64,' + user.profile_picture_url
            : 'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360';
        itemImg.alt = 'icon';
        itemImg.classList.add('history-icon');
        itemContainer.appendChild(itemImg);

        // Tên người dùng
        const itemText = document.createElement('span');
        itemText.textContent = user.full_name; // Hiển thị tên người dùng
        itemContainer.appendChild(itemText);

        // Thêm itemContainer vào userLink
        userLink.appendChild(itemContainer);

        // Thêm userLink vào historyItem
        historyItem.appendChild(userLink);

        // Nút xóa
        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'X';
        deleteBtn.onclick = (e) => {
            e.stopPropagation(); // Ngăn chặn hành vi mặc định của liên kết
            deleteSearchItem(user); // Xóa đối tượng người dùng khỏi lịch sử
        };
        historyItem.appendChild(deleteBtn);

        // Thêm vào danh sách
        historyList.appendChild(historyItem);
    });
}

    function saveSearch(user) {
        if (user) {
            let history = JSON.parse(localStorage.getItem('searchHistory')) || [];
            const userExist = history.some(historyItem => historyItem.id === user.id);
            if (!userExist) {
                history.push(user);
                localStorage.setItem('searchHistory', JSON.stringify(history));
                loadSearchHistory(); // Tải lại lịch sử tìm kiếm
            }
        }
    }

    function deleteSearchItem(item) {
        let history = JSON.parse(localStorage.getItem('searchHistory')) || [];
        history = history.filter(historyItem => historyItem.id !== item.id);
        localStorage.setItem('searchHistory', JSON.stringify(history));
        loadSearchHistory(); // Tải lại danh sách mà không ẩn container
    }

    function handleKeyPress(event) {
        if (event.key === 'Enter') {
            saveSearch();
        }
    }
    //////////////////////////////////SEARCH
    document.addEventListener("DOMContentLoaded", function() {
        const searchElement = document.querySelector(".search");
        const idUser = searchElement.getAttribute("data-id-user");
        document.getElementById("searchInput").addEventListener("input", function() {
            const keyword = this.value.trim();
            const historyContainer = document.getElementById('historyContainer');
            const historyList = document.getElementById('historyList');

            // Ẩn lịch sử khi bắt đầu nhập từ khóa
            if (keyword !== "") {
                // Khi có từ khóa, thực hiện tìm kiếm và hiển thị kết quả
                const idUser = document.querySelector(".search").getAttribute("data-id-user");

                fetch("/MVC/Process/search_bar_process.php", {
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
                        console.log('Dữ liệu từ server:', data);
                        historyList.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(user => {
                                const historyItem = document.createElement('div');
                                historyItem.classList.add('history-item');

                                const itemContainer = document.createElement('div');
                                itemContainer.classList.add('item-container');

                                // Tạo thẻ <a> và thiết lập href
                                const userLink = document.createElement('a');
                                userLink.href = `/MVC/Views/Profile/profile_friend.php?idFriend=${user.user_id}`; // Điều chỉnh URL theo yêu cầu của bạn
                                userLink.style.textDecoration = 'none';
                                userLink.style.color = 'black'; // Loại bỏ gạch dưới mặc định

                                const itemImg = document.createElement('img');
                                itemImg.src = user.profile_picture_url ? 'data:image/jpeg;base64,' + user.profile_picture_url : 'https://img.freepik.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3383.jpg?w=360';
                                itemImg.alt = 'icon';
                                itemImg.classList.add('history-icon');
                                itemContainer.appendChild(itemImg);

                                const itemText = document.createElement('span');
                                itemText.textContent = user.full_name;
                                itemContainer.appendChild(itemText);

                                userLink.appendChild(itemContainer);


                                userLink.addEventListener('click', function(event) {
                                    event.preventDefault(); // Ngừng hành động mặc định (chuyển trang)
                                    saveSearch({
                                        id: user.user_id,
                                        full_name: user.full_name,
                                        profile_picture_url: user.profile_picture_url
                                    });
                                    setTimeout(function() {
                                        window.location.href = userLink.href;
                                    }, 100);
                                });

                                historyItem.appendChild(userLink);
                                historyList.appendChild(historyItem);
                            });
                        } else {
                            historyList.innerHTML = '<div>Không tìm thấy kết quả.</div>';
                        }
                    })
                    .catch(error => console.error("Error:", error));
            } else {
                // Khi không có từ khóa, hiển thị lịch sử tìm kiếm
                historyContainer.style.display = 'block';
                loadSearchHistory();
            }
        });
    });
    //////////////////////////////////////////
    document.getElementById('searchInput').addEventListener('focus', () => toggleHistory(true));

    document.getElementById('searchInput').addEventListener('blur', () => {
        setTimeout(() => {
            // Kiểm tra nếu không focus vào input và không có mục lịch sử nào thì ẩn container
            if (!document.getElementById('searchInput').matches(':focus')) {
                toggleHistory(false);
            }
        }, 200); // Thêm khoảng delay nhỏ để đảm bảo việc mất focus được xử lý
    });

    loadSearchHistory();
</script>