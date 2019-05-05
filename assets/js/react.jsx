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
