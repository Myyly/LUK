<?php
require __DIR__ . '/vendor/autoload.php';

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

// Khởi tạo biến cho thông báo
$messageSent = '';
$errorMessage = '';

// Kiểm tra nếu có dữ liệu POST gửi đến
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST["message"];
    $phoneNumber = $_POST["phoneNumber"];

    // Cấu hình API
    $apiURL = "v3v4yv.api.infobip.com";
    $apiKey = "66c686e88401b3de669baa7cea14f7b1-60d1aa3f-9f1c-463a-bf64-434f739f13a8";

    $configuration = new Configuration(host: $apiURL, apiKey: $apiKey);
    $api = new SmsApi(config: $configuration);

    // Tạo đối tượng tin nhắn
    $destination = new SmsDestination(to: $phoneNumber);
    $theMessage = new SmsTextualMessage(
        destinations: [$destination],
        text: $message,
        from: "My Ly"
    );

    // Tạo yêu cầu gửi tin nhắn
    $request = new SmsAdvancedTextualRequest(messages: [$theMessage]);

    // Gửi tin nhắn
    try {
        $response = $api->sendSmsMessage($request);
        $messageSent = 'SMS Message sent successfully!';
    } catch (Exception $e) {
        $errorMessage = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send SMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
        }
        label {
            margin-bottom: 5px;
        }
        input, textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            margin: 15px 0;
            color: #d9534f;
        }
        .success {
            color: #5cb85c;
        }
    </style>
</head>
<body>

<h1>Send SMS</h1>

<!-- Hiển thị thông báo nếu có -->
<?php if ($messageSent): ?>
    <div class="message success"><?= $messageSent ?></div>
<?php endif; ?>
<?php if ($errorMessage): ?>
    <div class="message"><?= $errorMessage ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="phoneNumber">Phone Number:</label>
    <input type="text" id="phoneNumber" name="phoneNumber" required>
    
    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>
    
    <input type="submit" value="Send SMS">
</form>

</body>
</html>
