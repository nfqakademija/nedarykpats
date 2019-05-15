import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import Email from '../.././components/login/loginEmail/loginEmail.jsx';
import Password from '../.././components/login/loginPassword/loginPassword.jsx';
import Success from '../.././components/login/loginSuccess/loginSuccess.jsx';
import SendEmail from '../.././components/login/loginSendEmail/loginSendEmail.jsx';
import Registration from '../registration/registration.jsx';
import LoadingSpinner from '../loadingSpinner/loadingSpinner.jsx';

import axios from "axios";

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
        };
    }

    nextStep = () => {
        const { step } = this.state
        this.setState({
            step : step + 1
        })
    };

    handleChange = input => event => {
        this.setState({ [input] : event.target.value })
    };

    nextStepValue = (stepValue) => {
        this.setState({
            step : stepValue
        })
    }

    signIn = () => {
        const { email, password } = this.state;
    };

    checkEmail = () => {
        const { email } = this.state;
        const { step } = this.state;
        const { nextStepValue } = this;

        this.setState({ loading: true }, () => {
            axios.get(`http://127.0.0.1:8000/check/email/`+ email)
                .then(res => {

                    this.setState({
                        loading: false,
                        data: res.data,
                    });

                    if (res.data.isEmail) {

                        if (res.data.isSingleUser) {
                            nextStepValue(4);
                        }
                        else {
                            nextStepValue(2);
                        }
                    }
                    else {
                        nextStepValue(5);
                    }
                })
                .catch(function (error) {

                });
        });
    };

    render() {

        const { step, isEmail } = this.state;
        const { email, password } = this.state;
        const values = { email, password };
        const { data, loading } = this.state;

        switch(step) {
            case 1:
                return (
                    <div>
                        {loading ? <LoadingSpinner/> :
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
                        {loading ? <LoadingSpinner/> :
                            <Password
                                nextStep={this.nextStep}
                                handleChange={this.handleChange}
                                values={values}
                                results={data}
                            />
                        }
                    </div>
                    )
            case 3:
                return <Success />
            case 4:
                return <SendEmail />
            case 5:
                return <Registration />

        }
    }
}

export default Login;
