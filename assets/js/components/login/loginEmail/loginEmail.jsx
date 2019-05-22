import React, { Component } from 'react';
import Avatar from '../loginImages/loginAvatar.jsx';

class LoginEmail extends Component{

    saveAndContinue = e => {
        e.preventDefault();
        this.props.nextStep();
    };

    _handleKeyDown = e => {
        if (e.key === 'Enter') {
            this.saveAndContinue(e);
        }
    };

    render(){
        const { values } = this.props;
        const csrf_token = document.getElementById('csrf_token').value;

        return(
            <div>
                <Avatar />

                <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                <div className="Form-item">
                    <label htmlFor="floatField">El. paštas</label>
                    <input id="inputEmail"
                           type="email"
                           name="email"
                           onChange={this.props.handleChange('email')}
                           onKeyDown={this._handleKeyDown}
                           defaultValue={values.firstName}
                           required
                    />
                </div>

                <input id="csrf_token"
                       type="hidden"
                       name="_csrf_token"
                       value={csrf_token}
                />

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
