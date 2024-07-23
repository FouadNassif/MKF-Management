let cartCode = "";
let totalPrice = 0;

async function init() {
    if (!getCookie("Cart-item")) {
        setCookie("Cart-item", JSON.stringify([]), 30); // Expire after 30 Dasys
    }
    await getAllItems();
}

function addItemToCart(ref) {
    const id = ref.getAttribute("data-itemId");
    let itemQuantity = document.getElementById("item-quantity").value;
    addOrUpdateCartItem('Cart-item', id, itemQuantity);
}

async function getAllItems() {
    const token = document.querySelector(`meta[name="csrf-token"]`).getAttribute("content");

    const response = await fetch("/getItems", {
        method: "POST",
        body: JSON.stringify({
            getAllItems: "true",
        }),
        headers: {
            "X-CSRF-TOKEN": token,
            "Content-type": "application/json",
        },
    });

    if (!response.ok) {
        throw new Error("Failed to checkout");
    }

    const ALLITEMS = await response.json();
    const CookiesItems = JSON.parse(getCookie("Cart-item"));
    for (let i = 0; i < CookiesItems.length; i++) {
        for (let j = 0; j < ALLITEMS.length; j++) {
            if (CookiesItems[i][0] == ALLITEMS[j]['id']) {
                cartCode += showItemCartCard(ALLITEMS[j], CookiesItems[i][1]);
                break;
            }
        }
    }

    document.getElementById("test").innerHTML = cartCode;
    document.getElementById("totalPrice").textContent = totalPrice.toFixed(2);
}



function showItemCartCard(item, quant) {
    let imageURL =`${item['imageURL']}`;
    totalPrice += item['price'] * quant;
    return `
    <div class="flex justify-between border-2 border-Primary p-2 rounded-xl my-5">
        <div class="">
            <p class="text-xl">${item['name']}</p>
            <p class="text-gray-400">${item['description']}</p>
            <br>
            <div class="flex items-center h-fit">
                <button class="bg-Primary text-white px-2" data-itemId="${item['id']}" data-itemPrice="${item['price']}" onclick="decrement(this)" type="button">-</button>
                <input type="text" size="4" class="border-2 border-Primary outline-none text-center rounded-md mx-1" value="${quant}" id="inputItem${item['id']}">
                <button class="bg-Primary text-white px-2" data-itemId="${item['id']}" data-itemPrice="${item['price']}" onclick="increment(this)" type="button">+</button>
                <button onclick="deleteItemCart(${item['id']})" type="button"><img src="http://127.0.0.1:8000/assets/svg/Delete.svg" class="w-8"></button>
                <p class="text-xl">Price: ${item['price']}</p> <p> Total Price : <span id="totalPriceTxt${item['id']}">${(item['price'] * quant).toFixed(2)}</span> </p>
            </div>
        </div>
        <img src="${imageURL}" class="w-40">
    </div>`;
}

function deleteItemCart(itemId) {
    const CookiesItems = JSON.parse(getCookie("Cart-item"));
    const itemIndex = CookiesItems.findIndex(item => item[0] == itemId);
    if (itemIndex !== -1) {
        CookiesItems.splice(itemIndex, 1);
        setCookie("Cart-item", JSON.stringify(CookiesItems), 30);
        window.location.href = "/user/cart";
    } else {
        console.log("Item not found");
    }
}

function increment(ref) {
    let itemId = ref.getAttribute("data-itemId");
    let inputItemQuantity = document.getElementById(`inputItem${itemId}`);
    let cartItems = JSON.parse(getCookie("Cart-item"));

    let itemIndex = cartItems.findIndex(item => item[0] == itemId);

    if (itemIndex !== -1) {
        cartItems[itemIndex][1] = Number(cartItems[itemIndex][1]) + 1;
        inputItemQuantity.value = cartItems[itemIndex][1];
        setCookie("Cart-item", JSON.stringify(cartItems), 30);

        let totalPriceTxtElement = document.getElementById(`totalPriceTxt${itemId}`);
        let itemPrice = parseFloat(ref.getAttribute("data-itemPrice"));
        let totalPriceTxt = parseFloat(totalPriceTxtElement.textContent) + itemPrice;
        totalPriceTxtElement.textContent = totalPriceTxt.toFixed(2);
        totalPrice += itemPrice;
        document.getElementById("totalPrice").textContent = totalPrice.toFixed(2);
    }
}

function decrement(ref) {
    let itemId = ref.getAttribute("data-itemId");
    let inputItemQuantity = document.getElementById(`inputItem${itemId}`);
    let cartItems = JSON.parse(getCookie("Cart-item"));

    let itemIndex = cartItems.findIndex(item => item[0] == itemId);

    if (itemIndex !== -1) {
        if (inputItemQuantity.value > 1) {
            cartItems[itemIndex][1] = Number(cartItems[itemIndex][1]) - 1;
            inputItemQuantity.value = cartItems[itemIndex][1];
            setCookie("Cart-item", JSON.stringify(cartItems), 30);

            let totalPriceTxtElement = document.getElementById(`totalPriceTxt${itemId}`);
            let itemPrice = parseFloat(ref.getAttribute("data-itemPrice"));
            let totalPriceTxt = parseFloat(totalPriceTxtElement.textContent) - itemPrice;
            totalPriceTxtElement.textContent = totalPriceTxt.toFixed(2);

            totalPrice -= itemPrice;
            document.getElementById("totalPrice").textContent = totalPrice.toFixed(2);
        }
    }
}

function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
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

function addOrUpdateCartItem(cookieName, itemId, quantity) {
    let existingData = getCookie(cookieName);
    let cartItems = existingData ? JSON.parse(existingData) : [];

    const index = cartItems.findIndex(item => item[0] === itemId);

    if (index !== -1) {
        cartItems[index][1] = quantity;
    } else {
        cartItems.push([itemId, quantity]);
    }
    setCookie(cookieName, JSON.stringify(cartItems), 30); // 30 days expiry
}

init();