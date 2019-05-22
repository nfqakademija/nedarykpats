import React, { Component } from 'react';
import StarRatingComponent from 'react-star-rating-component';

class FeedbackRate extends Component {
    constructor(props) {
        super(props);

        this.state = {
            rating: 1
        };
    }

    onStarClick(nextValue) {
        const { values } = this.props;
        this.setState({ rating: nextValue });
        values.rateValue = nextValue;
    }

    saveAndContinue = e => {
        const { nextStep, addRate, values } = this.props;
        e.preventDefault();
        nextStep();
        addRate(values.rateValue);
    };

    render() {
        const { rating } = this.state;

        return (
            <div className="Review">
                <div className="Avatar--square u-align-center">
                    <img src="/img/rate-meistriukas.jpg" alt="user-avatar" />
                </div>

                <h3> Vardenis pavardenis</h3>
                <p>Įvertink ir leisk kitiems sužinoti, ar darbas kokybiškas!</p>

                <span className="StarRating u-align-center u-margin-top">
                    <StarRatingComponent
                        name="rateValue"
                        starCount={5}
                        value={rating}
                        onStarClick={this.onStarClick.bind(this)}
                    />
                </span>

                <div className="u-margin-top u-align-center">
                    <button
                        type="submit"
                        className="Button Button--blue"
                        onClick={this.saveAndContinue}
                    >
                        Vertinti
                    </button>
                </div>
            </div>
        );
    }
}

export default FeedbackRate;
