import React, {useCallback} from 'react'
import Dropzone from 'react-dropzone'

class ImageGalleryUpload extends React.Component {
    onDrop = (acceptedFiles) => {
        console.log(acceptedFiles);
    };

    uploadImageToServer = () => {
        const uploadInputDom = document.getElementById('image_gallery_form_imageFile');
        console.log(uploadInputDom);
        // uploadInputDom.value='test';

        uploadInputDom.addEventListener("click", function() {
            Dropzone.processQueue(); // Tell Dropzone to process all queued files.
        });
    }

    render() {
        const maxSize = 1048576;
        this.uploadImageToServer();

        Dropzone.autoDiscover = false;

        return (
            <div className="u-margin-bottom">
                <Dropzone
                    onDrop={this.onDrop}
                    accept="image/png, image/gif"
                    minSize={0}
                    maxSize={maxSize}
                    multiple
                    autoDiscover={false}
                >
                    {({getRootProps, getInputProps, isDragActive, isDragReject, rejectedFiles, acceptedFiles}) => {
                        const isFileTooLarge = rejectedFiles.length > 0 && rejectedFiles[0].size > maxSize;
                        return (
                                <div className="Form-uploadImagesArea"
                                     {...getRootProps()}
                                >

                                    <img width="50" src="img/upload.png" alt="upload image"/>
                                    <input id="image_gallery_form_imageFile"
                                           type="file"
                                           {...getInputProps()}
                                    />

                                    {!isDragActive && 'Paspauskite arba įtemkite failą!'}
                                    {isDragActive && !isDragReject && "Paleiskite failą!"}
                                    {isDragReject && "Atsiprašome, įkeliamo failo tipas nėra tinkamas!"}
                                    {isFileTooLarge && (
                                        <div className="text-danger mt-2">
                                            Filas per didelis.
                                        </div>
                                    )}
                                    <ul className="list-group mt-2">
                                        {acceptedFiles.length > 0 && acceptedFiles.map(acceptedFile => (
                                            <li key={acceptedFiles.name + acceptedFiles.size} className="list-group-item list-group-item-success">
                                                {acceptedFile.name}
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                        )}
                    }
                </Dropzone>
            </div>
        );
    }
}

export default ImageGalleryUpload;
