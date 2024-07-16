const drop_down_cards = document.querySelectorAll(".drop_down_card");

drop_down_cards.forEach((card, index) => {
    const extended = card.children[0];
    const compressed = card.children[1];

    const extend = () => {
        extended.style.display = "flex";
        compressed.style.display = "none";
    };

    const compress = () => {
        compressed.style.display = "flex";
        extended.style.display = "none";
    };

    const compressButton = extended.children[1];

    if (card.dataset.extended == 1) {
        extend();
    } else if (card.dataset.extended == 0) {
        compress();
    }

    compressButton.addEventListener("click", compress);

    const extendButton = compressed.children[1];

    extendButton.addEventListener("click", extend);
});

