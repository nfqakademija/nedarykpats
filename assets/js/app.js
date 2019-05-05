// const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

require('../css/app.scss');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

// $(document).ready(function() {
//     $('[data-toggle="popover"]').popover();
// });



//------------------------
//-- Mobile navigation ---
//------------------------
const nav = document.querySelector('#nav');
const menu = document.querySelector('#menu');
const menuToggle = document.querySelector('.Nav-toggle');
let isMenuOpen = false;

const animateSplash = () => {
    isMenuOpen = !isMenuOpen;

    menuToggle.setAttribute('aria-expanded', String(isMenuOpen));
    menu.hidden = !isMenuOpen;
    nav.classList.toggle('Nav--open');
};

menuToggle.addEventListener('click', e => {
    e.preventDefault();
    animateSplash();
});


//----------------------------------------
//-- Mobile form splash screen dalay -----
//----------------------------------------
const item = document.querySelector('.Nav-link');
    item.addEventListener('click', e => {
        const width = window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;

        if (width < 1200) {
            e.preventDefault();

            const goTo = item.getAttribute('href');
            animateSplash();

            setTimeout(function () {
                window.location = goTo;
            }, 700);
        }
    });



//----------------------------------------
//-- Registration ir Login form errors ---
//----------------------------------------
const formError = document.querySelectorAll('.Form-item');

formError.forEach((element) => {

    const value = element.querySelector('.Form-errors');

    if ((value) && (value.childNodes.length > 1)) {
        element.classList.add("is-error");
    }
});


















