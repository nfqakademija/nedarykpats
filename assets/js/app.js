import React from 'react';
import ReactDOM from 'react-dom';
import AddCategories from './components/createForm/AddCategories.jsx';
import Review from './components/feedback/feedback.jsx';
import Login from './components/login/login.jsx';

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
        // ReactDOM.render(<Review {...showFeedback.dataset}/>, review);
        // const writeReviewModal = document.getElementById('writeReviewModal');
        // writeReviewModal.classList.add('show');

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

// --Add style to component
const categoryContainer = document.getElementsByClassName(
    'css-1pcexqc-container'
);
for (let i = 0; i < categoryContainer.length; i += 1) {
    categoryContainer[i].className += ' Form-select';
}


//--------------------------
// My profile edit form
//--------------------------
const editProfile = document.getElementById('EditUserModal');
if (editProfile) {
    try {
        const showPassword = document.getElementById('showPassword');
        const showProfile = document.getElementById('showProfile');
        const formPassword = document.getElementById('formPassword');
        const formProfile = document.getElementById('formProfile');

        showPassword.onclick = function() {
            formPassword.classList.remove('u-display-none');
            formProfile.classList.add('u-display-none');
        };

        showProfile.onclick = function() {
            formPassword.classList.add('u-display-none');
            formProfile.classList.remove('u-display-none');
        }

    } catch (error) {
        console.error(error);
    }
}
