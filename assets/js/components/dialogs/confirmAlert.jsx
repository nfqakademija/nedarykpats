confirmAlert({
    customUI: ({ onClose }) => {
        return (
            <div className='custom-ui'>
                <h1>Are you sure?</h1>
                <p>You want to delete this file?</p>
            </div>
        );
    }
});
