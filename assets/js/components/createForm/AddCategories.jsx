import React from 'react';
import Select from 'react-select';

class AddCategories extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            selectedOption: null,
            categories: [],
            errors: {},
            dom: document.getElementById(this.props.originalInputId),
        };

        this.getValuesFromFile();
    }

    handleChange = selectedOption => {
        this.setState({ selectedOption });
    };

    getValuesFromFile = () => {
        const { dom, categories } = this.state;

        for (let i = 0; i < dom.length; i += 1) {
            categories.push({
                value: dom[i].value,
                label: dom[i].text,
            });
        }
        return categories;
    };

    removeSelectedValues = array => {
        return array.forEach(function(label, index) {
            array[index].removeAttribute('selected');
        });
    };

    addSelectedValues = (array, selected) => {
        return array.forEach(function(label, index) {
            if (array[index].text === selected) {
                array[index].setAttribute('selected', true);
            }
        });
    };

    updateSelectedValues = () => {
        const { selectedOption, dom } = this.state;
        const selected = selectedOption || 0;
        const domOptions = dom.querySelectorAll('option');

        this.removeSelectedValues(domOptions);

        for (let i = 0; i < selected.length; i += 1) {
            this.addSelectedValues(domOptions, selected[i].label);
        }
    };

    render() {
        const { selectedOption, categories } = this.state;
        const { handleChange } = this;

        this.updateSelectedValues();

        return (
            <Select
                value={selectedOption}
                onChange={handleChange}
                options={categories}
                isMulti
                isSearchable
                required
            />
        );
    }
}

export default AddCategories;
