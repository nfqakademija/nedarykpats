import React, { Component } from 'react';
import LoginWasSentImage from '../loginImages/loginWasSentImage.jsx';

class LoginSendEmail extends Component{

    render(){
        const { email } = this.props.values;

        return(
            <div>
                <LoginWasSentImage />

                <h3 className="u-text-center u-margin-bottom">Išsiuntėme  prisijungimo nuorodą el. paštu </h3>
                <p className="u-text-center">{email}</p>

                <div className="u-margin-top-bottom u-align-center">
                    <a href="#" className="Button Button--blue"> Gerai </a>
                </div>
            </div>
        )
    }
}

export default LoginSendEmail;
