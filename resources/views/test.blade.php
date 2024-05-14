<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Photo Slider</title>
<style>
  .slider-container {
    position: relative;
    max-width: 600px;
    margin: auto;
    overflow: hidden;
  }
  .slide {
    display: none;
    width: 100%;
  }
  .active {
    display: block;
  }
  .dots {
    text-align: center;
  }
  .dot {
    display: inline-block;
    width: 15px;
    height: 15px;
    margin: 0 5px;
    background-color: #bbb;
    border-radius: 50%;
    cursor: pointer;
  }
  .active-dot {
    background-color: #717171;
  }
</style>
</head>
<body>

<div class="slider-container">
  <div class="slide active">
    <img src="https://via.placeholder.com/600x400?text=Slide+1" alt="Slide 1">
  </div>
  <div class="slide">
    <img src="https://via.placeholder.com/600x400?text=Slide+2" alt="Slide 2">
  </div>
  <div class="slide">
    <img src="https://via.placeholder.com/600x400?text=Slide+3" alt="Slide 3">
  </div>
</div>

<div class="dots"></div>

<script>
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
    setInterval(nextSlide, 5000); // Change slide every 5 seconds
  }

  init();
</script>

</body>
</html>