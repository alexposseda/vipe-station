var map, markers = [];
var centerMap = {lat: 50.4501, lng: 30.5234};
function mapInit() {
    map = new google.maps.Map(
        document.getElementById('map'),
        {
            center: centerMap,
            zoom: 11,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );
}

function addMarker(coordinates) {
    coordinates.lat = parseFloat(coordinates.lat);
    coordinates.lng = parseFloat(coordinates.lng);
    var marker = new google.maps.Marker({
        map: map,
        draggable: false,
        position: coordinates
    });
    markers.push(marker);
    map.setCenter(marker.getPosition());
}
