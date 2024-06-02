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
                    <button onclick="decrement()">-</button>
                    <input type="number" id="item-quantity" value="1">
                    <button onclick="increment()">+</button>
                </div>
                <button onclick="addItemToCart(this)" data-itemId="${item['id']}">Add To Cart</button>
            </div>
        </div>
    `;

    const modalContainer = document.getElementById("modalCon");
    modalContainer.className = "modalCon";
    modalContainer.innerHTML = modalContent;
}

function closeModal() {
    const modalContainer = document.getElementById("modalCon");
    modalContainer.className = "";
    modalContainer.innerHTML = "";
}

function increment() {
    let itemQuantity = document.getElementById("item-quantity");
    itemQuantity.value++;
}

function decrement() {
    let itemQuantity = document.getElementById("item-quantity");
    if (itemQuantity.value > 1) {
        itemQuantity.value--;
    }
}