import React, { Component } from 'react';
import LoginWasSentImage from '../loginImages/loginWasSentImage.jsx';

class LoginSendEmail extends Component{

    constructor() {
        super();
        this.state = {
            providerLink: 'www.google.com'
        };
    }

    findEmailProvider = () => {
        const { email } = this.props.values;
        const domain = email.substring(email.lastIndexOf("@") +1);
        const domainArray = ['google.com', 'yahoo.com', 'mailinator.com'];

        if (domain in domainArray) {
            this.state.providerLink = 'www.' + domain;
        }
    };

    onSubmit = e => {
        e.preventDefault();
        window.location.href = this.state.providerLink;
    }

    render(){
        const { email } = this.props.values;

        this.findEmailProvider();

        return(
            <div>
                <LoginWasSentImage />

                <h3 className="u-text-center u-margin-bottom">Išsiuntėme  prisijungimo nuorodą el. paštu </h3>
                <p className="u-text-center">{email}</p>

                <div className="u-margin-top u-align-center">
                    <button
                       className="Button Button--blue"
                       onClick={this.onSubmit}
                    >
                        Eiti į el. paštą
                    </button>
                </div>

                <div className="u-align-center">
                    <a href="/"
                       className="Button Button--empty"> Pagrindinis </a>
                </div>
            </div>
        )
    }
}

export default LoginSendEmail;
