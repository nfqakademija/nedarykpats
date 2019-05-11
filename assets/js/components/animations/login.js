//----------------------------------------
// -- Registration ir Login form errors ---
//----------------------------------------
const formError = document.querySelectorAll('.Form-item');

formError.forEach(element => {
    const value = element.querySelector('.Form-errors');

    if (value && value.childNodes.length > 1) {
        element.classList.add('is-error');
    }
});

// ----------------------------------------
// -------Login/Regiter switch animation---
// ----------------------------------------
const toogle = (firstItem, secondItem) => {
    firstItem.classList.add('u-display-none');
    secondItem.classList.remove('u-display-none');
};

// validation, netrinti
// const validateEmail = (email) => {
//     const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//     return re.test(email);
// };

const form = document.getElementById('LoginRegister');
if (form) {
    const registerLink = document.getElementById('registerLink');
    const loginLink = document.getElementById('loginLink');

    const registerForm = form.querySelector('.Switch-register');
    const loginForm = form.querySelector('.Switch-login');

    loginLink.addEventListener('click', function() {
        toogle(registerForm, loginForm);
    });

    registerLink.addEventListener('click', function() {
        toogle(loginForm, registerForm);
    });
}
