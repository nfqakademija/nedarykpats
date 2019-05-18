import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Rate from '../.././components/feedback/feedbackRate/feedbackRate.jsx';
import Content from '../.././components/feedback/feedbackContent/feedbackContent.jsx';
import Success from '../.././components/feedback/feedbackSuccess/feedbackSuccess.jsx';
import axios from "axios";

class Feedback extends Component {

    constructor() {
        super();
        this.state = {
            step: 1,
            rateValue: '',
            feedbackText: '',
            advert: '',
            user: '',
        };
    }

    nextStep = () => {
        const { step } = this.state;
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
    };

    addFeedback = () => {
        console.log('iskvieciau');
        const rateValue = 8;
        const feedbackText = 'pabandziau ideti duomenis dar karta';
        const { nextStep } = this;
        const advert = this.state.advert;
        const user = this.state.user;

        console.log(advert, user);

        axios.post('/api/feedback', {
            score: rateValue,
            message: feedbackText,
            advert: advert,
            receivingUser: user
        })
        .then(function (response) {
            console.log(response);
            nextStep();
        })
        .catch(function (error) {
            console.log(error);
            nextStep();
        });

    }

    hideFeedback = () => {
        const writeReview = document.getElementById('writeReviewModal');
        window.onclick = function(event) {
            if (event.target === writeReview) {
                writeReview.classList.remove('show');
            }
        }
    }

    showFeedback = e => {
        const { target } = e;
        this.setState({
            advert: target.dataset.feedbackAdvert,
            user: target.dataset.feedbackUser,
        });
        const writeReview = document.getElementById('writeReviewModal');
        writeReview.classList.add('show');
    };

    bindEvents = element => {
        element.addEventListener('click', this.showFeedback);
    };

    render() {

        const {step} = this.state;
        const { rateValue, feedbackText, advert, user } = this.state;
        const values = { rateValue, feedbackText, advert, user };

        const floatContainers = document.querySelectorAll('.feedback');
        floatContainers.forEach(element => {
            this.bindEvents(element);
        });

        this.hideFeedback();

        switch(step) {
            case 1:
                return <Rate
                    nextStep={this.nextStep}
                    handleChange = {this.handleChange}
                    values={values}
                />
            case 2:
                return <Content
                    nextStep={this.addFeedback}
                    prevStep={this.prevStep}
                    handleChange = {this.handleChange}
                    values={values}
                />
            case 3:
                return <Success
                    values={values}
                    nextStep={this.nextStep}
                />

        }
    }
}

export default Feedback;
