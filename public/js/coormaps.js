
    mapboxgl.accessToken = 'pk.eyJ1Ijoic29pbG5vaXN0dXJlIiwiYSI6ImNqdzIyeDUycDA4MWY0OHBtcDMydzVqOGsifQ.sa7RFCSwXU0JZjkaWHgd-w';
    var coordinates = document.getElementById('coordinates');
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [
            99.0395182,2.348236
        ],
        zoom: 4
    });
    
    var marker = new mapboxgl.Marker({
        draggable: true
    })
        .setLngLat([99.0395182,-16.348236])
        .addTo(map);

    function onDragEnd() {
        var lngLat = marker.getLngLat();
        coordinates.style.display = 'block';
        coordinates.innerHTML =
            'Longitude: ' + lngLat.lng + '<br />Latitude: ' + lngLat.lat;
            document.getElementById("latitude").value = lngLat.lat;
            document.getElementById("longitude").value = lngLat.lng;
    }

    marker.on('dragend', onDragEnd);