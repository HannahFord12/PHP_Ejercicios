
/*Crea el mapa y pone el punto inicial en Castellon*/
var map = L.map('map').setView([39.99, -0.05], 13);
var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
maxZoom: 19,
attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([39.99, -0.05]).addTo(map);

/*controlar el zoom no nos sirve*/


/*cuando le de dobleclick en un sitio salga el punto y los guarde*/
var popup = L.popup();

L.control.scale().addTo(map);

function onMapClick(e) {
    var coor=e.latlng.toString().split(',');
    var lat=coor[0].slice(7);
    var lng=coor[1].slice(1,-1);
    
    var marker = L.marker([lat, lng]).addTo(map);

    //$.get("insertpunto.php",{lat: lat, lng: lng}); 
}
//var map = L.map('map').setView([lat, lng]);
map.on('click', onMapClick);

L.control.zoom({
    position: 'bottomright'
}).addTo(map);
/*function enMapa(e){
    
    var marker = L.marker([punto.latitud, punto.longitud]).addTo(map);
}

map.on('zoom', enMapa)*/
