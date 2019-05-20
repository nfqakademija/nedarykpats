import React, { Component } from 'react';
import Avatar from '../login/loginAvatar/loginAvatar.jsx';

class Registration extends Component{
    render(){
        return(
            <div className="Form Form-background Form--short">
                <Avatar />

                <h3 className="u-text-center u-margin-bottom">Jūs neturrite paskyros</h3>

                <div className="u-margin-top-bottom u-align-center">
                    <a href="/register" className="Button Button--blue"> Užregistruoti </a>
                </div>
            </div>
        )
    }
}

export default Registration;
