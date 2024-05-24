async function init() {
    sessionStorage.setItem("POS-Total-Price", 0);
    await fetchItems();
    await fetchCategories();
    renderPOSItems();
    renderPOSCategories();
}

function addItemToReceipt(ref) {
    const id = ref.getAttribute("data-id");
    const POSItems = JSON.parse(sessionStorage.getItem("POS-Items-Receipt"));
    let totalPrice = Number(sessionStorage.getItem("POS-Total-Price"));

    let item = POSItems.filter((item) => item.id == id)[0];
    if (item) {
        item.quantity++;
    } else {
        const items = JSON.parse(sessionStorage.getItem("POS-Items"));
        item = items.filter((item) => item.id == id)[0];
        item.quantity++;
        POSItems.push(item);
    }

    totalPrice += Number(item.price);
    totalPrice = totalPrice.toFixed(2);
    sessionStorage.setItem("POS-Items-Receipt", JSON.stringify(POSItems));
    sessionStorage.setItem("POS-Total-Price", totalPrice);
    renderReceipt();
}

function resetReceipt() {
    sessionStorage.setItem("POS-Items-Receipt", JSON.stringify([]));
    sessionStorage.setItem("POS-Total-Price", 0);
    renderReceipt();
}

function removeItem(ref) {
    const id = ref.getAttribute("data-id");
    let items = JSON.parse(sessionStorage.getItem("POS-Items-Receipt"));
    let totalPrice = Number(sessionStorage.getItem("POS-Total-Price"));

    item = items.filter((item) => item.id == id)[0];

    items.splice(items.indexOf(item), 1);

    totalPrice -= Number(item.price) * Number(item.quantity);
    totalPrice = totalPrice.toFixed(2);
    sessionStorage.setItem("POS-Items-Receipt", JSON.stringify(items));
    sessionStorage.setItem("POS-Total-Price", totalPrice);
    renderReceipt();
}

function changeCategory(ref) {
    const id = ref.getAttribute("data-id");
    sessionStorage.setItem("POS-Current-Category-Id", id);
    renderPOSItems();
}

function renderPOSCategories() {
    const cards = document.getElementById("category-cards");
    const categories = JSON.parse(sessionStorage.getItem("POS-Categories"));

    let cardsHTML = ``;

    categories.forEach((category) => {
        cardsHTML += `
        <div class="cursor-pointer bg-Secondary text-Third rounded-xl px-4 py-2"  style="color: #C3FCF2;" onclick="changeCategory(this)" data-id="${category.id}">${category.name}</div>
        `;
    });

    cards.innerHTML = cardsHTML;
}

function renderPOSItems() {
    const cards = document.getElementById("item-cards");
    const items = JSON.parse(sessionStorage.getItem("POS-Items"));
    const categoryId = sessionStorage.getItem("POS-Current-Category-Id");

    let cardsHTML = ``;

    items.forEach((item) => {
        if (item.category_id == categoryId) {
            cardsHTML += `
            <div class="p-2 rounded-xl border-2 border-black flex-grow cursor-pointer flex flex-col justify-between" onclick="addItemToReceipt(this)" data-id="${item.id}">
                <div class="flex justify-center"><img src="${item.imageURL}" alt=""></div>
                <div class="flex justify-between items-center">
                    <h2 class="font-bold ">${item.name}</h2>
                    <p>$${item.price}</p>
                </div>
            </div>`;
        }
    });

    cards.innerHTML = cardsHTML;
}
function renderReceipt() {
    const items = JSON.parse(sessionStorage.getItem("POS-Items-Receipt"));
    const totalPrice = sessionStorage.getItem("POS-Total-Price");
    const tbody = document.getElementById("tableBody");
    const total = document.getElementById("total");

    let tbodyHTML = "";

    if (items.length < 1) {
        tbodyHTML += `
        <tr>
            <td colspan="4" class="text-center text-gray-500">Empty List</td>
        </tr>
        `;
    } else {
        items.forEach((item) => {
            tbodyHTML += ` <tr>
            <td style="text-align: center; padding-top: 16px; padding-bottom: 16px">${
                item.name
            }</td>
            <td style="text-align: center; padding-top: 16px; padding-bottom: 16px">$${(
                item.price * item.quantity
            ).toFixed(2)}</td>
            <td style="text-align: center; padding-top: 16px; padding-bottom: 16px">${
                item.quantity
            }</td>
            <td class="flex items-center justify-center" style="text-align: center; padding-top: 16px; padding-bottom: 16px"><button onclick="removeItem(this)" data-id="${
                item.id
            }" ><img style="width: 25px" src="/assets/svg/remove.svg"></button></td>
        </tr>`;
        });
    }

    tbody.innerHTML = tbodyHTML;
    total.innerHTML = totalPrice + "$";
}

async function fetchCategories() {
    const response = await fetch("/categories");
    if (response.status !== 200) {
        alert("An Error Occurred While Fetching categories");
    }

    const categories = await response.json();
    sessionStorage.setItem("POS-Categories", JSON.stringify(categories));
    sessionStorage.setItem("POS-Current-Category-Id", 1);
}

async function fetchItems() {
    const response = await fetch("/items");
    if (response.status !== 200) {
        alert("An Error Occurred While Fetching Items");
    }

    let items = await response.json();
    items = items.map((item) => ({ ...item, quantity: 0 }));
    sessionStorage.setItem("POS-Items", JSON.stringify(items));
    sessionStorage.setItem("POS-Items-Receipt", JSON.stringify([]));
}

function proceed() {
    toggleModal();
    const tbody = document.querySelector("#checkout tbody");
    const items = JSON.parse(sessionStorage.getItem("POS-Items-Receipt"));
    let tbodyHTML = "";
    if (items.length < 1) {
        tbodyHTML += `
        <tr>
            <td colspan="4" class="text-center text-gray-500">Empty List</td>
        </tr>
        `;
    } else {
        items.forEach((item) => {
            tbodyHTML += ` <tr>
        <td class="text-center py-4">${item.name}</td>
        <td class="text-center py-4">$${(item.price * item.quantity).toFixed(
            2
        )}</td>
        <td class="text-center py-4">${item.quantity}</td>
    </tr>`;
        });
    }
    tbody.innerHTML = tbodyHTML;
}

async function checkout() {
    try {
        const items = JSON.parse(sessionStorage.getItem("POS-Items-Receipt"));
        const total = JSON.parse(sessionStorage.getItem("POS-Total-Price"));
        const token = document
            .querySelector(`meta[name="csrf-token"]`)
            .getAttribute("content");

        if (items.length < 1) {
            return
        }

        const response = await fetch("/pos/order", {
            method: "POST",
            body: JSON.stringify({
                items: items,
                total: total,
            }),
            headers: {
                "X-CSRF-TOKEN": token,
                "Content-type": "application/json",
            },
        });

        if (!response.ok) {
            throw new Error("Failed to checkout");
        }
        const order = await response.json();
        window.location.href = "/pos/payment?order_id=" + order.id;
    } catch (error) {
        console.error(error);
    }
}

function toggleModal() {
    const modal = document.getElementById("checkout");
    if (modal.style.display == "none") {
        modal.style.display = "flex";
    } else {
        modal.style.display = "none";
    }
}

init();
