document.addEventListener('DOMContentLoaded', function () {
    function closeNotification() {
        const notification = document.getElementById('notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }
    setTimeout(closeNotification, 5000);
});


function countCartItem() {
    let cartItemsCounter = document.getElementById("cartItemsCounter");
    if (JSON.parse(getCookie("Cart-item")).length >=1) {
        cartItemsCounter.textContent = JSON.parse(getCookie("Cart-item")).length;
    } else {
        cartItemsCounter.textContent = "0";
    }
}
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}
countCartItem()

function deleteCookiesOnLogout(){
    document.cookie = "Cart-item" + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}
