import React, { Component } from 'react';
import Avatar from '../loginImages/loginAvatar.jsx';

class LoginEmail extends Component {

    constructor() {
        super();
        this.state = {
            errors: {},
            classLabel: ''
        };
    }

    saveAndContinue = e => {
        if (this.validateForm()) {
            e.preventDefault();
            this.props.nextStep();
        }
    };

    _handleKeyDown = e => {
        if (e.key === 'Enter') {
            this.saveAndContinue(e);
        }
    };

    inputFocusAnimation = () => {
        this.setState({
            classLabel: 'active focusWithTex',
        });
    };

    inputFocusAnimationRemove = () => {
        if (this.props.values.email === '') {
            this.setState({
                classLabel: '',
            });
        }
    };

    validateForm() {
        const errors = {};
        let formIsValid = true;
        const { email } = this.props.values;
        const pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        const errorField = document.getElementById('Form-errors');

        if (!pattern.test(email)) {
            formIsValid = false;
            errors.emailid = 'Įveskite el. pašto adresą';
            errorField.classList.remove('u-display-none');
        }

        this.setState({
            errors
        });
        return formIsValid;
    }

    render() {
        const { values } = this.props;
        const { classLabel } = this.state;
        const { emailid } = this.state.errors;

        return (
            <div>
                <Avatar />

                <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                <div className={'Form-item ' + classLabel}>
                    <label htmlFor="floatField"> El. paštas </label>
                    <input
                        id="inputEmail"
                        type="email"
                        name="email"
                        defaultValue={values.firstName}
                        onChange={this.props.handleChange('email')}
                        onKeyDown={this._handleKeyDown}
                        onFocus={this.inputFocusAnimation}
                        onBlur={this.inputFocusAnimationRemove}
                        required
                    />
                    <div
                        id="Form-errors"
                        className="Form-errors u-margin-bottom u-display-none"
                    >
                        <li>{emailid}</li>
                    </div>
                </div>

                <div className="u-align-center u-margin-bottom">
                    <button
                        className="Button Button--blue Button--long"
                        onClick={this.saveAndContinue}
                        type="submit"
                    >
                        Toliau
                    </button>
                </div>

                <div className="u-margin-bottom u-align-center">
                    <a
                        className="Button Button--smallPadding u-align-middle u-not-link"
                        href="/connect/google"
                    >
                        <i className="Image--icon fab fa-google u-color-red u-margin-small-left-right" />
                        <span>Prisijunk su Google</span>
                    </a>
                </div>
                <p className="Header4">
                    Dar neturi paskyros?
                    <a id="registerLink" href="/register">
                        &nbsp;Registruotis!
                    </a>
                </p>
            </div>
        );
    }
}

export default LoginEmail;
