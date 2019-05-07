import React from 'react';
import { confirmAlert } from 'react-confirm-alert'; // Import
import 'react-confirm-alert/src/react-confirm-alert.css'; // Import css

class AlertDialog extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            title: this.props.alertTitle,
            message: this.props.alertMessage,
        };
    }

    showDialog = () => {

         confirmAlert({
            title: this.props.alertTitle,
            message: this.props.alertMessage,
        });
    };

    render() {
        const showAlert = this.props.alertShow;
        if (showAlert === true) {
            this.showDialog();
        }
        return (null);
    }
}

export default AlertDialog;
