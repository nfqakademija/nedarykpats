import React from 'react';
import ReactDOM from 'react-dom';
import AddCategories from './components/createForm/AddCategories.jsx';

// require('bootstrap');
require('../css/app.scss');

// const layoutItems = document.querySelectorAll('.Ad');
// const layoutRoot = document.querySelectorAll('#Ads');
// ReactDOM.render(
//     <LayoutMasonry
//         layoutRoot = {layoutRoot}
//         layoutItems = {layoutItems}/>,
//     document.getElementById("Ads")
// );

const categories = document.getElementById('AdvertCategories');
if (categories) {
    try {
        ReactDOM.render(<AddCategories {...categories.dataset} />, categories);
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
