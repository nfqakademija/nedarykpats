import React, { Component } from 'react';
import Avatar from '../loginAvatar/loginAvatar.jsx';

class LoginPassword extends Component{

    saveAndContinue = (e) => {
        e.preventDefault()
        this.props.nextStep()
    };

    render(){
        const { values } = this.props;
        return(
            <form className="Form Form-background Form--short" onSubmit={this.submitForm}>
                <Avatar />
                <div className="Form-item">
                    <label htmlFor="floatField">Slaptažodis</label>
                    <input type="password" name="password" id="inputPassword3" required
                           onChange={this.props.handleChange('password')}
                           defaultValue={values.password}
                    />
                </div>
                <div className="u-margin-top-bottom u-align-center">
                    <a className="Button Button--blue" onClick={this.saveAndContinue}>Prisijungti </a>
                </div>
                {/*<button className="Button Button--blue Button--long" type="submit">Prisijungti Test</button>*/}
            </form>
        )
    }
}

export default LoginPassword;
