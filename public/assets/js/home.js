async function showItemModal(ref) {
    document.getElementById("modalCon").innerHTML = '';
    const itemId = ref.getAttribute("data-itemId");
    const token = document
        .querySelector(`meta[name="csrf-token"]`)
        .getAttribute("content");

    const response = await fetch("/getItems", {
        method: "POST",
        body: JSON.stringify({
            itemId: itemId,
        }),
        headers: {
            "X-CSRF-TOKEN": token,
            "Content-type": "application/json",
        },
    });

    if (!response.ok) {
        throw new Error("Failed to checkout");
    }

    const item = await response.json();
    renderItemModal(item[0])
}

function renderItemModal(item) {
    let imageURL = item['imageURL'] ? `http://127.0.0.1:8000/storage/itemImage/${item['imageURL']}` : '';
    let modalContent = `
        <div>
            <button onclick="closeModal()"><img src="http://127.0.0.1:8000/assets/svg/Close.svg"></button>
            <img src="${imageURL}">
            <h1>${item['name']}</h1>
            <p>${item['description']}</p>
            <div class="modalButtons">
                <div>
                    <button onclick="homeItemDecrement()">-</button>
                    <input type="number" id="item-quantity" value="1">
                    <button onclick="homeItemIncrement()">+</button>
                </div>
                <button onclick="addItemToCart(this)" data-itemId="${item['id']}">Add To Cart</button>
            </div>
        </div>
    `;

    const modalContainer = document.getElementById("modalCon");
    modalContainer.className = "modalCon";
    modalContainer.innerHTML = modalContent;
}

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
    window.location.href = "/";
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
    if (CookiesItems.length >= 1) {
        for (let i = 0; i < CookiesItems.length; i++) {
            for (let j = 0; j < ALLITEMS.length; j++) {
                if (CookiesItems[i][0] == ALLITEMS[j]['id']) {
                    cartCode += showItemCartCard(ALLITEMS[j], CookiesItems[i][1]);
                    break;
                }
            }
        }
    } else {
        cartCode += emptyCart();
    }

    document.getElementById("test").innerHTML = cartCode;
    document.getElementById("totalPrice").textContent = totalPrice.toFixed(2);
}

function emptyCart(){
    return `
    <div class="bg-white">
                    <img src="http://127.0.0.1:8000/assets/img/emptyCart.jpeg" alt="">
                    <h1 class="font-bold text-xl">Your cart is empty.</h1>
                    <p class="text-gray-400">Add some delicious items from our menu to get started!</p>
                </div>`
}

function showItemCartCard(item, quant) {
    let imageURL = item['imageURL'] ? `http://127.0.0.1:8000/storage/itemImage/${item['imageURL']}` : "";
    totalPrice += item['price'] * quant;
    return `
        <div class="flex border-2 border-Primary p-2 rounded-xl mt-2 bg-white">
            <img src="${imageURL}" class="w-20 rounded-lg h-16">
            <div class="ml-5">
                <p class="text-lg">${item['name']}
                <p class="text-xs font-mono">Single Price: ${item['price']}</p>
                </p>
                <br>
                <div class="flex items-center h-fit">
                    <button class="text-Primary px-2 text-2xl" data-itemId="${item['id']}"
                        data-itemPrice="${item['price']}" onclick="decrement(this)" type="button"><img
                            src="http://127.0.0.1:8000/assets/svg/Minus.svg" class="w-6"></button>
                    <input type="text" size="1" readonly class="outline-none text-center text-lg"
                        value="${quant}" id="inputItem${item['id']}">
                    <button class=" px-2" data-itemId="${item['id']}" data-itemPrice="${item['price']}"
                        onclick="increment(this)" type="button"><img src="http://127.0.0.1:8000/assets/svg/Plus.svg"
                            class="w-6"></button>
                    <button onclick="deleteItemCart(${item['id']})" type="button"><img
                            src="http://127.0.0.1:8000/assets/svg/Delete.svg" class="w-6"></button>
                    <p class=""> Total Price :<span id="totalPriceTxt${item['id']}">${(item['price'] * quant).toFixed(2)}</span>
                    </p>
                </div>
            </div>
        </div>`;
}


function deleteItemCart(itemId) {
    const CookiesItems = JSON.parse(getCookie("Cart-item"));
    const itemIndex = CookiesItems.findIndex(item => item[0] == itemId);
    if (itemIndex !== -1) {
        CookiesItems.splice(itemIndex, 1);
        setCookie("Cart-item", JSON.stringify(CookiesItems), 30);
        window.location.href = "/";
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
    setCookie(cookieName, JSON.stringify(cartItems), 30);
}

document.getElementById('cartButton').addEventListener('click', function () {
    const cart = document.getElementById('cart');
    let butImg = document.getElementById("butImgCart");
    if (cart.classList.contains('translate-x-full')) {
        cart.classList.remove('translate-x-full');
        cart.classList.add('translate-x-0');
        butImg.src = "http://127.0.0.1:8000/assets/svg/CartClose.svg";
    } else {
        cart.classList.remove('translate-x-0');
        cart.classList.add('translate-x-full');
        butImg.src = "http://127.0.0.1:8000/assets/svg/CartOpen.svg";

    }
});

// Close cart if clicked outside
document.addEventListener('click', function (event) {
    const cart = document.getElementById('cart');
    const cartButton = document.getElementById('cartButton');
    if (!cart.contains(event.target) && !cartButton.contains(event.target)) {
        if (!cart.classList.contains('translate-x-full')) {
            cart.classList.add('translate-x-full');
            butImg.src = "http://127.0.0.1:8000/assets/svg/CartClose.svg";
        }
    }
});

function homeItemIncrement() {
    let itemQuantity = document.getElementById("item-quantity");
    itemQuantity.value++;
}

function homeItemDecrement() {
    let itemQuantity = document.getElementById("item-quantity");
    if (itemQuantity.value > 1) {
        itemQuantity.value--;
    }
}

function closeModal() {
    const modalContainer = document.getElementById("modalCon");
    modalContainer.className = "";
    modalContainer.innerHTML = "";
}

document.getElementById('scrollLeft').addEventListener('click', function () {
    document.getElementById('categoryContainer').scrollBy({
        top: 0,
        left: -250,
        behavior: 'smooth'
    });
});

document.getElementById('scrollRight').addEventListener('click', function () {
    document.getElementById('categoryContainer').scrollBy({
        top: 0,
        left: 250,
        behavior: 'smooth'
    });
});

init();