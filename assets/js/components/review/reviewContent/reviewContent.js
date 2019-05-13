import React, { Component } from 'react';
import { throws } from 'assert';

class Content extends Component{
    saveAndContinue = (e) => {
        e.preventDefault();
        this.props.nextStep();
    }

    back  = (e) => {
        e.preventDefault();
        this.props.prevStep();
    }

    render(){
        const { values } = this.props
        return(
            <div className="Review">
                <p>Parašykite trumpą atslipeimą ir taip padėkite kitiems jį pasamdyti!</p>
                <div className="Form-item">
                     <textarea rows="5"> </textarea>
                </div>

                <div className="u-margin-top-bottom u-align-center">
                    <a className="Button Button--long" onClick={this.back}>Atgal</a>
                    <a className="Button Button--blue Button--long" onClick={this.saveAndContinue}>Tęsti </a>
                </div>
            </div>
        )
    }
}

export default Content;
