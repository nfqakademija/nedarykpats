import React from 'react';
import ReactDOM from 'react-dom';
import AddCategories from './components/createForm/AddCategories.jsx';
import Review from './components/feedback/feedback.jsx';
import Login from './components/login/login.jsx';
import AdvertImageGallery from './components/advertImages/advertImages'
import DisplayImagesProfile from './components/displayImages/displayImagesProfile/displayImagesProfile';

require('../css/app.scss');


const categories = document.getElementById('AdvertCategories');
if (categories) {
    try {
        ReactDOM.render(<AddCategories {...categories.dataset} />, categories);
    } catch (error) {
        console.error(error);
    }
}

const review = document.getElementById('writeReview');
if (review) {
    try {
        ReactDOM.render(<Review  {...review.dataset}/>, review);
    } catch (error) {
        console.error(error);
    }
}


//--------------------------
// Show feedback if is time
//--------------------------
const showFeedback = document.getElementById('showFeedback');
if (showFeedback) {
    try {
        ReactDOM.render(<Review {...showFeedback.dataset}/>, review);

    } catch (error) {
        console.error(error);
    }
}


const loginForm = document.getElementById('LoginForm');
if (loginForm) {
    try {
        ReactDOM.render(<Login {...loginForm.dataset}/>, loginForm);
    } catch (error) {
        console.error(error);
    }
}

//--------------------------
// --Add style to component
//--------------------------
const categoryContainer = document.getElementsByClassName(
    'css-1pcexqc-container'
);
for (let i = 0; i < categoryContainer.length; i += 1) {
    categoryContainer[i].className += ' Form-select';
}

//--------------------------
// Add Advert Image Gallery
//--------------------------
const singleAdvertImages = document.getElementById('advertImageGallery');
if (singleAdvertImages) {
    try {
        ReactDOM.render(<AdvertImageGallery/>, singleAdvertImages);

    } catch (error) {
        console.error(error);
    }
}

//--------------------------
// Add Images in Profile
//--------------------------
const displayImagesProfile = document.getElementById('displayImagesProfile');
if (displayImagesProfile) {
    try {
        ReactDOM.render(<DisplayImagesProfile/>, displayImagesProfile);

    } catch (error) {
        console.error(error);
    }
}

//--------------------------
// Edit user Profile
//--------------------------
const editUser = document.getElementById('EditUserModal');
const editUserBtn = document.getElementById('EditUserModalButton');

const editUserPassword = document.getElementById('EditUserPasswordModal');
const editUserPasswordBtn = document.getElementById('EditUserPasswordModalButton');


if (editUser) {
    editUserBtn.onclick = function() {
        editUser.classList.add('show');
    }
    editUserPasswordBtn.onclick = function() {
        editUserPassword.classList.add('show');
    }

    const closeModalWindow = (el) => {
        if (el.classList.contains('show')) {
            el.classList.remove('show');
        }
    }

    const modalClose = document.querySelectorAll('.Modal-close');
    modalClose.forEach(element => {
        element.addEventListener("click", function(event) {
            closeModalWindow(editUser);
            closeModalWindow(editUserPassword);
        });
    });

    window.addEventListener("click", function(event) {
        if (event.target == editUserPassword) {
            closeModalWindow(editUserPassword);
        }
        if (event.target == editUser) {
            closeModalWindow(editUser);
        }
    });
}
