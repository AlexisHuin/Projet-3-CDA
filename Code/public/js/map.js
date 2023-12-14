function calculateBounds(center,) {
    var bounds = new google.maps.LatLngBounds();
    var northEast = new google.maps.LatLng(
        center.lat() + 0.75,
        center.lng() + 3.25
    );
    var southWest = new google.maps.LatLng(
        center.lat() - 0.75,
        center.lng() - 3.25
    );

    bounds.extend(northEast);
    bounds.extend(southWest);

    return bounds;
}

async function initMap() {
    const zoom = 8.25;
    var center = new google.maps.LatLng(47.363, 0.6);
    new google.maps.Map(document.getElementById("map"), {
        zoom,
        center,
        minZoom: zoom,
        disableDefaultUI: true,
        restriction: {
            latLngBounds: calculateBounds(center).toJSON()
        },
        styles: [
            {
                featureType: 'poi',
                elementType: 'labels',
                stylers: [{ visibility: 'off' }]
            }
        ]
    });
} 