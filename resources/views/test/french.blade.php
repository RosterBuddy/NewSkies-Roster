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
var mymap = L.map('mapid').setView([47.4177873, 9.0855997], 4);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiMTMwNjYzOSIsImEiOiJjaXVheHF1emUwMDBnMnZ1dnF3NXlkcHJsIn0.EA9FU7f3QqXtirYubf6hvg'
    }).addTo(mymap);

    function french(feature) {
        if(feature.properties.id.substring(0,2) == "LF"){
            return {
                fillColor: 'red',
                weight: 1,
                opacity: 0.3,
                color: 'red',  //Outline color
                fillOpacity: 0
            };
        }else{
            return {
                fillColor: 'white',
                weight: 0.5,
                opacity: 0.3,
                color: 'white',  //Outline color
                fillOpacity: 0
            };
        }
    }

    $.ajax({
        type: "GET",
        url: "https://raw.githubusercontent.com/vatsimnetwork/vatspy-data-project/master/Boundaries.geojson",
        dataType: 'json',
        success: function (response) {

            geojsonLayer = L.geoJson(response, {
                style: french,
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