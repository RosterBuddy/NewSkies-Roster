{{-- https://opensky-network.org/api/states/all --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/Marker.Rotate.js"></script>
<style>
 #mapid { 
    text-align: left;
    grid-column: 1/4;
} 
</style>






<div style="width: 100%; height:100%; display: table;">
  <div style="width: 600px; display: table-cell;" id="mapid">
    Yeah the map didn't load
  </div>
</div>

   
<script>
var aircraft;
var aircraftlayer = new L.LayerGroup()

var planeicon = L.icon({
  iconUrl: 'img/icon.png',
  iconSize:     [40, 40], // size of the icon
  iconAnchor:   [20, 20], // point of the icon which will correspond to marker's location
  popupAnchor:  [3, -10] // point from which the popup should open relative to the iconAnchor
});


var mymap = L.map('mapid').setView([48.3460247, 8.3744107], 5);     

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 13,
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiMTMwNjYzOSIsImEiOiJjaXVheHF1emUwMDBnMnZ1dnF3NXlkcHJsIn0.EA9FU7f3QqXtirYubf6hvg'
    }).addTo(mymap);

function update_position() {
    $.getJSON('https://opensky-network.org/api/states/all', function(data) {
        var planes = data.states
        for(let i = 0; i < planes.length; i++){
            plane = planes[i]
            lat = plane[6]
            lon = plane[5]
            csfilter = plane[1].substring(0,3);
            //if(csfilter == "RYR"){
                // if(!aircraft){
                    //var live_position = [[plane[1], plane[6], plane[5]]]
                    var aircraft = L.marker([lat,lon]).bindPopup("I am "+plane[1]);

                    aircraftlayer.addLayer(aircraft)
                    mymap.addLayer(aircraftlayer)

                // }
            //}
        }
        aircraft.setLatLng([lat,lon]).update();
        setTimeout(update_position, 10000);
    });
}
update_position();






function remove_marker(){
    aircraftlayer.clearLayers(); // Blindly remove everything from the Layer Group
    console.log("Removing");
    setTimeout(remove_marker, 9500);

}


</script>