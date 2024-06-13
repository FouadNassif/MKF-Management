document.addEventListener('DOMContentLoaded', function () {
    function closeNotification() {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }
    setTimeout(closeNotification, 5000);
});

function deleteCookiesOnLogout(){
    document.cookie = "Cart-item" + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}
