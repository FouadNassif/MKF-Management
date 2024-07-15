document.addEventListener('DOMContentLoaded', function () {
    setTimeout(closeNotification, 5000);
});

function closeNotification() {
    const notification = document.getElementById('notification');
    if (notification) {
        notification.style.display = 'none';
    }
}

function deleteCookiesOnLogout() {
    document.cookie = "Cart-item" + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}
