<?php
$data = [
    'username' => 'User from PHP',
    'message' => 'Hello from PHP!',
];

// Gửi dữ liệu tới server Node.js qua HTTP API
$options = [
    'http' => [
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => json_encode($data),
    ],
];

$context  = stream_context_create($options);
$result = file_get_contents('http://localhost:3000/send-message', false, $context);

echo $result;
?>