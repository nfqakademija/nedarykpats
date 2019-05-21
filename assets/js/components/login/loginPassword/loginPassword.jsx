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
        const csrf_token = document.getElementById('csrf_token').value;

        return(
            <div className="Form Form-background Form--short">
                <form method="post">
                    <Avatar />

                    <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                    <input id="csrf_token"
                           type="hidden"
                           name="_csrf_token"
                           value={csrf_token}
                    />
                    <input type="text"
                           name="email"
                           id="inputEmail"
                           hidden
                           defaultValue={values.email}
                    />

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
                    </div>

                    <div className="u-margin-top-bottom u-align-center">
                        <a className="Button Button--blue"
                           onClick={this.back}>
                            Atgal
                        </a>
                        <button
                            className="Button Button--blue "
                            type="submit">
                            Prisijungti
                        </button>
                    </div>
                </form>

                <div className="u-margin-top-bottom u-align-center">
                    <a className="Button Button--long"
                        onClick={this.props.sendSingleLoginLink}>
                        Prisijungimo nuoroda
                    </a>
                </div>
            </div>
        )
    }
}

export default LoginPassword;
