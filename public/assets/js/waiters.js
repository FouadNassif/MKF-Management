const svgURl = "/assets/svg/";
const imgURl = "/assets/img/";

async function getAllOrders() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/waiters/getAllOrder', {
        method: 'POST',
        body: JSON.stringify({ orderId: 1 }),
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-type': 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to checkout');
    }

    const orders = await response.json();
    let htmlCodeActive = "";
    let htmlCodeInactive = "";

    let waiterOrdersCookie = JSON.parse(getCookie("Waiter-Orders"));

    if (waiterOrdersCookie && waiterOrdersCookie.length >= 1) {
        // Render active orders
        waiterOrdersCookie.forEach(orderId => {
            let order = orders.find(order => order.id === orderId);
            if (order) {
                htmlCodeActive += renderActiveWaitersOrders(orderId, order, "border-Primary");
            }
        });
        // Render inactive orders
        orders.forEach(order => {
            if (!waiterOrdersCookie.includes(order.id)) {
                htmlCodeInactive += renderActiveWaitersOrders(order.id, order, "border-Danger");
            }
        });

    } else {
        // if the cookies is empty
        orders.forEach(order => {
            htmlCodeInactive += renderActiveWaitersOrders(order.id, order, "border-Danger");
        });
    }

    document.getElementById("allOrder").innerHTML = htmlCodeActive + htmlCodeInactive;
}


async function expandOrder(orderId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/waiter/getOrderById', {
        method: 'POST',
        body: JSON.stringify({ orderId: orderId }),
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-type': 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to checkout');
    }

    const items = await response.json();
    let orderContainer = document.getElementById(orderId);
    orderContainer.innerHTML = '';
    let borderColor = orderContainer.className.includes('border-Danger') ? 'border-Danger' : 'border-Primary'
    orderContainer.className = ''
    orderContainer.className = `border-2 ${borderColor} p-4 rounded-xl w-11/12 mt-3`

    let htmlCode = `
            <div class="flex justify-between">
                <p>Order ID: ${orderId}</p>
                <button class="py-1 px-3 bg-Primary text-white rounded-xl" onclick="goToPOS(${orderId})">POS</button>
            </div>
            <div class="text-Primary flex justify-between">
                <div class="text-center border-r-2 border-b-2 border-S w-full">Item Name</div>
                <div class="text-center border-r-2 border-b-2 border-S w-full">Quantity</div>
                <div class="text-center border-r-2 border-b-2 border-S w-full">Action</div>
            </div>
            <div id="orderItemsContainer" class="flex flex-col w-full">
    `;
    let Names = ""
    for (let i = 0; i < items.order.items.length; i++) {
        let itemId = items.order.items[i]['item_id'];
        let itemName = items.itemsName[itemId];
        Names += itemName + " ";
        let Quantity = items.order.items[i]['quantity'];

        htmlCode += `
            <div class="flex justify-between bg-Primary p-3 rounded-xl text-white mt-2 items-center">
                <div class="text-center w-full">
                    <p>${itemName}</p>
                </div>
                <div class="text-center w-full">
                    <p id="${itemId}quan">${Quantity}</p>
                </div>
                <div class="text-center w-full">
                    <button onclick="editItem(${itemId}, ${Quantity}, ${orderId})"><img class="w-8" src="${svgURl + 'Edit.svg'}" alt=""></button>
                </div>
            </div>
        `;
    }

    htmlCode += `
            </div>
            <div class="flex float-right mt-5">
                <button class="bg-Primary rounded-lg py-2 px-5 text-white" onclick="addOrderToWaiterOrCheckout(${orderId})">Checkout</button>
                <button class="mx-5" onclick="collapseOrder(${orderId}, '${Names}', this)"><img class="w-8" src="${svgURl + 'ArrowUp.svg'}" alt=""></button>
            </div>
        `;
    orderContainer.innerHTML += htmlCode;
}

async function editItem(itemId, quantity, orderId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/getItems', {
        method: 'POST',
        body: JSON.stringify({ itemId: itemId }),
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-type': 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to checkout');
    }

    const item = await response.json();
    itemName = item[0].name
    showEditModal(itemName, quantity, orderId, itemId)
}

async function saveEditedItem(orderId, itemId) {
    newQuantity = document.getElementById("itemQuan").value;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/waiter/saveEditedOrder', {
        method: 'POST',
        body: JSON.stringify({ orderId: orderId, itemId: itemId, newQuantity: newQuantity }),
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-type': 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to checkout');
    }
    closeModal()
    document.getElementById(`${itemId}quan`).textContent = newQuantity;
}


function showEditModal(itemName, itemQuan, orderId, itemId) {
    const modalDiv = document.createElement('div');
    modalDiv.id = "editModalContainer";

    modalDiv.innerHTML = `
        <div class="bg-opacity-50 editItemModal">
            <div class="flex flex-col bg-white p-5 rounded-lg shadow-lg">
                <div class="my-3">
                    Item Name: ${itemName}
                </div>
                <div class="my-3">
                    Item Quantity: <input type="number" id="itemQuan" value="${itemQuan}" required class="border border-gray-300 rounded-md p-1">
                </div>
                <div class="flex justify-between mt-4">
                    <button class="bg-red-500 text-white p-2 rounded-xl">Delete</button>
                    <button class="bg-green-500 text-white p-2 rounded-xl" onclick="saveEditedItem(${orderId}, ${itemId})">Save</button>
                    <button class="bg-blue-500 text-white p-2 rounded-xl" onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modalDiv);
}

function closeModal() {
    const modalDiv = document.getElementById("editModalContainer");
    if (modalDiv) {
        document.body.removeChild(modalDiv);
    }
}

function collapseOrder(containerId, itemName, button) {
    let orderContainer = document.getElementById(containerId);
    orderContainer.classList.add('flex', 'justify-between');
    orderContainer.innerHTML = ""
    orderContainer.innerHTML += `<p>${containerId}</p>
    <p>${itemName}</p>
    <button onclick="expandOrder(${containerId})"><img src="${(svgURl + "ArrowUp.svg")}" class="w-8 rotate-180"></button>
</div > `
    button.parentNode.innerHTML = ""
}

function addOrderToWaiterOrCheckout(orderId) {
    let orderContainer = document.getElementById(orderId);
    let borderColor = orderContainer.className.includes('border-Danger') ? 'border-Danger' : 'border-Primary'
    if (borderColor == 'border-Danger') {
        addOrderToWaiter(orderId);
        window.location.href = "/waiters";
    }
}

async function goToPOS(orderId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/waiter/to-pos', {
        method: 'POST',
        body: JSON.stringify({ orderId: orderId }),
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-type': 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to checkout');
    }

    window.location.href = "/pos"
}

function renderActiveWaitersOrders(orderId, order, borderColor) {
    let code = `
     <div class="flex justify-between w-11/12 p-5 ${borderColor} rounded-xl border-2 mt-3" id=${orderId}>
                <p>${orderId}</p><div class="flex">`;
    for (let i = 0; i < order.items.length; i++) {
        code += `<p class="mx-1">${order.items[i].item['name']}</p>`
    }
    code += `</div><button onclick="expandOrder(${orderId})"><img src="${svgURl + "ArrowUp.svg"}" class="w-8 rotate-180"></button>
            </div>`;
    return code;
}

function addOrderToWaiter(orderId) {
    addOrUpdateCartItem("Waiter-Orders", orderId);
}


function init() {
    if (!getCookie("Waiter-Orders")) {
        setCookie("Waiter-Orders", JSON.stringify([]), 90); // Expire after 90 Dasys
    }
    getAllOrders()
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

function addOrUpdateCartItem(cookieName, orderId) {
    let existingData = getCookie(cookieName);
    let cartItems = existingData ? JSON.parse(existingData) : [];

    const index = cartItems.findIndex(item => item === orderId);

    if (index !== -1) {
        return;
    } else {
        cartItems.push(orderId);
    }
    setCookie(cookieName, JSON.stringify(cartItems), 90);
}

init()