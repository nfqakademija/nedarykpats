import React, { Component } from 'react';
import StarRatingComponent from 'react-star-rating-component';

class FeedbackRate extends Component{

    constructor(props) {
        super(props);

        this.state = {
            rating: 1
        };
    }

    componentWillReceiveProps() {
        this.setState({rate: this.state.rating});
    }

    onStarClick(nextValue, prevValue, name) {
        this.setState({rating: nextValue});
    }

    saveAndContinue = (e) => {
        e.preventDefault()
        this.props.nextStep()
    };

    render(){
        const { rating } = this.state;
        let { values } = this.props;

        return(
            <div className="Review">
                <div className="Form-avatar u-align-center u-margin-bottom u-col-3">
                    <img src="/img/user1.png" alt="user-avatar" />
                </div>
                <h3>Vardenis Pavardenis</h3>

                <p>Įvertinkite, kaip labai rekomenduotumėte šį meistrą?</p>

                <span className="StarRating u-align-center">
                    <StarRatingComponent
                        name="rate1"
                        starCount={5}
                        value={rating}
                        onStarClick={this.onStarClick.bind(this)}
                    />

                </span>

                <textarea
                    rows="5"
                    onChange={this.props.handleChange('rateValue')}
                    defaultValue={values.rateValue = rating}
                />


                <div className="u-margin-top-bottom u-align-center">
                    <a className="Button Button--blue" onClick={this.saveAndContinue}>Vertinti </a>
                </div>

            </div>
        )
    }
}

export default FeedbackRate;
