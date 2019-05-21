import React, { Component } from 'react';
import { throws } from 'assert';

class RegistrationIconComputer extends Component{

    render(){

        return(
            <div className="Form-avatar u-align-center u-margin-top-bottom">

                {/*<div className="avatarContainer">*/}
                <div className="avatarContainer">
                    <img
                        className="u-width-100 u-no-border"
                        src="/img/login-computer.png"
                        alt="Email was sent"
                    />
                </div>
            </div>
        )
    }
}

export default RegistrationIconComputer;
