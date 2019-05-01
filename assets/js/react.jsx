const React = require('react');
const ReactDOM = require('react-dom');

if (typeof usingReactApp !== "undefined") {
    const FloatLabel = (() => {

        const handleFocus = (e) => {
            const target = e.target;
            target.parentNode.classList.add('active');
        };

        const handleBlur = (e) => {
            const target = e.target;
            if (!target.value) {
                target.parentNode.classList.remove('active');
            }
        };

        const bindEvents = (element) => {
            const floatField = element.querySelector('input, textarea, select');
            floatField.addEventListener('focus', handleFocus);
            floatField.addEventListener('blur', handleBlur);
        };

        const callEvents = (element) => {
            const floatField = element.querySelector('input, textarea, select');
            floatField.parentNode.classList.add("active")
        };

        const init = () => {
            const floatContainers = document.querySelectorAll('.Form-item');

            floatContainers.forEach((element) => {
                const value = element.querySelector('input, textarea, select').value;
                bindEvents(element);

                if (value) {
                    callEvents(element);
                }
            });
        };

        return {
            init: init
        };
    })();

    FloatLabel.init();

}

if (typeof usingReactApp !== "undefined") {
    const toogleCategories = (() => {

        let categories = [];

        const updateList = () => {
            const categoriesList = document.getElementById('CategoriesList');
            categoriesList.innerHTML = categories;
        };

        const addCategory = (element) => {
            const advertCategories = document.getElementById('AdvertCategories');

            advertCategories.innerHTML +=
                '<span class="Category Category--filter is-newCategory">' +
                '<span class="Filter-title">' +
                element +
                '</span>' +
                '<span class="Filter-icon">' +
                '<i class="fas fa-times"></i>' +
                '</span>' +
                '</span>';
            categories.push(element);
            updateList();
        };

        const removeCategory = (element) => {
            categories = categories.filter(item => item !== element);
            updateList();
        };

        const selectCategories = (element) => {
            element.addEventListener("change", function() {
                const advertValue = element.options[element.selectedIndex].text;
                const isInArray = categories.includes(advertValue);

                (isInArray) ? removeCategory(advertValue) : addCategory(advertValue);
            });
        };

        const removeTags = (element) => {
            const tag = element.childNodes[0];
            const isClass = tag.classList.contains('Filter-title');

            if (isClass) {
                removeCategory(tag.textContent);
                element.style.opacity = '0';
                setTimeout(function(){
                    element.parentNode.removeChild(element);
                    }, 500);
            }
        };

        const init = () => {
            const advertList = document.getElementById('AdvertList');
            const tagParent = document.getElementById('AdvertCategories');

            if (advertList) {
                selectCategories(advertList);
            }

            if (tagParent) {
                tagParent.addEventListener("click",function(e) {
                    const tag = e.path[1];
                    removeTags(tag);
                });
            }
        };

        return {
            init: init
        };

    })();

    toogleCategories.init();
}
