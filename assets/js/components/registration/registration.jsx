import React, { Component } from 'react';

class Registration extends Component{
    render(){
        return(
            <div className="Form Form-background Form--short">
                <h1>Jūsų neužsiregistarvęs!</h1>

                <div className="u-margin-top-bottom u-align-center">
                    <a href="#" className="Button Button--blue"> Užregistruoti </a>
                </div>
            </div>
        )
    }
}

export default Registration;
