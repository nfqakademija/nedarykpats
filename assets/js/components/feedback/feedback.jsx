import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from 'axios';
import Rate from './feedbackRate/feedbackRate.jsx';
import Content from './feedbackContent/feedbackContent.jsx';
import Success from './feedbackSuccess/feedbackSuccess.jsx';
import LoadingSpinner from '../loadingSpinner/loadingSpinner.jsx';

class Feedback extends Component {
    constructor() {
        super();
        this.state = {
            step: 1,
            rateValue: 1,
            feedbackText: '',
            advert: '',
            user: '',
            data: [],
            loading: false
        };
    }

    nextStep = () => {
        const { step } = this.state;
        this.setState({
            step: step + 1
        });
    };

    prevStep = () => {
        const { step } = this.state;
        this.setState({
            step: step - 1
        });
    };

    addRate = value => {
        this.state.rateValue = value;
    };

    handleChange = input => event => {
        this.setState({ [input]: event.target.value });
    };

    addFeedback = () => {
        const { rateValue } = this.state;
        const { feedbackText } = this.state;
        const { nextStep } = this;
        const { advert } = this.state;
        const { user } = this.state;

        this.setState({ loading: true }, () => {
            axios
                .post('/api/feedback', {
                    score: rateValue,
                    message: feedbackText,
                    advert,
                })
                .then(function(response) {
                    console.log(response);
                    nextStep();
                })
                .catch(function(error) {
                    console.log(error);
                    nextStep();
                });
        });
    };

    hideFeedback = () => {
        const writeReview = document.getElementById('writeReviewModal');
        window.onclick = function(event) {
            if (event.target === writeReview) {
                writeReview.classList.remove('show');
            }
        };
    };

    showFeedback = e => {
        const { target } = e;
        this.setState({
            advert: target.dataset.feedbackAdvert,
            user: target.dataset.feedbackUser
        });
        const writeReview = document.getElementById('writeReviewModal');
        writeReview.classList.add('show');
    };

    bindEvents = element => {
        element.addEventListener('click', this.showFeedback);
    };

    render() {
        const { step } = this.state;
        const { rateValue, feedbackText, advert, user } = this.state;
        const values = { rateValue, feedbackText, advert, user };
        const { loading } = this.state;

        const floatContainers = document.querySelectorAll('.feedback');
        floatContainers.forEach(element => {
            this.bindEvents(element);
        });

        this.hideFeedback();

        switch (step) {
            case 1:
                return (
                    <Rate
                        nextStep={this.nextStep}
                        addRate={this.addRate}
                        handleValue={this.handleValue}
                        values={values}
                    />
                );
            case 2:
                return (
                    <div>
                        {loading ? (
                            <LoadingSpinner />
                        ) : (
                            <Content
                                nextStep={this.addFeedback}
                                prevStep={this.prevStep}
                                handleChange={this.handleChange}
                                values={values}
                            />
                        )}
                    </div>
                );
            case 3:
                return <Success values={values} nextStep={this.nextStep} />;
        }
    }
}

export default Feedback;
