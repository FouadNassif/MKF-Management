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
    if (orders.length >= 1) {
        orders.forEach(order => {

            if (order.items.length >= 1) {
                htmlCodeActive += renderActiveWaitersOrders(order.id, order);
            }
        });
    }
    document.getElementById("allOrder").innerHTML = htmlCodeActive;
}

function renderActiveWaitersOrders(orderId, order) {
    let code = `
     <div class="flex justify-between w-11/12 p-5 border-Primary rounded-xl border-2 mt-3" id=${orderId}>
                <p>${orderId}</p><div class="flex">`;
    for (let i = 0; i < order.items.length; i++) {
        code += `<p class="mx-1">${order.items[i].item['name']}</p>`
    }
    code += `</div><button onclick="expandOrder(${orderId})"><img src="${svgURl + "ArrowUp.svg"}" class="w-8 rotate-180"></button>
            </div>`;
    return code;
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
    orderContainer.className = ''
    orderContainer.className = `border-2 border-Primary p-4 rounded-xl w-11/12 mt-3`

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
                <button class="bg-Primary rounded-lg py-2 px-5 text-white" onclick="checkout(${orderId})">Checkout</button>
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
    document.getElementById("itemQuan").value = newQuantity;
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
                    Item Quantity: 
                    <button onclick="decrement()" class="bg-Primary text-white px-2">-</button>
                    <input type="number" size="1" id="itemQuan" value="${itemQuan}" required class="border outline-none border-gray-300 w-fit rounded-md p-1" readonly>
                    <button onclick="increment()" class="bg-Primary text-white px-2">+</button>
                </div>
                <div class="flex justify-between mt-4 waitBut">
                    <button class="bg-red-500 text-white p-2 rounded-xl" onclick="deleteItem(${itemId}, ${orderId}, '${itemName}')">Delete</button>
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

async function deleteItem(itemId, orderId, itemName) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const response = await fetch('/waiter/deleteItem', {
        method: 'POST',
        body: JSON.stringify({ itemId: itemId, orderId: orderId }),
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-type': 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error('Failed to checkout', response.Error);
    }

    const deleted = await response.json();
    if (deleted.deleted == "true") {
        const paragraphs = document.querySelectorAll('p');
        paragraphs.forEach(paragraph => {
            if (paragraph.textContent.trim() === itemName) {
                paragraph.parentElement.parentElement.remove()
                closeModal()
            }
        });
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

function checkout(orderId) {
    window.location.href = `/pos/payment?order_id=${orderId}`
}
getAllOrders()

function increment() {
    let itemQuan = document.getElementById("itemQuan");
    itemQuan.value++;
}

function decrement() {
    let itemQuan = document.getElementById("itemQuan");
    if (itemQuan.value > 1) {
        itemQuan.value--;
    }
}