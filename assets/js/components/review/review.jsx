import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Rate from '../.././components/review/reviewRate/reviewRate';
import Content from '../.././components/review/reviewContent/reviewContent';
import Success from '../.././components/review/reviewSuccess/reviewSuccess';

class Review extends Component {

    state = {
        step: 1,
        firstName: '',
        lastName: '',
        email: '',
        age: '',
        city: '',
        country: ''
    }

    nextStep = () => {
        const { step } = this.state
        this.setState({
            step : step + 1
        })
    }

    prevStep = () => {
        const { step } = this.state
        this.setState({
            step : step - 1
        })
    }

    handleChange = input => event => {
        this.setState({ [input] : event.target.value })
    }

    render() {

        const {step} = this.state;
        const { firstName, lastName, email, age, city, country } = this.state;
        const values = { firstName, lastName, email, age, city, country };
        switch(step) {
            case 1:
                return <Rate
                    nextStep={this.nextStep}
                    handleChange = {this.handleChange}
                    values={values}
                />
            case 2:
                return <Content
                    nextStep={this.nextStep}
                    prevStep={this.prevStep}
                    handleChange = {this.handleChange}
                    values={values}
                />
            case 3:
                return <Success />

        }
    }
}

export default Review;
