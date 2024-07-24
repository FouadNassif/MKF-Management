let itemSearchInp = document.getElementById("itemSearchInp");
let itemContainer = document.getElementById("itemContainer");

itemSearchInp.addEventListener('input', function () {
    if (itemSearchInp.value.trim() === "") {
        getAllItems();
        enableCategory();
    } else {
        searchItem(itemSearchInp.value);
    }
});

async function searchItem(txt) {
    const token = document.querySelector(`meta[name="csrf-token"]`).getAttribute("content");

    const response = await fetch("/item/search", {
        method: "POST",
        body: JSON.stringify({
            itemName: txt,
        }),
        headers: {
            "X-CSRF-TOKEN": token,
            "Content-type": "application/json",
        },
    });

    if (!response.ok) {
        throw new Error("Failed to search items");
    }

    const items = await response.json();
    disableCategory();
    updateItemContainer(items);
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
        throw new Error("Failed to search items");
    }

    const items = await response.json();
    updateItemContainer(items);
}

async function searchByCategory(id, but) {
    const token = document.querySelector(`meta[name="csrf-token"]`).getAttribute("content");

    const response = await fetch("/item/category", {
        method: "POST",
        body: JSON.stringify({
            categoryId: id,
        }),
        headers: {
            "X-CSRF-TOKEN": token,
            "Content-type": "application/json",
        },
    });

    if (!response.ok) {
        throw new Error("Failed to checkout");
    }

    const items = await response.json();
    itemSearchInp.value = "";
    removeSelectCategoryColor(but);
    updateItemContainer(items);
}

function updateItemContainer(items) {
    itemContainer.innerHTML = '';
    if (items.length === 0) {
        itemContainer.innerHTML = noResultFound();
        return;
    }
    items.forEach(item => {
        renderItems(item);
    });
}

function renderItems(item) {
    let imageURL = item['imageURL'] ? `${item['imageURL']}` : '';
    let HTMLCard = `
        <div class='p-2 rounded-xl border-2 border-black w-96 m-5 min-h-90 max-h-90'>
            <img src='${imageURL}' alt='${item['name']}' class='w-full h-48 object-cover'>
            <h1 class='font-bold text-xl'>${item['name']}</h1>
            <p class='text-gray-400 min-h-24 max-h-24 overflow-hidden text-ellipsis'>
                ${item['description']}
            </p>
            <div class='flex justify-between px-2 mt-3'>
                <button type="button" class='bg-Primary p-1 text-white rounded-lg w-1/4' onclick="showItemModal(this)"
                    data-itemId="${item['id']}">ADD</button>
                <p>${item['price']}</p>
            </div>
        </div>`;
    itemContainer.innerHTML += HTMLCard;
}

function noResultFound() {
    return ` 
    <div class='p-2 rounded-xl border-2 border-black w-96 m-5 min-h-90 max-h-90'>
            <img src='http://127.0.0.1:8000/assets/img/noresult.png' class='w-full h-48 object-cover'>
            <h1 class='font-bold text-xl'>No Results Found</h1>
            <p class='text-gray-400 min-h-24 max-h-24 overflow-hidden text-ellipsis'>
                We couldn't find what you searched for. <br>
                Try searching again.
            </p>
            <div class='flex justify-between px-2 mt-3'>
                <button type="button" class='bg-Primary p-1 text-white rounded-lg w-1/4'>ADD</button>
                <p>$0.00001</p>
            </div>
        </div>`;
}

function removeSelectCategoryColor(but) {
    let categoryContainer = document.getElementById("categoryContainer").querySelectorAll("button");
    for (let buts of categoryContainer) {
        buts.style.backgroundColor = '#649B92';
    }
    but.style.backgroundColor = '#527c75';
}

function disableCategory() {
    let categoryContainer = document.getElementById("categoryContainer").querySelectorAll("button");
    for (let buts of categoryContainer) {
        buts.style.backgroundColor = 'gray';
        buts.disabled = true;
    }
}

function enableCategory() {
    let categoryContainer = document.getElementById("categoryContainer").querySelectorAll("button");
    for (let buts of categoryContainer) {
        buts.disabled = false;
        buts.style.backgroundColor = '#649B92';
    }
}
