
<?php 
function formatTimeAgo($created_at) {
    $timestamp = strtotime($created_at);
    $current_time = time();
    $time_diff = $current_time - $timestamp;

    if ($time_diff < 60) {
        return "$time_diff giây trước";
    } elseif ($time_diff < 3600) {
        $minutes = floor($time_diff / 60);
        return "$minutes phút trước";
    } elseif ($time_diff < 86400) {
        $hours = floor($time_diff / 3600);
        return "$hours giờ trước";
    } elseif ($time_diff < 120 * 3600) {
        return "Hôm qua lúc " . date("H:i", $timestamp);
    } elseif ($time_diff < 2592000) {
        return date("d/m", $timestamp);
    } elseif ($time_diff < 31536000) {
        return date("m/Y", $timestamp);
    } else {
        return date("d/m/Y", $timestamp);
    }
}
?>