import React, { Component } from 'react';
import Avatar from '../loginImages/loginAvatar.jsx';

class LoginPassword extends Component {

    constructor() {
        super();
        this.state = {
            classLabel: ''
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
        this.setState({
            classLabel: 'active focusWithTex',
        });
    };

    inputFocusAnimationRemove = () => {
        if (this.props.values.password === '') {
            this.setState({
                classLabel: '',
            });
        }
    };

    componenDidMount() {
        if (this.props.values.password) {
            this.inputFocusAnimation();
        }
    }

    render(){
        const { values } = this.props;
        const { classLabel } = this.state;
        const css = this.props.values.errorStyle;

        return(
            <div>
                <div>
                    <Avatar />

                    <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                    <div className={'Form-item ' + classLabel}>
                        <label
                            htmlFor="floatField">
                            Slaptažodis
                        </label>
                        <input id="inputPassword"
                               type="password"
                               name="password"
                               required
                               autoFocus
                               onChange={this.props.handleChange('password')}
                               onKeyDown={this._handleKeyDown}
                               defaultValue={values.password}
                               onFocus={this.inputFocusAnimation}
                               onBlur={this.inputFocusAnimationRemove}
                        />
                        <div id="Form-errors"
                             className={'Form-errors u-margin-bottom ' + css}>
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
