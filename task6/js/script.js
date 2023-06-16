const navbar = document.querySelector('.navbar')
const [red, green, blue] = [53, 49, 45]

// window.addEventListener('scroll', () => {
//     let y = 1 + (window.scrollY || window.pageYOffset) / 150
//     y = y < 1 ? 1 : y
//     const [r, g, b] = [red/y, green/y, blue/y].map(Math.round)
//     navbar.style.backgroundColor = `rgb(${r}, ${g}, ${b})`
//   })

$(function() {
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        navbar.classList.remove('navbar-inverse')
        navbar.classList.add('navbar-inverse-color')
    } 
    if ($(this).scrollTop() < 100) {
        navbar.classList.remove('navbar-inverse-color')
        navbar.classList.add('navbar-inverse')
    } 
});
});