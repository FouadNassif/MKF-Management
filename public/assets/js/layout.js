document.addEventListener('DOMContentLoaded', function () {
    function closeNotification() {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }

    // Automatically close the notification after 5 seconds
    setTimeout(closeNotification, 5000);
});