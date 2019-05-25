import React, { Component } from 'react';
import Avatar from '../loginImages/loginAvatar.jsx';

class LoginPassword extends Component {

    constructor() {
        super();
        this.state = {
            classLabel: "Form-item"
        };
    }

    saveAndContinue = e => {
        e.preventDefault();
        this.props.nextStep();
    };

    _handleKeyDown = e => {
        if (e.key === 'Enter') {
            this.props.tryToLogin();
        }
    };

    back = e => {
        const { prevStep } = this.props;
        e.preventDefault();
        prevStep();
    };

    inputFocusAnimation = ()  => {
        this.state.classLabel = "Form-item active focusWithText ";

    };

    render(){
        const { values } = this.props;
        const { classLabel } = this.state;
        const css = "Form-errors u-margin-bottom " + this.props.values.errorStyle;

        if (values.password) {
            this.inputFocusAnimation();
        }

        return(
            <div>
                <div>
                    <Avatar />

                    <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                    <div className={classLabel}>
                        <label
                            htmlFor="floatField">
                            Slaptažodis
                        </label>
                        <input id="inputPassword"
                               type="password"
                               name="password"
                               required
                               onChange={this.props.handleChange('password')}
                               onKeyDown={this._handleKeyDown}
                               defaultValue={values.password}
                               onFocus={this.inputFocusAnimation}
                        />
                        <div id="Form-errors"
                             className={css}>
                            <li>{this.props.values.error}</li>
                        </div>
                    </div>

                    <div className="u-margin-top-small u-align-center">
                        <button
                            className="Button Button--blue Button--long"
                            type="submit"
                            onClick={this.props.tryToLogin}
                        >
                            Prisijungti
                        </button>
                    </div>
                    <div className="u-margin-top-small u-align-center">
                        <a className="Button Button--long"
                           onClick={this.props.sendSingleLoginLink}
                        >
                            Prisijunk be slaptažodžio!
                        </a>
                    </div>
                </div>

                <div className="u-margin-top u-align-center">
                    <a className="Button Button--empty"
                       onClick={this.back}>
                        Atgal
                    </a>
                </div>
            </div>
        )
    }
}

export default LoginPassword;
