import React from 'react';
import ReactDOM from 'react-dom';
import AddCategories from './components/createForm/AddCategories.jsx';
import Review from './components/review/review.jsx';

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
        ReactDOM.render(<Review />, review);
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
