import React, { Component } from 'react';
import Avatar from '../loginAvatar/loginAvatar.jsx';

class LoginPassword extends Component{

    saveAndContinue = (e) => {
        e.preventDefault()
        this.props.nextStep()
    };

    render(){
        const { values } = this.props;
        const csrf_token = document.getElementById('csrf_token').value;
        return(
            <form  method="post" className="Form Form-background Form--short">
                {/*<Avatar />*/}

                <h3 className="u-text-center u-margin-bottom">Prisijungti</h3>

                <input id="csrf_token"
                       type="hidden"
                       name="_csrf_token"
                       value={csrf_token}
                />
                <input type="text"
                       name="email"
                       id="inputEmail"
                       hidden
                       defaultValue={values.email}
                />

                <div className="Form-item">
                    {/*<label htmlFor="floatField">Slaptažodis</label>*/}
                    <input type="password"
                           name="password"
                           id="inputPassword"
                           placeholder="Slaptažodis"
                           required
                           onChange={this.props.handleChange('password')}
                           defaultValue={values.password}
                    />
                </div>


                    <button className="Button Button--blue Button--long" type="submit"> Prisijungti</button>

            </form>
        )
    }
}

export default LoginPassword;
