const slides = document.querySelectorAll('.slide');
const dotsContainer = document.querySelector('.dots');

let slideIndex = 0;

function showSlide(index) {
    slides.forEach((slide) => {
        slide.classList.remove('active');
    });
    slides[index].classList.add('active');
}

function showDot(index) {
    const dots = dotsContainer.querySelectorAll('.dot');
    dots.forEach((dot) => {
        dot.classList.remove('active-dot');
    });
    dots[index].classList.add('active-dot');
}

function nextSlide() {
    slideIndex = (slideIndex + 1) % slides.length;
    showSlide(slideIndex);
    showDot(slideIndex);
}

function prevSlide() {
    slideIndex = (slideIndex - 1 + slides.length) % slides.length;
    showSlide(slideIndex);
    showDot(slideIndex);
}

function init() {
    slides[0].classList.add('active');
    for (let i = 0; i < slides.length; i++) {
        const dot = document.createElement('span');
        dot.classList.add('dot');
        dot.addEventListener('click', () => {
            slideIndex = i;
            showSlide(slideIndex);
            showDot(slideIndex);
        });
        dotsContainer.appendChild(dot);
    }
    showDot(0);
    setInterval(nextSlide, 5000);
}

init();