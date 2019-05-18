import React, { Component } from 'react';

class FeedbackSuccess extends Component {
    saveAndContinue = e => {
        e.preventDefault();
        const writeReview = document.getElementById('writeReviewModal');
        writeReview.classList.remove('show');
    };

    render() {
        const {
            values: { rateValue, feedbackText }
        } = this.props;

        return (
            <div className="Review">
                <h1>Ačiū už atsiliepimą!</h1>

                <div>{feedbackText}</div>
                <div>{rateValue}</div>

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
