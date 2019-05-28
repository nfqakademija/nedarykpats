import React from 'react';
import ImageGallery from 'react-image-gallery';

const PREFIX_URL = 'https://raw.githubusercontent.com/xiaolin/react-image-gallery/master/static/';

class ImageGalleryAdvert2 extends React.Component {
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

            advert: ''
        };

        this.images = [
            {
                thumbnail: `${PREFIX_URL}4v.jpg`,
                original: `${PREFIX_URL}4v.jpg`,
                description: '',
            },
            {
                original: `${PREFIX_URL}image_set_default.jpg`,
                thumbnail: `${PREFIX_URL}image_set_thumb.jpg`,
                imageSet: [
                    {
                        srcSet: `${PREFIX_URL}image_set_cropped.jpg`,
                        media : '(max-width: 1280px)',
                    },
                    {
                        srcSet: `${PREFIX_URL}image_set_default.jpg`,
                        media : '(min-width: 1280px)',
                    }
                ]
            },
            {
                original: `${PREFIX_URL}1.jpg`,
                thumbnail: `${PREFIX_URL}1t.jpg`,
                originalClass: 'featured-slide',
                thumbnailClass: 'featured-thumb',
                description: ''
            },
        ].concat(this._getStaticImages());
    }
    componentDidUpdate(prevProps, prevState) {
        if (this.state.slideInterval !== prevState.slideInterval ||
            this.state.slideDuration !== prevState.slideDuration) {
            // refresh setInterval
            this._imageGallery.pause();
            this._imageGallery.play();
        }
    }

    _onImageClick(event) {
        console.debug('clicked on image', event.target, 'at index', this._imageGallery.getCurrentIndex());
    }

    _onImageLoad(event) {
        console.debug('loaded image', event.target.src);
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

    _getStaticImages() {
        let images = [];
        for (let i = 2; i < 5; i++) {
            images.push({
                original: `${PREFIX_URL}${i}.jpg`,
                thumbnail:`${PREFIX_URL}${i}t.jpg`
            });
        }

        return images;
    }

    componentDidMount() {

    }

    render() {

        return (
            <ImageGallery
                ref={i => this._imageGallery = i}
                items={this.images}
                lazyLoad={false}
                onClick={this._onImageClick.bind(this)}
                onImageLoad={this._onImageLoad}
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

export default ImageGalleryAdvert2;
