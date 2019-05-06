import React from 'react';
import ReactDOM from 'react-dom';
import AddCategories from './components/createForm/AddCategories.jsx';
import AlertDialog from './components/dialogs/AlertDialog';

require('bootstrap');
require('../css/app.scss');

const categories = document.getElementById('AdvertCategories');
if (categories) {
    try {
        ReactDOM.render(
        <AddCategories {...(categories.dataset)}/>,
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

const alertDialog = document.getElementById("Alert");

if (alertDialog) {
    try {
        ReactDOM.render(
        <AlertDialog {...(alertDialog.dataset)}/>,
        alertDialog
    );
    } catch (error) {
        console.error(error);
    }
}
