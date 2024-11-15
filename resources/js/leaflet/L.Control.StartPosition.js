L.Control.StartPosition = L.Control.extend({

    options: {
        position: 'topleft',
        strings: {
            title: 'Set start position of map',
            no_localstorage: 'LocalteStorage is not available, so it is not possible to save the current map position (maybe incognito mode?).'
        }
    },

    onAdd: function(map) {
        var container = L.DomUtil.create('div',
                'leaflet-bar leaflet-control');

        var link = L.DomUtil.create('a', 'leaflet-bar-part leaflet-bar-part-single', container);
        link.href = '#';
        link.title = this.options.strings.title;
        var icon = L.DomUtil.create('span', 'my-icon', link);

        icon.innerHTML = '<svg class="marked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M288 0c-69.59 0-126 56.41-126 126 0 56.26 82.35 158.8 113.9 196.02 6.39 7.54 17.82 7.54 24.2 0C331.65 284.8 414 182.26 414 126 414 56.41 357.59 0 288 0zm0 168c-23.2 0-42-18.8-42-42s18.8-42 42-42 42 18.8 42 42-18.8 42-42 42zM20.12 215.95A32.006 32.006 0 0 0 0 245.66v250.32c0 11.32 11.43 19.06 21.94 14.86L160 448V214.92c-8.84-15.98-16.07-31.54-21.25-46.42L20.12 215.95zM288 359.67c-14.07 0-27.38-6.18-36.51-16.96-19.66-23.2-40.57-49.62-59.49-76.72v182l192 64V266c-18.92 27.09-39.82 53.52-59.49 76.72-9.13 10.77-22.44 16.95-36.51 16.95zm266.06-198.51L416 224v288l139.88-55.95A31.996 31.996 0 0 0 576 426.34V176.02c0-11.32-11.43-19.06-21.94-14.86z"></path></svg>';

        this._link = link;

        L.DomEvent
            .on(this._link, 'click', L.DomEvent.stopPropagation)
            .on(this._link, 'click', L.DomEvent.preventDefault)
            .on(this._link, 'click', this._onClick, this)
            .on(this._link, 'dblclick', L.DomEvent.stopPropagation);

        return container;
    },

    onRemove: function(map) {
        // Nothing to do here
    },

    _onClick: function() {
        if (this.lsTest() === true) {
            var map_position = {
                lat: this._map.getCenter().lat,
                lng: this._map.getCenter().lng,
                zoom: this._map.getZoom()
            };
            localStorage.setItem("map_position", JSON.stringify(map_position));
        } else {
            alert(this.options.strings.no_localstorage);
        }
    },

    lsTest: function(){
        var test = 'test';
        try {
            localStorage.setItem(test, test);
            localStorage.removeItem(test);
            return true;
        } catch(e) {
            return false;
        }
    }
});

L.control.startposition = function(opts) {
    return new L.Control.StartPosition(opts);
}
