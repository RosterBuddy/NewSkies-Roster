<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<script src="{{asset('js/leaflet.rotatedMarker.js')}}"></script>
<style>
    #mapid { 
        height: 100%;
        width: 100%;
    }
</style>

<div id="mapid"></div>

<script>
var weatherLayer = new L.LayerGroup(); // NOTE: Layer is created here!
    var apiData = {};
    var mapFrames = [];
    var lastPastFramePosition = -1;
    var radarLayers = [];
    var optionKind = 'radar'; // can be 'radar' or 'satellite'
    var optionTileSize = 512; // can be 256 or 512.
    var optionColorScheme = 2; // from 0 to 8. Check the https://rainviewer.com/api/color-schemes.html for additional information
    var optionSmoothData = 1; // 0 - not smooth, 1 - smooth
    var optionSnowColors = 1; // 0 - do not show snow colors, 1 - show snow colors
    var animationPosition = 0;
    var animationTimer = false;

    function weather_update(){
    /**
     * Load all the available maps frames from RainViewer API
     */
    var apiRequest = new XMLHttpRequest();
    apiRequest.open("GET", "https://api.rainviewer.com/public/weather-maps.json", true);
    apiRequest.onload = function(e) {
        // store the API response for re-use purposes in memory
        apiData = JSON.parse(apiRequest.response);
        initialize(apiData, optionKind);
    };
    apiRequest.send();
    /**
     * Initialize internal data from the API response and options
     */
    function initialize(api, kind) {
        // remove all already added tiled layers
        for (var i in radarLayers) {
            mymap.removeLayer(radarLayers[i]);
        }
        mapFrames = [];
        radarLayers = [];
        animationPosition = 0;
        if (!api) {
            return;
        }
        if (kind == 'satellite' && api.satellite && api.satellite.infrared) {
            mapFrames = api.satellite.infrared;
            lastPastFramePosition = api.satellite.infrared.length - 1;
            showFrame(lastPastFramePosition);
        }
        else if (api.radar && api.radar.past) {
            mapFrames = api.radar.past;
            if (api.radar.nowcast) {
                mapFrames = mapFrames.concat(api.radar.nowcast);
            }
            // show the last "past" frame
            lastPastFramePosition = api.radar.past.length - 1;
            showFrame(lastPastFramePosition);
        }
    }
    /**
     * Animation functions
     * @param path - Path to the XYZ tile
     */
    function addLayer(frame) {
        if (!radarLayers[frame.path]) {
            var colorScheme = optionKind == 'satellite' ? 0 : optionColorScheme;
            var smooth = optionKind == 'satellite' ? 0 : optionSmoothData;
            var snow = optionKind == 'satellite' ? 0 : optionSnowColors;
            radarLayers[frame.path] = new L.TileLayer(apiData.host + frame.path + '/' + optionTileSize + '/{z}/{x}/{y}/' + colorScheme + '/' + smooth + '_' + snow + '.png', {
                tileSize: 256,
                opacity: 0.001,
                zIndex: frame.time
            });
        }
        if (!mymap.hasLayer(radarLayers[frame.path])) {
            mymap.addLayer(radarLayers[frame.path]);
        }
    }
    /**
     * Display particular frame of animation for the @position
     * If preloadOnly parameter is set to true, the frame layer only adds for the tiles preloading purpose
     * @param position
     * @param preloadOnly
     */
    function changeRadarPosition(position, preloadOnly) {
        while (position >= mapFrames.length) {
            position -= mapFrames.length;
        }
        while (position < 0) {
            position += mapFrames.length;
        }
        var currentFrame = mapFrames[animationPosition];
        var nextFrame = mapFrames[position];
        addLayer(nextFrame);
        if (preloadOnly) {
            return;
        }
        animationPosition = position;
        if (radarLayers[currentFrame.path]) {
            radarLayers[currentFrame.path].setOpacity(0);
        }
        radarLayers[nextFrame.path].setOpacity(100);
        var pastOrForecast = nextFrame.time > Date.now() / 1000 ? 'FORECAST' : 'PAST';
    }
    /**
     * Check avialability and show particular frame position from the timestamps list
     */
    function showFrame(nextPosition) {
        var preloadingDirection = nextPosition - animationPosition > 0 ? 1 : -1;
        changeRadarPosition(nextPosition);
        // preload next next frame (typically, +1 frame)
        // if don't do that, the animation will be blinking at the first loop
        changeRadarPosition(nextPosition + preloadingDirection, true);
    }
    /**
     * Change map options
     */
    function setKind(kind) {
        optionKind = kind;
        initialize(apiData, optionKind);
    }
    function setColors() {
        var e = document.getElementById('colors');
        optionColorScheme = e.options[e.selectedIndex].value;
        initialize(apiData, optionKind);
    }
  }
  weather_update();
  setInterval(weather_update, 900000); // 15 minutes

var mymap = L.map('mapid').setView([47.4177873, 9.0855997], 4);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiMTMwNjYzOSIsImEiOiJjaXVheHF1emUwMDBnMnZ1dnF3NXlkcHJsIn0.EA9FU7f3QqXtirYubf6hvg'
    }).addTo(mymap);

    function polystyle(feature) {
        return {
            fillColor: 'white',
            weight: 0.5,
            opacity: 0.3,
            color: 'white',  //Outline color
            fillOpacity: 0
        };
    }

    $.ajax({
        type: "GET",
        url: "https://raw.githubusercontent.com/vatsimnetwork/vatspy-data-project/master/Boundaries.geojson",
        dataType: 'json',
        success: function (response) {

            geojsonLayer = L.geoJson(response, {
                style: polystyle,
                onEachFeature: function(feature, layer){
                layer.bindPopup(feature.properties.id); 
            }}).addTo(mymap);
        }
    });

    function forEachFeature(feature, layer) {
        var popupContent = "<p>" + feature.properties +"</p>";

        layer.bindPopup(popupContent);
    }
</script>