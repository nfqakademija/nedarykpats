import React, { Component } from 'react';
import Avatar from '../loginImages/loginAvatar.jsx';

class LoginEmail extends Component{

    constructor() {
        super();
        this.state = {
            errors: {},
        };
    }

    validateForm() {
        let errors = {};
        let formIsValid = true;
        const { email } = this.props.values;
        const pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        let errorField = document.getElementById('Form-errors');

        if (!pattern.test(email)) {
            formIsValid = false;
            errors["emailid"] = "Įveskite el. pašto adresą";
            errorField.classList.remove('u-display-none');
        }

        this.setState({
            errors: errors
        });
        return formIsValid;
    }

    saveAndContinue = e => {
        if (this.validateForm()) {
            e.preventDefault();
            this.props.nextStep();
        };
    };

    _handleKeyDown = e => {
        if (e.key === 'Enter') {
            this.saveAndContinue(e);
        }
    };

    render(){
        const { values } = this.props;

        return(
            <div>
                <Avatar />

                <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                <div className="Form-item">
                    <label htmlFor="floatField">El. paštas</label>
                    <input id="inputEmail"
                           type="email"
                           name="email"
                           defaultValue={values.firstName}
                           onChange={this.props.handleChange('email')}
                           onKeyDown={this._handleKeyDown}
                           required
                    />
                    <div id="Form-errors" className="Form-errors u-margin-bottom u-display-none">
                        <li>{this.state.errors.emailid}</li>
                    </div>
                </div>

                <div className="u-align-center">
                    <a className="Button Button--blue Button--long"
                       onClick={this.saveAndContinue}
                    >Toliau </a>
                </div>

                <div className="u-margin-top-bottom u-align-center">
                    <a className="u-not-link" href="http://127.0.0.1:8000/connect/google">
                        <p>Arba prisijungti per:
                            <i className="Image--icon fab fa-google u-color-red u-margin-small-left-right"></i>
                        </p>
                    </a>
                </div>
                <p className="Header4">Dar neturi paskyros? <a id="registerLink" href="http://127.0.0.1:8000/register">Registruotis!</a></p>
            </div>
        );
    }
}

export default LoginEmail;
