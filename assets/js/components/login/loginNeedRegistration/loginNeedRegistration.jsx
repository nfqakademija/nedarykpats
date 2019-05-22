import React, { Component } from 'react';
import LoginComputerImage from '../loginImages/loginComputerImage.jsx';


class LoginNeedRegistration extends Component{
    render(){
        return(
            <div>
                <LoginComputerImage />

                <h3 className="u-text-center u-margin-bottom">Jūs neturite paskyros</h3>

                <div className="u-margin-top-bottom u-align-center">
                    <a href="/register" className="Button Button--blue"> Užregistruoti </a>
                </div>
            </div>
        )
    }
}

export default LoginNeedRegistration;
