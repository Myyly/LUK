<?php
// Đảm bảo rằng yêu cầu là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu JSON từ body của yêu cầu
    $data = json_decode(file_get_contents('php://input'), true);

    // Kiểm tra xem dữ liệu có hợp lệ không
    if ($data && isset($data['name']) && isset($data['email'])) {
        // Phản hồi thành công
        echo json_encode([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => $data
        ]);
    } else {
        // Nếu dữ liệu không hợp lệ
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid data. Name and email are required.'
        ]);
    }
} else {
    // Nếu không phải là yêu cầu POST
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
}
?>