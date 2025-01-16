<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Slider</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .slider-container {
        width: 80%;
        max-width: 1200px;
        overflow: hidden;
        position: relative;
    }

    .slider {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .card {
        flex: 0 0 33.3333%;
        box-sizing: border-box;
        padding: 20px;
        background: #fff;
        margin: 0 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        opacity: 0.5;
        transform: scale(0.9);
        text-align: center;
    }

    .card.center {
        opacity: 1;
        transform: scale(1);
    }

    .card h4 {
        color: #d4af37;
        margin: 10px 0;
    }

    .card p:last-child {
        color: #000;
        font-weight: bold;
    }

    .slider-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
    }

    button {
        background: #e3f6e4;
        border: none;
        padding: 10px 15px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
    }

</style>
<body>
<div class="slider-container">
    <div class="slider">
        <div class="card left">
            <p>Eu a aenean vulputate tristique tortor interdum. Porttitor pellentesque neque amet molestie lacus est bibendum.</p>
        </div>
        <div class="card center">
            <p>Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate tristique tortor interdum. Vitae facilisi nunc nisl nec. Porttitor pellentesque neque amet molestie lacus est bibendum.</p>
            <h4>John Doe</h4>
            <p>Dream Properties Lahore</p>
        </div>
        <div class="card right">
            <p>Eu a aenean vulputate tristique tortor interdum. Porttitor pellentesque neque amet molestie lacus est bibendum.</p>
        </div>
    </div>
    <div class="slider-controls">
        <button class="prev">&lt;</button>
        <button class="next">&gt;</button>
    </div>
</div>
</body>
</html>

<script>
    const slider = document.querySelector('.slider');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');

    let currentIndex = 1;

    function updateSlider() {
        slider.style.transform = `translateX(${-currentIndex * 100}%)`;

        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.classList.remove('center');
            if (index === currentIndex) card.classList.add('center');
        });
    }

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + 3) % 3; // Update for circular slider
        updateSlider();
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % 3; // Update for circular slider
        updateSlider();
    });

    updateSlider(); // Initialize

</script>
