import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import axios from 'axios';
import Rate from './feedbackRate/feedbackRate.jsx';
import Content from './feedbackContent/feedbackContent.jsx';
import Success from './feedbackSuccess/feedbackSuccess.jsx';
import FeedbackSpinner from './feedbackSpinner/feedbackSpinner.jsx';

class Feedback extends Component {
    constructor(props) {
        super(props);
        this.state = {
            step: 1,
            rateValue: 5,
            feedbackText: '',
            token: '',
            advert: '',
            user: '',
            data: [],
            loading: false,
        };
    }

    getFeedbackInformation() {
        if (this.props.feedbackAdvert) {
            this.state.user = this.props.feedbackUser;
            this.state.advert = this.props.feedbackAdvert;
            this.state.token = this.props.feedbackToken;
            const writeReview = document.getElementById('writeReviewModal');
            writeReview.classList.add('show');
        }
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
        const { token } = this.state;

        this.setState({ loading: true }, () => {
            axios
                .post('/api/feedback', {
                    score: rateValue,
                    message: feedbackText,
                    _token: token,
                    advert,
                })
                .then(function(response) {
                    console.log(response);
                    setTimeout(function(){
                        window.location.reload(1);
                    }, 1000);
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
            token: target.dataset.feedbackToken,
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
        const { rateValue, feedbackText, advert, user, token } = this.state;
        const values = { rateValue, feedbackText, advert, user, token };
        const { loading } = this.state;

        const onButtonClick = document.querySelectorAll('.feedback');
        onButtonClick.forEach(element => {
            this.bindEvents(element);
        });

        this.hideFeedback();

        this.getFeedbackInformation();

        switch (step) {
            case 1:
                return (
                    <Rate
                        nextStep={this.nextStep}
                        addRate={this.addRate}
                        handleValue={this.handleValue}
                        values={values}
                        user={this.state.user}
                        rate={this.state.rateValue}
                    />
                );
            case 2:
                return (
                    <div>
                        {loading ? (
                            <FeedbackSpinner />
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
