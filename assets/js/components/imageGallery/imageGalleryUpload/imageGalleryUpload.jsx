import React, {useCallback} from 'react'
import Dropzone from 'react-dropzone'

class ImageGalleryUpload extends React.Component {

    render() {
        const maxSize = 1048576;

        Dropzone.autoDiscover = false;

        return (
            <div className="u-margin-bottom u-text-center">
                <Dropzone
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
                                <input id="image_gallery_form_imageFile1"
                                       name="image_gallery_form[imageFile][]"
                                       type="file"
                                       {...getInputProps()}
                                />

                                {!isDragActive && 'Paspauskite arba įtemkite failą!'}
                                {isDragActive && !isDragReject && "Paleiskite failą!"}
                                {isDragReject && "Atsiprašome, įkeliamo failo tipas nėra tinkamas!"}
                                {isFileTooLarge && (
                                    <div className="u-color-red">
                                        Failas per didelis (iki 1MB).
                                    </div>
                                )}
                                <ul className="list-group mt-2">
                                    {acceptedFiles.length > 0 && acceptedFiles.map(acceptedFile => (
                                        <li key={acceptedFiles.name + acceptedFiles.size} className="">
                                            {acceptedFile.name}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        )}
                    }
                </Dropzone>
                <input type="submit" className="Button Button--blue u-margin-top" value="Įkelti"/>
            </div>
        );
    }
}

export default ImageGalleryUpload;
