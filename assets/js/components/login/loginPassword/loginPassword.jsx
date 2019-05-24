import React, { Component } from 'react';
import Avatar from '../loginImages/loginAvatar.jsx';

class LoginPassword extends Component{

    saveAndContinue = e => {
        e.preventDefault();
        this.props.nextStep();
    };

    _handleKeyDown = e => {
        if (e.key === 'Enter') {}
    };

    back = e => {
        const { prevStep } = this.props;
        e.preventDefault();
        prevStep();
    };

    render(){
        const { values } = this.props;
        // const csrf_token = this.props.feedbackToken;

        return(
            <div>
                <div>
                    <Avatar />

                    <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                    <div className="Form-item">
                        <input id="inputPassword"
                               type="password"
                               name="password"
                               placeholder="Slaptažodis"
                               required
                               onChange={this.props.handleChange('password')}
                               onKeyDown={this._handleKeyDown}
                               defaultValue={values.password}
                        />
                        <div id="Form-errors" className="Form-errors u-margin-bottom">
                            <li>{this.props.values.error}</li>
                        </div>
                    </div>

                    <div className="u-margin-top u-align-center">
                        <button
                            className="Button Button--blue "
                            type="submit"
                            onClick={this.props.tryToLogin}
                        >
                            Prisijungti
                        </button>
                    </div>
                    <div className="u-align-center">
                        <a className="Button Button--empty"
                           onClick={this.back}>
                            Atgal
                        </a>
                    </div>
                </div>

                <div className="u-align-center">
                    <a className="Button Button--empty"
                        onClick={this.props.sendSingleLoginLink}
                    >
                        Prisijunk be slaptažodžio!
                    </a>
                </div>
            </div>
        )
    }
}

export default LoginPassword;
