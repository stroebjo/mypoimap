/* webpackIgnore: true */

//pSBC - Shade Blend Convert - Version 4.0 - 02/18/2019
const pSBC=(p,c0,c1,l)=>{
	let r,g,b,P,f,t,h,i=parseInt,m=Math.round,a=typeof(c1)=="string";
	if(typeof(p)!="number"||p<-1||p>1||typeof(c0)!="string"||(c0[0]!='r'&&c0[0]!='#')||(c1&&!a))return null;
	if(!this.pSBCr)this.pSBCr=(d)=>{
		let n=d.length,x={};
		if(n>9){
			[r,g,b,a]=d=d.split(","),n=d.length;
			if(n<3||n>4)return null;
			x.r=i(r[3]=="a"?r.slice(5):r.slice(4)),x.g=i(g),x.b=i(b),x.a=a?parseFloat(a):-1
		}else{
			if(n==8||n==6||n<4)return null;
			if(n<6)d="#"+d[1]+d[1]+d[2]+d[2]+d[3]+d[3]+(n>4?d[4]+d[4]:"");
			d=i(d.slice(1),16);
			if(n==9||n==5)x.r=d>>24&255,x.g=d>>16&255,x.b=d>>8&255,x.a=m((d&255)/0.255)/1000;
			else x.r=d>>16,x.g=d>>8&255,x.b=d&255,x.a=-1
		}return x};
	h=c0.length>9,h=a?c1.length>9?true:c1=="c"?!h:false:h,f=this.pSBCr(c0),P=p<0,t=c1&&c1!="c"?this.pSBCr(c1):P?{r:0,g:0,b:0,a:-1}:{r:255,g:255,b:255,a:-1},p=P?p*-1:p,P=1-p;
	if(!f||!t)return null;
	if(l)r=m(P*f.r+p*t.r),g=m(P*f.g+p*t.g),b=m(P*f.b+p*t.b);
	else r=m((P*f.r**2+p*t.r**2)**0.5),g=m((P*f.g**2+p*t.g**2)**0.5),b=m((P*f.b**2+p*t.b**2)**0.5);
	a=f.a,t=t.a,f=a>=0||t>=0,a=f?a<0?t:t<0?a:a*P+t*p:0;
	if(h)return"rgb"+(f?"a(":"(")+r+","+g+","+b+(f?","+m(a*1000)/1000:"")+")";
	else return"#"+(4294967296+r*16777216+g*65536+b*256+(f?m(a*255):0)).toString(16).slice(1,f?undefined:-2)
}

/* webpackIgnore: false */

L.Icon.CustomColorMarker = L.Icon.extend({

	options: {
        popupAnchor: [0, -30],
        color: '#000000',
        unique_id: 'random',
        visited: false,
        number: false
	},

	createIcon: function () {
        var div = document.createElement('div');

        div.className = 'leaflet-marker-icon custom-color-marker';

        var options = this.options;

        var lighterColor = pSBC(0.5, options.color);
        var darker25Color = pSBC(-0.25, options.color);
        var darker75Color = pSBC(-0.75, options.color);

        var number_fillcolor = 'white';

        if (options.visited) {
            number_fillcolor = 'rgba(255, 255, 255, .8)';
        }

        var number = '';

        if (options.number != false) {
            number = `<circle cx="14.5" cy="15" r="10" stroke="#666"
                    stroke-width="1" fill="${ number_fillcolor }" />
    <text x="50%" y="19" text-anchor="middle" fill="#333">${ options.number }</text>`;
        }

		// marker icon L.DomUtil doesn't seem to like svg, just append out html directly
		div.innerHTML = `<svg width="28" height="41" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <linearGradient id="a${ options.unique_id }">
            <stop stop-color="${ options.color }" offset="0"/> <!-- base color -->
            <stop stop-color="${ lighterColor}" offset="1"/> <!-- 50% lighter base color -->
        </linearGradient>
        <linearGradient id="b${ options.unique_id }">
            <stop stop-color="${ darker25Color}" offset="0"/> <!-- 25% darker base color -->
            <stop stop-color="${ darker75Color}" offset="1"/> <!-- 75% darker base color -->
        </linearGradient>
        <linearGradient y2="-0.004651" x2="0.498125" y1="0.971494" x1="0.498125" id="c${ options.unique_id }" xlink:href="#a${ options.unique_id }"/>
        <linearGradient y2="-0.004651" x2="0.415917" y1="0.490437" x1="0.415917" id="d${ options.unique_id }" xlink:href="#b${ options.unique_id }"/>
    </defs>

    <rect fill="#fff" width="12.625" height="14.5" x="8.470894" y="6.783094"/>
    <path stroke-linecap="round" stroke-width="1.1" stroke="url(#d${ options.unique_id })" fill="url(#c${ options.unique_id })" d="m14.735894,2.820094c-6.573,0 -12.044,5.691 -12.044,11.866c0,2.778 1.564,6.308 2.694,8.746l9.306,17.872l9.262,-17.872c1.13,-2.438 2.738,-5.791 2.738,-8.746c0,-6.175 -5.383,-11.866 -11.956,-11.866zm0,7.155c2.584,0.017 4.679,2.122 4.679,4.71s-2.095,4.663 -4.679,4.679c-2.584,-0.017 -4.679,-2.09 -4.679,-4.679c0,-2.588 2.095,-4.693 4.679,-4.71z"/>
    <path fill="none" stroke-opacity="0.122" stroke-linecap="round" stroke-width="1.1" stroke="#fff" d="m14.722894,3.927094c-5.944,0 -10.938,5.219 -10.938,10.75c0,2.359 1.443,5.832 2.563,8.25l0.031,0.031l8.313,15.969l8.25,-15.969l0.031,-0.031c1.135,-2.448 2.625,-5.706 2.625,-8.25c0,-5.538 -4.931,-10.75 -10.875,-10.75zm0,4.969c3.168,0.021 5.781,2.601 5.781,5.781c0,3.18 -2.613,5.761 -5.781,5.781c-3.168,-0.02 -5.75,-2.61 -5.75,-5.781c0,-3.172 2.582,-5.761 5.75,-5.781z"/>

    ${ number }

</svg>`;

        if (options.visited) {
    		div.innerHTML = `<svg width="28" height="41" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

    <path stroke-linecap="round" stroke-width="1.1" stroke="${ options.color }" fill-opacity=".23" fill="${ options.color }" d="m14.735894,2.820094c-6.573,0 -12.044,5.691 -12.044,11.866c0,2.778 1.564,6.308 2.694,8.746l9.306,17.872l9.262,-17.872c1.13,-2.438 2.738,-5.791 2.738,-8.746c0,-6.175 -5.383,-11.866 -11.956,-11.866zm0,7.155c2.584,0.017 4.679,2.122 4.679,4.71s-2.095,4.663 -4.679,4.679c-2.584,-0.017 -4.679,-2.09 -4.679,-4.679c0,-2.588 2.095,-4.693 4.679,-4.71z"/>
    <path fill="none" stroke-opacity="0.122" stroke-linecap="round" stroke-width="1.1" stroke="#fff" d="m14.722894,3.927094c-5.944,0 -10.938,5.219 -10.938,10.75c0,2.359 1.443,5.832 2.563,8.25l0.031,0.031l8.313,15.969l8.25,-15.969l0.031,-0.031c1.135,-2.448 2.625,-5.706 2.625,-8.25c0,-5.538 -4.931,-10.75 -10.875,-10.75zm0,4.969c3.168,0.021 5.781,2.601 5.781,5.781c0,3.18 -2.613,5.761 -5.781,5.781c-3.168,-0.02 -5.75,-2.61 -5.75,-5.781c0,-3.172 2.582,-5.761 5.75,-5.781z"/>

    ${ number }

</svg>`;
        }

		return div;
	}
});

L.icon.customColorMarker = function (options) {
	return new L.Icon.CustomColorMarker(options);
};

