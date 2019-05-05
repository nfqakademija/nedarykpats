import React from 'react';
import ReactDOM from 'react-dom';
import Categories from './components/createForm/categories.jsx';

require('bootstrap');
require('../css/app.scss');

const categories = document.getElementById('AdvertCategories');
if (categories) {
    try {
        ReactDOM.render(
        <Categories {...(categories.dataset)}/>,
        categories
    );
    } catch (error) {
        console.error(error);
    }
}

//--Add style to component
let categoryContainer = document.getElementsByClassName("css-1pcexqc-container");
for(let i = 0; i < categoryContainer.length; i++) {
    categoryContainer[i].className += " Form-select";
};

