import React, { Component } from 'react';
import RegistrationIconComputer from '../.././components/registration/registrationIcon/registartionIconComputer.jsx';


class Registration extends Component{
    render(){
        return(
            <div className="Form Form-background Form--short">
                <RegistrationIconComputer />

                <h3 className="u-text-center u-margin-bottom">Jūs neturite paskyros</h3>

                <div className="u-margin-top-bottom u-align-center">
                    <a href="/register" className="Button Button--blue"> Užregistruoti </a>
                </div>
            </div>
        )
    }
}

export default Registration;
