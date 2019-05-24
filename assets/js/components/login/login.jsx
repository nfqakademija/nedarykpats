import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";

import Email from './loginEmail/loginEmail.jsx';
import Password from './loginPassword/loginPassword.jsx';
import Success from './loginSuccess/loginSuccess.jsx';
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
            error: ''
        };
    }

    nextStep = () => {
        const { step } = this.state
        this.setState({
            step : step + 1,
            error : ''
        })
    };

    prevStep = () => {
        const { step } = this.state;
        this.setState({
            step: step - 1,
            error : ''
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
        const { email } = this.state;
        const { step } = this.state;
        const { nextStepValue } = this;
        const token = this.props.feedbackToken;

        this.setState({ loading: true }, () => {
            this.setState({ loading: true }, () => {
                axios.get('http://127.0.0.1:8000/api/public/user?email=' + email + '&_token=' + token)
                    .then( response =>  {
                        setTimeout(function(){
                            console.log(response);
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
                        }.bind(this), 2000);
                    })
                    .catch(function (error) {
                        console.log(error);
                        nextStepValue(5);
                    });
            });
        });
    };

    tryToLogin = () => {
        const { email } = this.state;
        const { error } = this.state;
        const { password } = this.state;
        const { step } = this.state;
        const { nextStepValue } = this;
        const token = this.props.feedbackToken;

        this.setState({ loading: true }, () => {
            this.setState({ loading: true }, () => {
                axios.post('http://127.0.0.1:8000/login', {
                    email: email,
                    _token: token,
                    password: password
                })
                .then( response =>  {
                   setTimeout(function(){
                        console.log(response);
                        this.setState({
                            loading: false,
                            data: response.data,
                            error: ''
                        });
                        window.location.href = '/';
                       nextStepValue(3);
                   }.bind(this), 2000);
                })
                .catch(function (error) {
                    console.log(error);
                    this.setState({
                        loading: false,
                        error: 'Jūsų slaptažodis neteisingas'
                    });
                    nextStepValue(2);
                }.bind(this));
            });
        });
    };

    sendSingleLoginLink = () => {
        const { nextStep } = this;
        const { email } = this.state;
        const { nextStepValue } = this;
        const token = this.props.feedbackToken;

        this.setState({ loading: true }, () => {
            axios
                .post('http://127.0.0.1:8000/api/public/user/send_login_link', {
                    email: email,
                    _token: token
                })
                .then(function(response) {
                    setTimeout(function(){
                        console.log(response);
                        nextStepValue(4);
                    }.bind(this), 2000);
                })
                .catch(function(error) {
                    console.log(error);
                    nextStepValue(6);
                });
        });
    };

    makeRegistration = () => {
        const { nextStep } = this;
        const { email, password } = this.state;
        const { nextStepValue } = this;

        console.log('makeRegistration');
        this.setState({ loading: true }, () => {
            axios
                .post('http://127.0.0.1:8000/api/public/user/', {
                    email: email,
                    password: password
                })
                .then(function(response) {
                    setTimeout(function(){
                        console.log(response);
                        nextStepValue(4);
                    }.bind(this), 2000);
                })
                .catch(function(error) {
                    console.log(error);
                    nextStepValue(6);
                });
        });
    };

    render() {
        const { email, password, step, error } = this.state;
        const values = { email, password, error };
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
                                values={values}
                                results={data}
                                tryToLogin={this.tryToLogin}
                                sendSingleLoginLink={this.sendSingleLoginLink}
                            />
                        }
                    </div>
                    )
            case 3:
                return <Success />
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
