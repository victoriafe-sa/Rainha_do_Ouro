const toggleButton = document.querySelector('.button_ai-open-envelope');
const submenu = document.querySelector('.submenu');
const arrowIcon = toggleButton.querySelector('.arrow-icon');

toggleButton.addEventListener('click', () => {
    submenu.classList.toggle('active');
    arrowIcon.classList.toggle('rotate');
});