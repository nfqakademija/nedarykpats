import React from 'react';
import ReactDOM from 'react-dom';
import AddCategories from './components/createForm/AddCategories.jsx';
import Review from './components/feedback/feedback.jsx';
import Login from './components/login/login.jsx';
import ImageGalleryAdvert2 from './components/imageGallery/imageGalleryAdvert/imageGalleryAdvert.jsx'
import ImageGalleryProfile from './components/imageGallery/imageGalleryProfile/imageGalleryProfile.jsx';
import ImageGalleryUploader from './components/imageGallery/imageGalleryUpload/imageGalleryUpload.jsx';

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
// Go Back button
//--------------------------
const backButton = document.getElementById('backButton');
if (backButton) {
    backButton.onclick = () => {
        window.history.back();
    };
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
// Add Images in Advert
//--------------------------
const singleAdvertImages = document.getElementById('advertImageGallery');
if (singleAdvertImages) {
    try {
        ReactDOM.render(<ImageGalleryAdvert2 {...singleAdvertImages.dataset}/>, singleAdvertImages);

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
        ReactDOM.render(<ImageGalleryProfile {...displayImagesProfile.dataset}/>, displayImagesProfile);

    } catch (error) {
        console.error(error);
    }
}

//--------------------------
// Add Image Uploader in Profile
//--------------------------
const uploadImages = document.getElementById('uploadImages');
if (uploadImages) {
    try {
        ReactDOM.render(<ImageGalleryUploader/>, uploadImages);

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
