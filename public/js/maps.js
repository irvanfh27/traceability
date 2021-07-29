mapboxgl.accessToken = 'pk.eyJ1Ijoic29pbG5vaXN0dXJlIiwiYSI6ImNqdzIyeDUycDA4MWY0OHBtcDMydzVqOGsifQ.sa7RFCSwXU0JZjkaWHgd-w';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [
        113.921327, -0.789275
    ],
    zoom: 4
});

async function loadSupplier(stockpileId) {
    // console.log('triggered');
    //    document.getElementsByClassName("markers").remove();
    document.querySelectorAll('.markers').forEach(function(a){
        a.remove()
    })
    const response = await fetch(supplierMaps + '/' + stockpileId);

    // Storing data in form of JSON
    var geoJson = await response.json();
    console.log(geoJson);
    // const geoJson = JSON.parse(data);
    const {source} = geoJson;
    const {data} = source;
    const {features, type} = data;


    features.forEach(function(marker) {
        const {geometry,properties} = marker
        const {distance,vendor,title,collection,url,kapasitas_produksi,collection_rate} = properties;
        // create a HTML element for each feature
        var el = document.createElement('div');
        el.className = 'markers';
        el.innerHTML = "<img src='https://cdn1.iconfinder.com/data/icons/free-98-icons/32/map-marker-128.png' style='width: 30px; height: 30px;'/> <div style='position: absolute; text-align:center; width:150px;'>"+title+"</div>";

        new mapboxgl.Marker(el)
        .setLngLat(geometry.coordinates)
        .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
        .setHTML(
            '<h6>' +
            title +
            '</h6>Collection : ' +
            collection +
            '<br>Distance To Stockpile : ' +
            distance+
            '<br>Production Capacity : ' +
            kapasitas_produksi+
            '<br>Collection Rate : '+
            collection_rate+
            '<br><a class="btn btn-sm btn-primary" href="' + url +
            '">Detail</a>'
            ))
            .addTo(map);
        });

    }

    map.on('load', function () { // Add a layer showing the places.
        map.loadImage('https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-128.png', function (error, image) {
        if (error)
        throw error;
        map.addImage('cat', image);
        // $.get(stockpileMaps, function (data) {
        map.addLayer(stockpileData);
        // });

        map.on('click', 'places', function (e) {

            var coordinates = e.features[0].geometry.coordinates.slice();

            // Ensure that if the map is zoomed out such that multiple
            // copies of the feature are visible, the popup appears
            // over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            document.getElementById('stockpileName').innerHTML = '<p>'+e.features[0].properties.stockpileName+'</p>';
            document.getElementById('stockpileAddress').innerHTML ='<p>'+e.features[0].properties.address+'</p>';
            document.getElementById('totalSupplier').innerHTML ='<p>'+e.features[0].properties.totalSupplier+'</p>';
            document.getElementById('stockpileInventory').innerHTML ='<p>0</p>';
            document.getElementById('urlStockpile').setAttribute('href', e.features[0].properties.url);
            loadSupplier(e.features[0].properties.stockpileId);

            loadTableSupllier(e.features[0].properties.urlSupplier)

        });

    });
});


