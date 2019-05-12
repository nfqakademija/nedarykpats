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

//----------------------------------------
// -- Menu fropdown login button ---------
//----------------------------------------

const navDropdown = document.getElementById('Nav-dropdown');
if (navDropdown) {
    const dropdown = document.querySelector('.dropdown');

    navDropdown.addEventListener('click', e => {
        dropdown.classList.toggle('is-visible');
    });

    window.onclick = function(event) {
        const isVisible = dropdown.classList.contains('is-visible');
        const isAvatar = !event.target.classList.contains('Nav-avatar');
        const isAngle = !event.target.classList.contains('fa-angle-down');

        if (isAvatar && isAngle && isVisible) {
            dropdown.classList.remove('is-visible');
        }
    };
}
