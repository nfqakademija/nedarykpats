import React from 'react';
import Select from 'react-select';

class AddCategories extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            selectedOption: null,
            categories: [],
            dom: document.getElementById(this.props.originalInputId),
        };

        this.getValuesFromFile();
    }

    handleChange = (selectedOption) => {
        this.setState({ selectedOption });
    };

    getValuesFromFile = () => {
        const dom = this.state.dom;

        for (let i = 0; i < dom.length; i++) {
            this.state.categories.push(
                {
                    value: dom[i].value,
                    label: dom[i].text
                }
            );
        }
        return this.state.categories;
    };

    removeSelectedValues = (array) => {
        return array.forEach(function (label, index) {
            array[index].removeAttribute('selected');
        });
    };

    addSelectedValues = (array, selected) => {
        return array.forEach(function (label, index) {
            if (array[index].text === selected) {
                array[index].setAttribute('selected', true);
            }
        });
    };

    updateSelectedValues = () => {
        const selected = this.state.selectedOption || 0;
        const domOptions = this.state.dom.querySelectorAll('option');

        this.removeSelectedValues(domOptions);

        for (let i = 0; i < selected.length; i++) {
            this.addSelectedValues(domOptions, selected[i].label);
        }
    };

    render() {
        const { selectedOption } = this.state;
        this.updateSelectedValues();

        return (
            <Select
                value={selectedOption}
                onChange={this.handleChange}
                options={this.state.categories}
                isMulti
                isSearchable
            />
        );
    }
}

export default AddCategories;
