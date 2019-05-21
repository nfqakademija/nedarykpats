import React, { Component } from 'react';
import LoginWasSentImage from '../loginImages/loginWasSentImage.jsx';

class LoginSendEmail extends Component{

    render(){
        return(
            <div className="Form Form-background Form--short">
                <LoginWasSentImage />

                <h3 className="u-text-center u-margin-bottom">Išsiuntėme  prisijungimo nuorodą el. paštu</h3>

                <div className="u-margin-top-bottom u-align-center">
                    <a href="#" className="Button Button--blue"> Gerai </a>
                </div>
            </div>
        )
    }
}

export default LoginSendEmail;
