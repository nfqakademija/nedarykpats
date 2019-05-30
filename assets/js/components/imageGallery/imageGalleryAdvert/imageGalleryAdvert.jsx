import React from 'react';
import ImageGallery from 'react-image-gallery';
import axios from 'axios';

// const PREFIX_URL = 'https://raw.githubusercontent.com/xiaolin/react-image-gallery/master/static/';

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
            photos: []
        };
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
        const  { photosJson, photos } = this.state;
        photosJson.forEach(function(element) {
            photos.push({
                original: element.src,
                thumbnail: element.src,
            });
        });

        return photos;
    }

    getImages = () => {
        const advert = this.props.advertId;

        this.setState( () => {
            axios.get('/api/public/gallery?advert=' + advert)
                .then( response =>  {
                    this.setState({
                        photosJson: response.data
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
        const { photos } = this.state;
        this.state.photos = [].concat(this.formatImagesArray());

        return (
            <ImageGallery
                ref={i => this._imageGallery = i}
                items={photos}
                lazyLoad={false}
                onClick={this._onImageClick.bind(this)}
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
            />
        );
    }
}

export default AdvertImages;
