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
            changeCategoriesTitle();
        };

        const addCategory = (element, value, list) => {
            const advertCategories = document.getElementById('AdvertCategories');

            advertCategories.innerHTML +=
                '<span class="Category Category--filter is-newCategory">' +
                '<li class="Filter-title"' +
                'value="' + value + '">' +
                element +
                '</li>' +
                '<span class="Filter-icon">' +
                '<i class="fas fa-times"></i>' +
                '</span>' +
                '</span>';
            categories.push(element);

            for (var i = 0; i < list.length; i++){
                if (list.options[i].value === value )
                    list.remove(i);
            }

            updateList();
        };

        const removeCategory = (element) => {
            categories = categories.filter(item => item !== element);
            updateList();
        };

        const changeCategoriesTitle = () => {
            const categoriesTitle = document.getElementById('CategoriesTitle');
            const isSelectedCategories = categories.length > 0;
            let title = "Pasirinkite kategorijas";

            (isSelectedCategories) ? title = "Pasirinktos kategorijos:" : title = "Pasirinkite kategorijas";
            categoriesTitle.innerText = title;
        };

        const selectCategories = (element) => {
            element.addEventListener("change", function() {
                const advertText = element.options[element.selectedIndex].text;
                const advertValue = element.options[element.selectedIndex].value;
                const isInArray = categories.includes(advertText);

                (isInArray) ? removeCategory(advertText) : addCategory(advertText, advertValue, element);
            });
        };

        const removeTags = (element, list) => {

            const isClassTitle = element.classList.contains('Filter-title');
            const isClassCategory = element.classList.contains('Category');
            const isClassIcon = element.parentNode.classList.contains('Filter-icon');

            const remove = (tag, tagText, tagValue) => {
                removeCategory(tagText);
                tag.style.opacity = '0';
                setTimeout(function(){
                    tag.parentNode.removeChild(tag);
                }, 500);
                list.innerHTML += '<option value="'+tagValue+'">'+tagText+'</option>';
            };

            if (isClassTitle) {
                const tag = element.parentNode;
                const tagText = element.textContent;
                const tagValue = element.value;
                remove(tag, tagText, tagValue);
            }

            if (isClassCategory) {
                const tag = element;
                const tagText = element.textContent;
                const tagValue = element.childNodes[0].value;
                remove(tag, tagText, tagValue);
            }

            if (isClassIcon) {
                const tag = element.parentNode.parentNode;
                const tagText = tag.textContent;
                const tagValue = tag.childNodes[0].value
                remove(tag, tagText, tagValue);
            }

        };



        const init = () => {
            const advertList = document.getElementById('advert_categories');
            const tagParent = document.getElementById('AdvertCategories');

            if (advertList) {
                selectCategories(advertList);
            }

            if (tagParent) {
                tagParent.addEventListener("click",function(e) {
                    const tag = e.srcElement;
                    removeTags(tag, advertList);
                });
            }
        };

        return {
            init: init
        };

    })();

    toogleCategories.init();
}
