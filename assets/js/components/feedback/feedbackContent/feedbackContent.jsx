import React, { Component } from 'react';

class FeedbackContent extends Component {
    saveAndContinue = e => {
        const { nextStep } = this.props;
        e.preventDefault();
        nextStep();
    };

    back = e => {
        const { prevStep } = this.props;
        e.preventDefault();
        prevStep();
    };

    render() {
        const { values, handleChange } = this.props;

        return (
            <div className="Review">
                <p>
                    Parašykite trumpą atslipeimą ir taip padėkite kitiems jį
                    pasamdyti!
                </p>
                <div className="Form-item">
                    <textarea
                        rows="5"
                        onChange={handleChange('feedbackText')}
                        defaultValue={values.feedbackText}
                    />
                </div>

                <div className="u-margin-top-bottom u-align-center">
                    <button
                        type="submit"
                        className="Button Button--long"
                        onClick={this.back}
                    >
                        Atgal
                    </button>
                    <button
                        type="submit"
                        className="Button Button--blue Button--long"
                        onClick={this.saveAndContinue}
                    >
                        Tęsti
                    </button>
                </div>
            </div>
        );
    }
}

export default FeedbackContent;
