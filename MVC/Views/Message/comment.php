<style>
    /* Modal Styling */
/* Modal Styling */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    width: 60%; /* Width of modal */
    max-height: 80%; /* Limit height */
    overflow-y: auto; /* Scrollable content */
}

.close-button {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close-button:hover {
    color: black;
}

textarea {
    width: 100%;
    height: 50px;
    margin-top: 10px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #0056b3;
}

.comments-list {
    margin-bottom: 20px;
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
}

.comment {
    padding: 10px;
    margin-bottom: 10px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
}
.comment span {
    font-weight: bold;
    display: block;
}


</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments in Modal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Button to open modal -->
    <button id="openModalButton">Open Comments</button>

    <!-- Modal -->
    <div id="commentModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeModalButton">&times;</span>
            <h2>Comments</h2>
            <!-- Comment List -->
            <div id="commentsContainer" class="comments-list"></div>
            <!-- Form to Add Comment -->
            <form id="commentForm">
                <textarea id="commentText" name="commentText" placeholder="Add your comment here..." required></textarea>
                <button type="submit">Add Comment</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

<script>
  // DOM Elements
const openModalButton = document.getElementById('openModalButton');
const closeModalButton = document.getElementById('closeModalButton');
const commentModal = document.getElementById('commentModal');
const commentForm = document.getElementById('commentForm');
const commentsContainer = document.getElementById('commentsContainer');

// Mock Data (Initial Comments)
let comments = [
    { id: 1, user: 'John Doe', text: 'This is a great post!' },
    { id: 2, user: 'Jane Smith', text: 'Thanks for sharing this.' },
];

// Function to Render Comments in Modal
function renderComments() {
    commentsContainer.innerHTML = ''; // Clear current comments
    comments.forEach(comment => {
        const commentDiv = document.createElement('div');
        commentDiv.classList.add('comment');
        commentDiv.innerHTML = `
            <span>${comment.user}</span>
            <p>${comment.text}</p>
        `;
        commentsContainer.appendChild(commentDiv);
    });
}

// Open the modal and render comments
openModalButton.addEventListener('click', () => {
    renderComments(); // Load comments into modal
    commentModal.style.display = 'block'; // Show modal
});

// Close the modal
closeModalButton.addEventListener('click', () => {
    commentModal.style.display = 'none'; // Hide modal
});

// Submit New Comment
commentForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const commentText = document.getElementById('commentText').value;
    
    if (commentText.trim() === '') return; // Skip empty comments

    // Simulate adding a new comment
    const newComment = {
        id: comments.length + 1,
        user: 'You', // Simulating current user
        text: commentText,
    };
    comments.push(newComment);

    // Update UI
    renderComments();
    commentForm.reset(); // Clear form
});


</script>