import L from "leaflet";

// leaflet marker icon are not recognized by Vite automatically.
// This somehow loads the needed images from the package folder and transforms
// the to inline/base64 images.
// See https://github.com/vue-leaflet/Vue2Leaflet/issues/103#issuecomment-2137388444
import markerIconUrl from 'leaflet/dist/images/marker-icon.png';
import markerIconRetinaUrl from 'leaflet/dist/images/marker-icon-2x.png';
import markerShadowUrl from 'leaflet/dist/images/marker-shadow.png';
L.Icon.Default.prototype.options.iconUrl = markerIconUrl;
L.Icon.Default.prototype.options.iconRetinaUrl = markerIconRetinaUrl;
L.Icon.Default.prototype.options.shadowUrl = markerShadowUrl;
L.Icon.Default.imagePath = '';

window.L = L;

import 'leaflet.markercluster';
import 'leaflet.locatecontrol';
import 'leaflet-fullscreen';
import 'leaflet-kml';
import 'leaflet-gpx';

import './leaflet/L.Control.StartPosition';
import './leaflet/L.Icon.CustomColorMarker';
