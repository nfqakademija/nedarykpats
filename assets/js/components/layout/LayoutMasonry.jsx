import React from 'react';
import ReactDOM from 'react-dom';
import Masonry from 'react-masonry-css';

class Layout extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            domAdvertList: this.props.layoutItems,
            advertList: [],
        };
        this.createAdvert();
    }

    createAdvert = () => {
        const { domAdvertList, advertList } = this.state;
        for (let i = 0; i < domAdvertList.length; i++) {
            const el = domAdvertList[i];
            advertList.push(domAdvertList[i])
        }
    };

    createAdvertList = () => {
        const { domAdvertList, advertList } = this.state;
        for (let i = 0; i < domAdvertList.length; i++) {
            const el = domAdvertList[i];
            advertList.push(
                {
                    id: i,
                    name: el
                }
            )
        }
    };

    render() {
        let { domAdvertList, advertList } = this.state;
        let items = [
            {id: 1, name: <section className="Ad u-visibility-parent"><header className="Ad-header"><div> 2019-05-08 </div></header><h3 className="Header">Ieskau kas onia</h3><div className="Ad-body"><div className="Ad-text Ad-text--top"><p>Ieskau zmogaus turisgaletu sumontuoti vonia bei atliktiapdailosdarbus</p></div></div></section>},
            {id: 2, name: <section className="Ad u-visibility-parent"><header className="Ad-header"><div> 2019-05-08 </div></header><h3 className="Header">Ieskau kas sumontuotu vonia</h3><div className="Ad-body"><div className="Ad-text Ad-text--top"><p>Ieskau zmogaus turisgaletu sumontuoti vonia bei atliktiapdailosdarbus</p></div></div></section>},
            {id: 2, name: <section className="Ad u-visibility-parent"><header className="Ad-header"><div> 2019-05-08 </div></header><h3 className="Header">Ieskau kas sumontuotu vonia</h3><div className="Ad-body"><div className="Ad-text Ad-text--top"><p>Ieskau zmogaus turisgaletu sunjdnjdasjdnsad sandjksandksajdn sandjsandjksandksajnd sakjdnksajndkjsandkjsad sadnksjadnksjandksand askdjnsakjndjksnadksa sadnksandksandksajnd sakndksajndkjsnd montuoti vonia bei atliktiapdailosdarbus</p></div></div></section>},
            {id: 3, name: <section className="Ad u-visibility-parent"><header className="Ad-header"><div> 2019-05-08 </div></header><h3 className="Header">Ieskau kas sumontuotu vonia</h3><div className="Ad-body"><div className="Ad-text Ad-text--top"><p>Ieskau zmogaus turisgaletu sumontuoti vonia bei atliktiapdailosdarbus</p></div></div></section>},
            {id: 4, name: <section className="Ad u-visibility-parent"><header className="Ad-header"><div> 2019-05-08 </div><div className="Bid"><span className="Bid-header">s</span><span className="Bid-count">d</span></div></header><div className="Bid-header u-margin-top">s</div><h3 class="Header">Ieskau kas sumontuotu vonia</h3><div class="Ad-body"><div class="Ad-text Ad-text--top"><p>Ieskau zmogaus turisgaletu sumontuoti vonia bei atliktiapdailosdarbus</p></div><div class="u-align-center u-visibility-flex-child"><a class="Button Button--short u-margin-top-bottom">Plačiau</a></div><footer class="Ad-footer Ad-footer--bottom"><ul class="Ad-categories"><li class="Category Category--lightGreen">Remontas</li></ul></footer></div></section>},
        ];

        const breakpointColumnsObj = {
            default: 3,
            1100: 3,
            700: 2,
            500: 1
        };

        items = items.map(function(item) {
            return <div key={item.id}>{item.name}</div>
        });

        advertList = advertList.map(function(item) {
            return <div>{item.name}</div>
        });
        console.log(advertList);

        return (
            <Masonry
                breakpointCols={breakpointColumnsObj}
                className="my-masonry-grid"
                columnClassName="my-masonry-grid_column"
            >
            </Masonry>
        )
    }
}

export default Layout;
