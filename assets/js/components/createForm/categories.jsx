import React from 'react';
import Select from 'react-select';

const options = [
    { value: '1', label: 'Statybos' },
    { value: '2', label: 'Remontas' },
    { value: '3', label: 'Lauko darbai' },
    { value: '4', label: 'Vidaus darbai' },
    { value: '5', label: 'Kiti darbai' },
    { value: '6', label: 'Santechnika' },
    { value: '7', label: 'Vidaus darbai' }
];

class Categories extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            selectedOption: null,
        };
    }

    handleChange = (selectedOption) => {
        this.setState({ selectedOption });
    };

    render() {
        const { selectedOption } = this.state;
        console.log(this.props.categoryOptions);

        return (
            <Select
                value={selectedOption}
                onChange={this.handleChange}
                options={options}
                isMulti
                isSearchable
            />
        );
    }
}

export default Categories;
