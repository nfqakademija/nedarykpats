import React, { Component } from 'react';
import axios from "axios";
import Avatar from '../loginAvatar/loginAvatar.jsx';

class LoginSendEmail extends Component{

    loginWithPassword = () => {
        console.log('atejau');
        this.setState({ loading: true }, () => {
            axios
                .post('http://127.0.0.1:8000//api/public/user/send_login_link', {
                    email: 'martyna@uzsakove.lt'
                })
                .then(function(response) {
                    console.log(response);
                    // nextStep();
                })
                .catch(function(error) {
                    console.log(error);
                    // nextStep();
                });
        });
    };

    render(){
        return(
            <div className="Form Form-background Form--short">
                <Avatar />

                <h3 className="u-text-center u-margin-bottom">Išsiuntėme  prisijungimo nuorodą el. paštu</h3>

                <div className="u-margin-top-bottom u-align-center">
                    <a href="#" className="Button Button--blue"> Gerai </a>
                </div>
            </div>
        )
    }
}

export default LoginSendEmail;
