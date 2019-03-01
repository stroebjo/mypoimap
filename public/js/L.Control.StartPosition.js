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
        var icon = L.DomUtil.create('span', 'fa fa-map-signs', link);

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

        if (lsTest() === true) {

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
