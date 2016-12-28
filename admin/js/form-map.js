var map, markers = {};
var geocoder = new google.maps.Geocoder();
var centerMap = {lat: 50.4501, lng: 30.5234};
function mapInit() {
    map = new google.maps.Map(
        document.getElementById('map'),
        {
            center: centerMap,
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );
}

function addMarker(coordInpId, addressInpId, coordinates) {
    if(coordinates == undefined){
        coordinates = centerMap;
    }
    coordinates.lat = parseFloat(coordinates.lat);
    coordinates.lng = parseFloat(coordinates.lng);
    var coordInp = document.getElementById(coordInpId);
    var addressInp = document.getElementById(addressInpId);
    var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: coordinates
    });
    markers[coordInpId] = marker;

    coordInp.value = coordinates.lat+';'+coordinates.lng;

    google.maps.event.addListener(marker, 'drag', function () {
        geocoder.geocode({'location': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                coordInp.value = results[0].geometry.location.lat() + ';' + results[0].geometry.location.lng();
                addressInp.value = results[0].formatted_address;
            }
        });
    });
}

function initAutocomplete(coordInpId, addressInpId){
    var autocomplete = new google.maps.places.Autocomplete(
        document.getElementById(addressInpId),
        {types: ['geocode']}
        );
    autocomplete.addListener('place_changed', function(){
        var place = autocomplete.getPlace();
        document.getElementById(coordInpId).value = place.geometry.location.lat()+';'+place.geometry.location.lng();
        map.setCenter({lat: place.geometry.location.lat(), lng: place.geometry.location.lng()});
        markers[coordInpId].setPosition({lat: place.geometry.location.lat(), lng: place.geometry.location.lng()})
    });
}

function removeMarker(id){
    markers[id].setMap(null);
    delete markers[id];
}