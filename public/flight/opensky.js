var request = require("request")
var mysql = require('mysql');
const settings = require('./settings.json');


var con = mysql.createConnection({
    host: settings.dbhost,
    user: settings.dbuser,
    password: settings.dbpassword,
    database: settings.database,
    dateStrings:true,
});

var unix_now = Math.round((new Date()).getTime() / 1000);
var unix_old = Math.round((new Date()).getTime() / 1000) - 604800;

//console.log(`Now: ${unix_now}\nOld: ${unix_old}`);

var url = "https://opensky-network.org/api/flights/arrival?airport=EIDW&begin="+unix_old+"&end="+unix_now


request({
    url: url,
    json: true
}, function (error, response, body) {

    if (!error && response.statusCode === 200) {
        // console.log(body) // Print the json response
        for (var i = 0; i < body.length; i++) {
            dep = body[i];          
            if(dep.callsign.slice(0,3) == "RYR"){
                var callsign = dep.callsign
                var estDepartureAirport = dep.estDepartureAirport
                var estArrivalAirport = dep.estArrivalAirport

                if(estDepartureAirport == null){
                   var estDepartureAirport = "XXXX"
                }else{
                    // console.log(`${dep.callsign} ${dep.estDepartureAirport} ${dep.estArrivalAirport}`);
                    con.query("INSERT flighttracker(callsign, estDepartureAirport, estArrivalAirport) VALUES (?, ?, ?)",[callsign, estDepartureAirport, estArrivalAirport] , (err, results, fields) => {
                        if(err & err == "ER_DUPE_ENTRY"){
                            
                        }else{
                            console.log("Added to database successfully")
                        }
                    });
                }
            }
        }
    }
})