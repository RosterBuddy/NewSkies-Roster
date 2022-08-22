{{-- https://opensky-network.org/api/states/all --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mwasil/Leaflet.Rainviewer/leaflet.rainviewer.css"/>

 <!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/gh/mwasil/Leaflet.Rainviewer/leaflet.rainviewer.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/leaflet.rotatedMarker.js"></script>
<style>
 #mapid { 
    text-align: left;
    grid-column: 1/4;
} 
body {
  padding: 0;
  margin: 0;
}  
  
html, body, #map {
  height: 100%;
  width: 100%;
}
.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #fffff;
  overflow-x: hidden;
  padding-top: 20px;
  text-align: center;
}

.sidenav a {
  padding: 6px 6px 6px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 200px; /* Same as the width of the sidenav */
}
li {
  list-style: none;
  display: inline-block;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
<div class="sidenav">
  {{-- <ul style="position: absolute;top: 0; left: 0; right: 0; height: 50px;">
    <li><input type="radio" name="kind" checked="checked" onchange="setKind('radar')">Radar (Past + Future) <input type="radio" name="kind" onchange="setKind('satellite')">Infrared Satellite</li>

    <li><select id="colors" onchange="setColors(); return;">
        <option value="0">Black and White Values</option>
        <option value="1">Original</option>
        <option value="2" selected="selected">Universal Blue</option>
        <option value="3">TITAN</option>
        <option value="4">The Weather Channel</option>
        <option value="5">Meteored</option>
        <option value="6">NEXRAD Level-III</option>
        <option value="7">RAINBOW @ SELEX-SI</option>
        <option value="8">Dark Sky</option>
    </select></li>
  </ul> --}}

<p id="ac_cs">No Aircraft Selected</p>
<p id="ac_alt">No Aircraft Selected</p>
<p id="ac_kt">No Aircraft Selected</p>
<p id="ac_sq">No Aircraft Selected</p>
<p id="ac_vs">No Aircraft Selected</p>
<p id="ac_dp">No Aircraft Selected</p>
<p id="ac_ar">No Aircraft Selected</p>
<p id="ac_reg">No Aircraft Selected</p>
<p id="ac_type">No Aircraft Selected</p>

</div>

<div class="main">

  <div style="width: 100%; height:100%; display: table;">
    <div style="width: 600px; display: table-cell;" id="mapid">
      Yeah the map didn't load
    </div>
  </div>
</div>
   
<script>
var flight_info = {};
var aircraft_info = {};

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

 


var planeicon = L.icon({
  iconUrl: 'img/icon.png',
  iconSize:     [40, 40], // size of the icon
  iconAnchor:   [20, 20], // point of the icon which will correspond to marker's location
  popupAnchor:  [3, -10] // point from which the popup should open relative to the iconAnchor
});

var map;
var markers = [];
var live_data = [];
var markersLayer = new L.LayerGroup(); // NOTE: Layer is created here!


var updateMap = function(data) {
    console.log('Refreshing Map...');
    markersLayer.clearLayers();

    for (var i = 0; i < live_data.length; i++) {



      var alt_m=parseInt(live_data[i][5] * 3.281);
      var alt_f = (Math.round(alt_m));
      if(alt_f > 10000 ){
        alt_f = alt_f.toString()
        alt_f = alt_f.substring(0,3)
        alt_f = "FL" + alt_f
      }else{
        alt_f = alt_f + "ft"
      }

      var vs_m = parseInt(live_data[i][7] * 196.85);
      var vs_f = (Math.round(vs_m));
      if(vs_f == 0){
        vs_f = "Crusing"
      }else{
        vs_f = "V/S: " + vs_f + " fpm"
      }     


      var gs_m=parseInt(live_data[i][4] * 1.944);
      var gs_k = (Math.round(gs_m));

        // var callsign, latitude, longtitude, heading, blank_one, blank_two, sq, departure, arrival = live_data[i];

        var heading = live_data[i][3];
        var latitude = live_data[i][1];
        var longtitude = live_data[i][2];
        var callsign = live_data[i][0];
        var sq = live_data[i][6]
        var departure = live_data[i][8]
        var arrival = live_data[i][9]
        var reg = live_data[i][10]
        var actype = live_data[i][11]


        if(latitude == null || longtitude == null){
          var latitude = 0;
          var longtitude = 0;
        }else{
        var popup = L.popup()
            .setLatLng([latitude, longtitude])
            .setContent(`Callsign: ${callsign}<br>ALT: ${alt_f}<br> GS: ${gs_k}kts<br>${vs_f}<br>SQ: ${sq}<br>Departure: ${departure}<br>Arrival: ${arrival}<br>REG: ${reg}<br>Type: ${actype}`);
        }

        function onClick(e){

          let content = this._popup._content
          split_items = content.split("<br>")
          callsign = split_items[0].replace("Callsign: ", "")
          callsign_data = window.localStorage.getItem(callsign);
          meow = callsign_data.split(",")


          var alt_m=parseInt(meow[5] * 3.281);
          var alt_f = (Math.round(alt_m));
          if(alt_f > 10000 ){
            alt_f = alt_f.toString()
            alt_f = alt_f.substring(0,3)
            alt_f = "FL" + alt_f
          }else{
            alt_f = alt_f + "ft"
          }
        
          var vs_m = parseInt(meow[7] * 196.85);
          var vs_f = (Math.round(vs_m));
          if(vs_f == 0){
            vs_f = "Crusing"
          }else{
            vs_f = vs_f + " fpm"
          }     
        
        
          var gs_m=parseInt(meow[4] * 1.944);
          var gs_k = (Math.round(gs_m));



          document.getElementById("ac_cs").innerHTML = "C/S: " + meow[0];
          document.getElementById("ac_alt").innerHTML = "ALT: " + alt_f;
          document.getElementById("ac_vs").innerHTML = "V/S: " + vs_f;
          document.getElementById("ac_kt").innerHTML = "Speed: " + gs_k + "Kts"
          document.getElementById("ac_sq").innerHTML = "Squawk: " + meow[6];
          document.getElementById("ac_dp").innerHTML = "Dep: " + meow[8];
          document.getElementById("ac_ar").innerHTML = "Arr: " + meow[9];
          document.getElementById("ac_reg").innerHTML = "Reg: " + meow[10];
          document.getElementById("ac_type").innerHTML = "Type: " + meow[11];

        }
        
        myStorage = window.localStorage;
        var accs = myStorage.setItem(callsign,live_data[i])

        //console.log(myStorage[callsign]); // Come back to this

        marker = L.marker([latitude, longtitude], {icon:planeicon, rotationAngle:heading}).on('click',onClick).bindPopup(popup);
        markersLayer.addLayer(marker);

      
    }
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


function GetData() {
  live_data = []
    $.ajax({
        type        : 'GET', 
        url         : 'https://opensky-network.org/api/states/all'
    })
    .done(function(data) {
        $.each(data, function(index, value) { //for each line
          for (var i = 0; i < value.length; i++) {
            cs = value[i][1].trim();
            icao24 = value[i][0];
            on_gnd = value[i][8]
            if(cs.slice(0,3) == "RYR" || cs.slice(0,3) == "RUK" && on_gnd != 1){
              var data_marker = [cs, value[i][6], value[i][5], value[i][10], value[i][9], value[i][7], value[i][14], value[i][11]];
              if (flight_info[cs] !== undefined) {
                current_flight_info = flight_info[cs]
                data_marker.push(current_flight_info.departure, current_flight_info.arrival)
              } else { 
                data_marker.push('N/A', 'N/A')
              } 

              if(aircraft_info[icao24] != undefined){
                current_aircraft_info = aircraft_info[icao24]
                data_marker.push(current_aircraft_info.reg, current_aircraft_info.actype)
              } else{
                data_marker.push('N/A', 'N/A')
              }
              live_data.push(data_marker);
            }
          }
        });
        updateMap();
    });
}

$(document).ready(function(){
   var mymap = L.map('mapid').setView([47.72, 5.29], 5);     
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: '',
        maxZoom: 13,
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiMTMwNjYzOSIsImEiOiJjaXVheHF1emUwMDBnMnZ1dnF3NXlkcHJsIn0.EA9FU7f3QqXtirYubf6hvg'
    }).addTo(mymap);
    markersLayer.addTo(mymap);
    GetData();
    setInterval(GetData, 10000); //every 10 seconds
  
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
});


</script>

