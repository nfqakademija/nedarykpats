import React, { Component } from 'react';
import Avatar from '../loginAvatar/loginAvatar.jsx';
import { throws } from 'assert';

class LoginEmail extends Component{
    saveAndContinue = (e) => {
        e.preventDefault();
        this.props.nextStep();

    };

    render(){
        const { values } = this.props;

        return(
            <div className="Form Form-background Form--short">

                {/*<Avatar />*/}
                <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                <div className="Form-item">
                    <label htmlFor="floatField">El. paštas</label>
                    <input type="email"
                           name="email"
                           id="inputEmail"
                           onChange={this.props.handleChange('email')}
                           defaultValue={values.firstName}
                           required
                    />
                </div>

                <div className="u-margin-top-bottom u-align-center">
                    <a className="Button Button--blue Button--long" onClick={this.saveAndContinue}>Toliau </a>
                </div>
            </div>
        );
    }
}

export default LoginEmail;
