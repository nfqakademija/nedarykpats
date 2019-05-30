import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";

import Email from './loginEmail/loginEmail.jsx';
import Password from './loginPassword/loginPassword.jsx';
import SendEmail from './loginSendEmail/loginSendEmail.jsx';
import LoginNeedRegistration from './loginNeedRegistration/loginNeedRegistration.jsx';
import Mistake from './loginMistake/loginMistake.jsx';
import LoginSpinner from './loginSpinner/loginSpinner';

class Login extends Component {

    constructor() {
        super();
        this.state = {
            step: 1,
            email: '',
            password: '',
            isEmail: '',
            data: [],
            loading: false,
            error: '',
            errorStyle: 'u-display-none',
            DELAY_TIME: '1250'
        };
    }

    nextStep = () => {
        const { step } = this.state;
        this.setState({
            step : step + 1,
            error : '',
            errorStyle: 'u-display-none'
        })
    };

    prevStep = () => {
        const { step } = this.state;
        this.setState({
            step: step - 1,
            error : '',
            errorStyle: 'u-display-none'
        });
    };

    handleChange = input => event => {
        this.setState({ [input] : event.target.value })
    };

    nextStepValue = (stepValue) => {
        this.setState({
            step : stepValue
        })
    };

    login = () => {
        const { nextStepValue } = this;
        nextStepValue(1);
    };

    checkEmail = () => {
        const { email, step } = this.state;
        const { DELAY_TIME } = this.state;
        const { nextStepValue } = this;
        const token = this.props.authenticate;

        this.setState({ loading: true }, () => {
            this.setState({ loading: true }, () => {
                axios.get('/api/public/user?email=' + email + '&csrf_token=' + token)
                .then( response =>  {
                    setTimeout(function(){
                        this.setState({
                            loading: false,
                            data: response.data
                        });
                        if (response.data.authenticateUsingPassword) {
                            nextStepValue(2);
                        }
                        else {
                            this.sendSingleLoginLink();
                        }
                    }.bind(this), DELAY_TIME);
                })
                .catch(function (error) {
                    setTimeout(function(){
                        window.location.href = '/register?email=' + email;
                    }.bind(this), DELAY_TIME);
                });
            });
        });
    };

    tryToLogin = () => {
        const { email, password, step } = this.state;
        const { error, errorStyle } = this.state;
        const { DELAY_TIME } = this.state;
        const { nextStepValue } = this;
        const token = this.props.authenticate;

        this.setState({ loading: true }, () => {
            this.setState({ loading: true }, () => {
                axios.post('/api/public/user/login', {
                    email: email,
                    csrf_token: token,
                    password: password
                })
                .then( response =>  {
                   setTimeout(function(){
                        this.setState({
                            loading: false,
                            data: response.data,
                            error: '',
                            errorStyle: 'u-display-none'
                        });
                        window.location.href = '/';
                       nextStepValue(3);
                   }.bind(this), DELAY_TIME);
                })
                .catch(function (error) {
                    this.setState({
                        loading: false,
                        error: 'Jūsų slaptažodis neteisingas',
                        errorStyle: ''
                    });
                    nextStepValue(2);
                }.bind(this));
            });
        });
    };

    sendSingleLoginLink = () => {
        const { nextStep } = this;
        const { email } = this.state;
        const { DELAY_TIME } = this.state;
        const { nextStepValue } = this;
        const token = this.props.authenticate;

        this.setState({ loading: true }, () => {
            axios
                .post('/api/public/user/send_login_link', {
                    email: email,
                    csrf_token: token
                })
                .then(function(response) {
                    setTimeout(function(){
                        nextStepValue(4);
                    }.bind(this), DELAY_TIME);
                })
                .catch(function(error) {
                    nextStepValue(6);
                });
        });
    };

    makeRegistration = () => {
        const { email, password, nextStep } = this.state;
        const { DELAY_TIME } = this;
        const { nextStepValue } = this;

        this.setState({ loading: true }, () => {
            axios
                .post('/api/public/user/', {
                    email: email,
                    password: password
                })
                .then(function(response) {
                    setTimeout(function(){
                        nextStepValue(4);
                    }.bind(this), DELAY_TIME);
                })
                .catch(function(error) {
                    nextStepValue(6);
                });
        });
    };

    render() {
        const { email, password, step, error, errorStyle } = this.state;
        const values = { email, password, error, errorStyle };
        const { data, loading } = this.state;

        switch(step) {
            case 1:
                return (
                    <div>
                        {loading ? <LoginSpinner/> :
                            <Email
                                nextStep={this.checkEmail}
                                handleChange={this.handleChange}
                                values={values}
                                results={data}
                            />
                        }
                    </div>
                )
            case 2:
                return (
                    <div>
                        {loading ? <LoginSpinner/> :
                            <Password
                                prevStep={this.prevStep}
                                handleChange={this.handleChange}
                                tryToLogin={this.tryToLogin}
                                sendSingleLoginLink={this.sendSingleLoginLink}
                                values={values}
                                results={data}
                            />
                        }
                    </div>
                    )
            case 3:
                return <LoginSpinner />
            case 4:
                return <SendEmail
                    values={values}
                />
            case 5:
                return <LoginNeedRegistration
                    values={values}
                    goHomeStep={this.goHomeStep}
                />
            case 6:
                return <Mistake />
        }
    }
}

export default Login;
