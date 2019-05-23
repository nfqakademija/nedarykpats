import React, { Component } from 'react';
import LoginComputerImage from '../loginImages/loginComputerImage.jsx';


class LoginNeedRegistration extends Component{

    render(){
        const { email } = this.props.values;
        return(
            <div>
                <LoginComputerImage />

                <h3 className="u-text-center u-margin-bottom">Jūs neturite paskyros</h3>
                <p className="u-text-center">{email}</p>

                <div className="u-margin-top u-align-center">
                    <a href="/register" className="Button Button--blue"> Užregistruoti </a>
                </div>

                <div className="u-align-center">
                    <a className="Button Button--empty"
                       href="/login"
                    >
                        Atgal
                    </a>
                </div>
            </div>
        )
    }
}

export default LoginNeedRegistration;
