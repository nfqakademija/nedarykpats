import React, { Component } from 'react';

class LoginWasSentImage extends Component {

    render() {
        return (
            <div className="Form-avatar u-align-center u-margin-top-bottom">
                <div className="avatarContainer">
                    <img
                        className="u-width-100 u-no-border"
                        src="/img/lektuvas.png"
                        alt="Email was sent"
                    />
                </div>
            </div>
        );
    }
}

export default LoginWasSentImage;
