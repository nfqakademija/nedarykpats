import React, {useCallback} from 'react'
import Dropzone from 'react-dropzone'

class ImageGalleryUploadAdvert extends React.Component {

    render() {
        const maxSize = 1048576;

        Dropzone.autoDiscover = false;

        return (
            <div className="u-margin-bottom u-text-center">
                <Dropzone
                    accept="image/png, image/gif, image/jpeg"
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
                                <input id="advert_imageGallery"
                                       name="advert[imageGallery][]"
                                       type="file"
                                       {...getInputProps()}
                                />

                                {!isDragActive && 'Paspauskite arba įtempkite failą!'}
                                {isDragActive && !isDragReject && "Paleiskite failą!"}
                                {isDragReject && "Atsiprašome, įkeliamo failo tipas nėra tinkamas!"}
                                {isFileTooLarge && (
                                    <div className="u-color-red">
                                        Failas per didelis (iki 1MB).
                                    </div>
                                )}
                                <ul className="u-no-bullets">
                                    {acceptedFiles.length > 0 && acceptedFiles.map(acceptedFile => (
                                        <li key={acceptedFiles.path + Math.random().toString()} className="">
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

export default ImageGalleryUploadAdvert;
