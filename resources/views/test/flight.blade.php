{{-- https://opensky-network.org/api/states/all --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>


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
</style>






<div style="width: 100%; height:100%; display: table;">
  <div style="width: 600px; display: table-cell;" id="mapid">
    Yeah the map didn't load
  </div>
</div>

   
<script>
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
      if(alt_f > 7000 ){
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


        var heading = live_data[i][3];
        var latitude = live_data[i][1];
        var longtitude = live_data[i][2];
        var callsign = live_data[i][0];
        var sq = live_data[i][6]
        if(latitude == null || longtitude == null){
          var latitude = 0;
          var longtitude = 0;
        }
        var popup = L.popup()
            .setLatLng([latitude, longtitude])
            .setContent(`Callsign: ${callsign}<br>ALT: ${alt_f}<br> GS: ${gs_k}kts<br>${vs_f}<br>SQ: ${sq}`);
        marker = L.marker([latitude, longtitude], {icon:planeicon, rotationAngle:heading, clickable: true}).bindPopup(popup, {showOnMouseOver:true});
        markersLayer.addLayer(marker);
      
    }
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
            cs = value[i][1]
            on_gnd = value[i][8]
            if(cs.slice(0,3) == "RYR" && on_gnd != 1){
              var data_marker = [value[i][1], value[i][6], value[i][5], value[i][10], value[i][9], value[i][7], value[i][14], value[i][11]];
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
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 13,
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiMTMwNjYzOSIsImEiOiJjaXVheHF1emUwMDBnMnZ1dnF3NXlkcHJsIn0.EA9FU7f3QqXtirYubf6hvg'
    }).addTo(mymap);
    markersLayer.addTo(mymap);
    GetData();
    setInterval(GetData, 10000); //every 10 seconds
});

</script>