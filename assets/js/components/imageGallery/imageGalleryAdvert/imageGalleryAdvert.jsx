import React from 'react';
import ImageGallery from 'react-image-gallery';
import axios from 'axios';
import Lightbox from 'react-images';

class AdvertImages extends React.Component {
    constructor() {
        super();
        this.state = {
            showIndex: false,
            showBullets: true,
            infinite: true,
            showThumbnails: true,
            showNav: true,
            isRTL: false,
            slideDuration: 450,
            slideInterval: 2000,
            slideOnThumbnailOver: false,
            thumbnailPosition: 'bottom',
            photosJson: [],
            photos: [],
            currentImage: 0,
        };

        this.closeLightbox = this.closeLightbox.bind(this);
        this.openLightbox = this.openLightbox.bind(this);
        this.gotoNext = this.gotoNext.bind(this);
        this.gotoPrevious = this.gotoPrevious.bind(this);
    }

    _onImageClick(event) {
        console.debug('clicked on image', event.target, 'at index', this._imageGallery.getCurrentIndex());
    }

    _handleInputChange(state, event) {
        this.setState({[state]: event.target.value});
    }

    _handleCheckboxChange(state, event) {
        this.setState({[state]: event.target.checked});
    }

    _handleThumbnailPositionChange(event) {
        this.setState({thumbnailPosition: event.target.value});
    }

    formatImagesArray() {
        const  { photosJson } = this.state;
        const photos = [];
        photosJson.forEach(function(element) {
            photos.push({
                original: element.src,
                thumbnail: element.src,
            });
        });

        return photos;
    }

    openLightbox(event, obj) {
        this.setState({
            currentImage:  1,
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

    getImages = () => {
        const advert = this.props.advertId;

        this.setState( () => {
            axios.get('/api/public/gallery?advert=' + advert)
                .then( response =>  {
                    this.setState({
                        photosJson: response.data,
                        photos: this.formatImagesArray()
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    };

    componentDidMount() {
        this.getImages();
    }

    render() {
        const { photosJson } = this.state;
        const photos = this.formatImagesArray();

        return (
            <div>
                <ImageGallery
                    ref={i => this._imageGallery = i}
                    items={photos}
                    lazyLoad={false}
                    infinite={this.state.infinite}
                    showBullets={this.state.showBullets}
                    showThumbnails={this.state.showThumbnails}
                    showIndex={this.state.showIndex}
                    showNav={this.state.showNav}
                    isRTL={this.state.isRTL}
                    thumbnailPosition={this.state.thumbnailPosition}
                    slideDuration={parseInt(this.state.slideDuration)}
                    slideInterval={parseInt(this.state.slideInterval)}
                    slideOnThumbnailOver={this.state.slideOnThumbnailOver}
                    additionalClass="app-image-gallery"
                    onClick={this.openLightbox}
                />
                <Lightbox images={photosJson}
                    onClose={this.closeLightbox}
                    onClickPrev={this.gotoPrevious}
                    onClickNext={this.gotoNext}
                    currentImage={this.state.currentImage}
                    isOpen={this.state.lightboxIsOpen}
                    />
            </div>
        );
    }
}

export default AdvertImages;
