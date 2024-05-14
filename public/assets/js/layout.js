document.addEventListener('DOMContentLoaded', function () {
    function closeNotification() {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }
    setTimeout(closeNotification, 5000);
});