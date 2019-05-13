import React, { Component } from 'react';

class Rate extends Component{

    saveAndContinue = (e) => {
        e.preventDefault()
        this.props.nextStep()
    }

    render(){
        const { values } = this.props;
        return(
            <div className="Review">
                <div className="Form-avatar u-align-center u-margin-bottom u-col-3">
                    <img src="/img/user1.png" alt="user-avatar" />
                </div>
                <h3>Vardenis PAvardenis</h3>

                <p>Įvertinkite, kaip labai rekomenduotumėte šį meistrą?</p>

                <span className="StarRating u-align-center">
                    <span className="StarRating-star fa fa-star checked"></span>
                    <span className="StarRating-star fa fa-star checked"></span>
                    <span className="StarRating-star fa fa-star checked"></span>
                    <span className="StarRating-star fa fa-star"></span>
                    <span className="StarRating-star fa fa-star"></span>
                </span>

                <div className="u-margin-top-bottom u-align-center">
                    <a className="Button Button--blue" onClick={this.saveAndContinue}>Vertinti </a>
                </div>

            </div>
        )
    }
}

export default Rate;
