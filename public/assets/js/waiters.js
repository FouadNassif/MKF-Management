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
    window.location.href = "/waiters"
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