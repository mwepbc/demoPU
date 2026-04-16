let slider = document.querySelector(".sliderInfo");
let photos = [
    'image08.webp',
    'image09.webp',
    'image10.webp',
    'image12.webp'
];
let cunt = photos.length;
let index = 0;

function prevSlider() {
    index = (index - 1 + cunt) % cunt;
    updateSlider();
}

function nextSlider() {
    index = (index + 1) % cunt;
    updateSlider();
}

function updateSlider() {
    slider.innerHTML = `
        <img src="resources/media/${photos[index]}" alt="sliderPhoto">
    `;
    resetTimer();
}

function startTimer() {
    timer = setInterval(nextSlider, 3000);
}

function resetTimer() {
    clearInterval(timer);
    startTimer();
}

startTimer();