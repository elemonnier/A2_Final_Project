// On initialise la latitude et la longitude de la France(centre de la carte)
var lat = parseFloat(document.getElementById('variableAPasserLatDest1').value);
var lon = parseFloat(document.getElementById('variableAPasserLongDest1').value);
var lat2 = parseFloat(document.getElementById('variableAPasserLatDest2').value);
var lon2 = parseFloat(document.getElementById('variableAPasserLongDest2').value);
var map = null;

function initMap() {
    // Créer l'objet "map" et l'insèrer dans l'élément HTML qui a l'ID "map"
    map = new google.maps.Map(document.getElementById("map"), {
        //centre de la carte avec les coordonnées ci-dessus
        center: new google.maps.LatLng(62.456167, -101.747849),
        //zoom par défaut
        zoom: 3,
        //type de carte (ici carte routière)
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        //options de contrôle de la carte (plan, satellite...)
        mapTypeControl: true,
        //roulette de souris
        scrollwheel: false,
        mapTypeControlOptions: {
            //comment les options se placent
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
        },
        //options de navigation dans la carte (zoom...)
        navigationControl: true,
        navigationControlOptions: {
            //affichage options
            style: google.maps.NavigationControlStyle.ZOOM_PAN

        }
    });
    //ajout d'un marqueur
    var marker = new google.maps.Marker({
        //position (syntaxe json)
        position: {lat: lat, lng: lon},
        //à quelle carte il est ajouté
        map: map
    });
    var marker2 = new google.maps.Marker({
        position: {lat: lat2, lng: lon2},
        map: map
    });
    var flightPlanCoordinates = [
        {lat: lat, lng: lon},
        {lat: lat2, lng: lon2}
    ];
    var flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
    });

    flightPath.setMap(map);
}
window.onload = function(){
    initMap();
};