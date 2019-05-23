import React, { Component } from 'react';
import LoginAvatarMistake from '../loginImages/loginAvatarMistake.jsx';

class LoginMistake extends Component{
    render(){
        return(
            <div>
                <LoginAvatarMistake />

                <h3 className="u-text-center">Atsiprašome, įvyko klaida</h3>
                <p className="u-text-center">Pabandykite dar kartą</p>

                <div className="u-margin-top u-align-center">
                    <a
                        className="Button Button--blue"
                        href="/login"
                    >
                        Grįžti
                    </a>
                </div>

                <div className="u-align-center">
                    <a href="/"
                       className="Button Button--empty"> Į pagrindinį </a>
                </div>
            </div>
        )
    }
}

export default LoginMistake;
