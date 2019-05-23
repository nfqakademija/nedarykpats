import React, { Component } from 'react';
import { throws } from 'assert';

class LoginAvatarMistake extends Component{

    render(){

        return(
            <div className="Form-avatar u-align-center u-margin-top-bottom">

                <div className="avatarContainer">
                    <img
                        className="u-width-100 u-no-border"
                        src="/img/login-wrong.png"
                        alt="Email was sent"
                    />
                </div>
            </div>
        )
    }
}

export default LoginAvatarMistake;
