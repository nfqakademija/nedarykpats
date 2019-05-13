import React, { Component } from 'react';

class Confirmation extends Component{
    saveAndContinue = (e) => {
        e.preventDefault();
        this.props.nextStep();
    }

    back  = (e) => {
        e.preventDefault();
        this.props.prevStep();
    }

    render(){
        const {values: { firstName, lastName, email, age, city, country }} = this.props;

        return(
            <div className="Review">
                <h1>ar duomenys geri</h1>

                <a className="Button Button--long" onClick={this.back}>Atgal</a>
                <a className="Button Button--blue Button--long" onClick={this.saveAndContinue}>Toliau</a>
            </div>
        )
    }
}

export default Confirmation;
