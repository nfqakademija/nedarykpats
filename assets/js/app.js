import React from 'react';
import ReactDOM from 'react-dom';
import AddCategories from './components/createForm/AddCategories.jsx';
import Review from './components/feedback/feedback.jsx';
import Login from './components/login/login.jsx';
import AdvertImageGallery from './components/advertImages/advertImages'

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
