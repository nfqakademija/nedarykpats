//------------------------
// -- Mobile navigation ---
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
// -- Mobile form splash screen dalay -----
//----------------------------------------
const item = document.querySelector('.Nav-link');
item.addEventListener('click', e => {
    const width =
        window.innerWidth ||
        document.documentElement.clientWidth ||
        document.body.clientWidth;

    if (width < 1200) {
        e.preventDefault();

        const goTo = item.getAttribute('href');
        animateSplash();

        setTimeout(function() {
            window.location = goTo;
        }, 700);
    }
});
