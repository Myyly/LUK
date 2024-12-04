function handleNotification(idUser, data) {
    const normalizedSenderId = String(data.sender_id).trim();
    const normalizedUserId = String(idUser).trim();
    if (normalizedSenderId !== normalizedUserId) {
        notificationCount++;
        document.getElementById('notificationCount').textContent = notificationCount;
    }
}
function handleNotificationBell() {
    // const normalizedSenderId = String(data.sender_id).trim();
    // const normalizedUserId = String(idUser).trim();
    // if (normalizedSenderId !== normalizedUserId) {
        
   // }
}

