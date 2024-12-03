<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử tìm kiếm</title>
    <style>
        .search-container {
            margin: 20px;
        }

        .search-input {
            width: 300px;
            padding: 10px;
            font-size: 16px;
        }

        .history-container {
    position: absolute;
    z-index: 10;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    max-height: 200px;
    overflow-y: auto;
    width: 320px; /* Phù hợp với ô input */
}


    .history-item {
    display: flex;
    justify-content: space-between; /* Đưa nội dung và nút "X" về hai phía */
    align-items: center; /* Căn giữa theo chiều dọc */
    padding: 8px;
    margin: 5px 0;
    border-radius: 4px;
    background-color: #f9f9f9;
    cursor: pointer;
    width: 400px;
}

.history-item:hover {
    background-color: #e9e9e9;
}

.item-container  {
    display: flex;
    align-items: center; /* Căn giữa ảnh và văn bản theo chiều dọc */
    gap: 8px; /* Khoảng cách giữa ảnh và văn bản */
}
.item-container img{
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
}

.history-item button:hover {
    color: darkred;
}

    </style>
</head>

<body>
    <div class="search-container">
        <input
            type="text"
            id="searchInput"
            class="search-input"
            placeholder="Nhập từ khóa tìm kiếm..."
            onkeypress="handleKeyPress(event)" />
        <button onclick="saveSearch()">Tìm kiếm</button>
    </div>
    <div class="history-container" id="historyContainer" style="display: none;">
    <h3>Lịch sử tìm kiếm:</h3>
    <div id="historyList"></div>
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

        latestHistory.reverse().forEach((item, index) => {
            const historyItem = document.createElement('div');
            historyItem.classList.add('history-item');

            const itemContainer = document.createElement('div');
            itemContainer.classList.add('item-container');

            const itemImg = document.createElement('img');
            itemImg.src = '/assets/emotions/tichcuc.png'; // Đường dẫn ảnh
            itemImg.alt = 'icon';
            itemImg.classList.add('history-icon');
            itemContainer.appendChild(itemImg);

            const itemText = document.createElement('span');
            itemText.textContent = item;
            itemText.onclick = () => alert(`Bạn đã chọn: ${item}`);
            itemContainer.appendChild(itemText);

            historyItem.appendChild(itemContainer);

            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = 'X';
            deleteBtn.onclick = () => deleteSearchItem(item);
            historyItem.appendChild(deleteBtn);

            historyList.appendChild(historyItem);
        });
    }

    function saveSearch() {
        const searchInput = document.getElementById('searchInput');
        const searchValue = searchInput.value.trim();

        if (searchValue) {
            let history = JSON.parse(localStorage.getItem('searchHistory')) || [];
            if (!history.includes(searchValue)) {
                history.push(searchValue);
                localStorage.setItem('searchHistory', JSON.stringify(history));
                loadSearchHistory();
            }
            searchInput.value = '';
        } else {
            alert('Vui lòng nhập từ khóa!');
        }
    }

    function deleteSearchItem(item) {
        let history = JSON.parse(localStorage.getItem('searchHistory')) || [];
        history = history.filter(historyItem => historyItem !== item);
        localStorage.setItem('searchHistory', JSON.stringify(history));
        loadSearchHistory();
    }

    function handleKeyPress(event) {
        if (event.key === 'Enter') {
            saveSearch();
        }
    }

    document.getElementById('searchInput').addEventListener('focus', () => toggleHistory(true));
    document.getElementById('searchInput').addEventListener('blur', () => setTimeout(() => toggleHistory(false), 200));

    loadSearchHistory();
</script>
