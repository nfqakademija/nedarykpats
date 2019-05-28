import React, { Component } from 'react';

class FeedbackSuccess extends Component {
    saveAndContinue = e => {
        e.preventDefault();
        const writeReview = document.getElementById('writeReviewModal');
        writeReview.classList.remove('show');
    };

    render() {
        const {
            values: { rateValue, feedbackText, advert, user }
        } = this.props;

        return (
            <div className="Review">

                <div className="Avatar--square u-align-center">
                    <img src="/img/thank-you.jpg" alt="user-avatar" />
                </div>

                <h3 className="u-margin-top">
                    Ačiū už įvertinimą!
                </h3>
                <div className="u-margin-top-bottom u-align-center">
                    <button
                        type="submit"
                        onClick={this.saveAndContinue}
                        className="Button Button--blue"
                    >
                        Uždaryti
                    </button>
                </div>
            </div>
        );
    }
}

export default FeedbackSuccess;
