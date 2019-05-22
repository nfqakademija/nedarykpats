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
                <h3>
                    Parašykite trumpą atsiliepimą!
                </h3>
                <div className="Form-item">
                    <textarea
                        rows="5"
                        onChange={handleChange('feedbackText')}
                        defaultValue={values.feedbackText}
                    />
                </div>

                <div className="u-margin-top-bottom u-align-space-around">
                    <button
                        type="submit"
                        className="Button"
                        onClick={this.back}
                    >
                        Atgal
                    </button>
                    <button
                        type="submit"
                        className="Button Button--blue"
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
