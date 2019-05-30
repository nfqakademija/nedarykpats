import React from 'react';
import Gallery from 'react-photo-gallery';
import Lightbox from 'react-images';
import axios from 'axios';

class ImageGalleryProfile extends React.Component {

    constructor() {
        super();
        this.state = {
            currentImage: 0,
            photos: [],
            user: ''
        };
        this.closeLightbox = this.closeLightbox.bind(this);
        this.openLightbox = this.openLightbox.bind(this);
        this.gotoNext = this.gotoNext.bind(this);
        this.gotoPrevious = this.gotoPrevious.bind(this);
    }

    getImages = () => {
        const user = this.props.userId;
        this.setState( () => {
            axios.get('/api/public/gallery?user=' + user)
            .then( response =>  {
                this.setState({
                    photos: response.data
                });
            })
            .catch(function (error) {
            });
        });
    };

  componentDidMount() {
      this.getImages();
  }

    openLightbox(event, obj) {
        this.setState({
            currentImage: obj.index,
            lightboxIsOpen: true,
        });
    }
    closeLightbox() {
        this.setState({
            currentImage: 0,
            lightboxIsOpen: false,
        });
    }
    gotoPrevious() {
        this.setState({
            currentImage: this.state.currentImage - 1,
        });
    }
    gotoNext() {
        this.setState({
            currentImage: this.state.currentImage + 1,
        });
    }
    render() {
        const { photos } = this.state;

        return (
            <div>
                <Gallery photos={photos} onClick={this.openLightbox} />
                <Lightbox images={photos}
                          onClose={this.closeLightbox}
                          onClickPrev={this.gotoPrevious}
                          onClickNext={this.gotoNext}
                          currentImage={this.state.currentImage}
                          isOpen={this.state.lightboxIsOpen}
                />
            </div>
        )
    }
}

export default ImageGalleryProfile;
