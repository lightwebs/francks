var map, marker, allMarkers, bounds, pin, largePin, me, markers = [], markersArray = [], searchMarker, myMarker, showing, centerPos;
let officeItems = document.querySelectorAll('.lw-office-item');
var searchInput = document.querySelector('.lw-map--search--input');

function initMap() {
    allMarkers = document.querySelectorAll('.marker');
    
    // Create gerenic map.
    var mapArgs = {
        zoom        : 16,
        mapTypeId   : google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,
        zoomControl: false,
    };

    if ( window.innerWidth > 767 ) {
        mapArgs.gestureHandling = 'greedy';
    }
    
    map = new google.maps.Map( document.getElementById("f-map"), mapArgs );
    // Find marker elements within map.
    // Add markers.
    map.markers = [];
    allMarkers.forEach(marker => {
        initMarker(marker, map);
    });
    
    // Center map based on markers.
    centerMap( map );

    // Return map instance.
    return map;
}


// var infowindow = new google.maps.InfoWindow;
let currentMarker = null;
function initMarker( marker, map ) {

    // Get position from marker.
    var lat = marker.dataset.lat;
    var lng = marker.dataset.lng;
    var id = marker.dataset.id;
    var county = marker.querySelector('.lw-office-item--county');
    var city = marker.querySelector('.lw-office-item--city');
    var streetName = marker.querySelector('.lw-office-item--address .street_name');
    var streetNumber = marker.querySelector('.lw-office-item--address .street_number');
    var postCode = marker.querySelector('.lw-office-item--address .post_code');
    
    pin = {
        url: `${lwGlobal.templateDir}/assets/img/icons/map-pin.png`,
        scaledSize: new google.maps.Size(27, 40),
        zIndex: 0
    }
    largePin = {
        url: `${lwGlobal.templateDir}/assets/img/icons/map-pin-red.png`,
        scaledSize: new google.maps.Size(36, 56),
        zIndex: 100
    }
    
    me = {
        url: `${lwGlobal.templateDir}/assets/img/icons/myposition-icon.png`,
        scaledSize: new google.maps.Size(24, 24),
    }

    var latLng = {
        lat: parseFloat( lat ),
        lng: parseFloat( lng )
    };

    // Create info window.
    
    // var markerContent = marker.innerHTML;

    // Create marker instance.
    marker = new google.maps.Marker({
        position : latLng,
        map,
        id,
        icon: pin,
        county: county.textContent,
        city: city.textContent,
        address: city.textContent + ' ' + county.textContent + ' ' + streetName.textContent + ' ' + streetNumber.textContent + ', ' + postCode.textContent,
        optimized: false,
        animation: google.maps.Animation.DROP
    });

    // Append to reference for later use.
    map.markers.push( marker );
    markersArray.push(marker);
    // infowindow.addListener("closeclick", ()=> {
    //     map.markers.map( marker => {marker.setZIndex(0); marker.setIcon(pin);} );
    //     officeItems.forEach(officeItem => officeItem.classList.remove('hide'));
    // });

    marker.addListener("click", function() {
        // infowindow.setContent(markerContent);
        // infowindow.open( map, marker );

        map.markers.map(marker => {
            marker.setZIndex(0)
            marker.setIcon(pin)
        });

        if(currentMarker !== marker) {
            currentMarker = marker;
            marker.setZIndex(100);
            marker.setIcon(largePin);
            officeItems.forEach(officeItem => officeItem.classList.add('hide'));
            const currentOffice = [...officeItems].find(item => item.dataset.id == marker.id);
            currentOffice.classList.remove('hide');
        } else {
            currentMarker = null;
            marker.setIcon(pin)
            officeItems.forEach(officeItem => officeItem.classList.remove('hide'));
        }

    });
}


function centerMap( map ) {
    // Create map boundaries from all map markers.
    bounds = new google.maps.LatLngBounds();
    map.markers.forEach(marker => {
        bounds.extend({
            lat: marker.position.lat(),
            lng: marker.position.lng()
        });
    });

    // Case: Single marker.
    if( map.markers.length == 1 ){
        map.setCenter( bounds.getCenter() );

    // Case: Multiple markers.
    } else {
        map.fitBounds( bounds );
    }
}

officeItems.forEach(officeItem => {
    officeItem.addEventListener('mouseover', function() {
        markersArray.map(marker => {
            if( marker.id == officeItem.dataset.id ) {   
                marker.setZIndex(100);
                marker.setIcon(largePin);
            }
        });
    });

    officeItem.addEventListener('mouseout', function() {
        markersArray.map(marker => {
            if( marker.id == officeItem.dataset.id && currentMarker !== marker ) {   
                marker.setZIndex(0);
                marker.setIcon(pin);
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", initMap);

const locationButton = document.querySelector('#location-btn');
locationButton.addEventListener("click", getMyLocation);


function rad(x) {return x*Math.PI/180;}
function getClosestOffice(myPosition) {                      
    var lat = myPosition.lat;
    var lng = myPosition.lng;
    var R = 6371; // radius of earth in km
    var distances = [];
    var closest = -1;
    for( i = 0; i < markersArray.length; i++ ) {
        var mlat = markersArray[i].position.lat();
        var mlng = markersArray[i].position.lng();
        var dLat  = rad(mlat - lat);
        var dLong = rad(mlng - lng);
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        distances[i] = d;
        if ( closest == -1 || d < distances[closest] ) {
            closest = i;
        }
    }

    centerPos = {
        lat: markersArray[closest].position.lat(),
        lng: markersArray[closest].position.lng()
    }

    markersArray[closest].setIcon(largePin);
    markersArray[closest].setZIndex(100);
    currentMarker = markersArray[closest];

    officeItems.forEach(officeItem => officeItem.classList.add('hide'));
    const currentOffice = [...officeItems].find(item => item.dataset.id == markersArray[closest].id);
    currentOffice.classList.remove('hide');
}


// När man klickar på knappen Hitta min närmaste Francks
function getMyLocation(myPosition) {
    if ( myMarker ) myMarker.setMap(null);
    if (navigator.geolocation) {
        locationButton.innerHTML = 'Hittar din närmaste Francks';
        navigator.geolocation.getCurrentPosition(
          (position) => {

            myPosition = {
                lat: parseFloat(position.coords.latitude),
                lng: parseFloat(position.coords.longitude),
            };

            // map.setCenter(myPosition);
            // map.setZoom(8);

            getClosestOffice(myPosition);

            let markerPositions = [centerPos, myPosition];
            bounds = new google.maps.LatLngBounds();
            markerPositions.map(marker => {
                bounds.extend({
                    lat: marker.lat,
                    lng: marker.lng
                });
            });
            
            map.fitBounds(bounds);

            locationButton.innerHTML = 'Använd min position';

            myMarker = new google.maps.Marker({
                position : myPosition,
                map,
                icon: me,
                optimized: false,
                animation: google.maps.Animation.BOUNCE
            });
      
            setTimeout(() => {
                myMarker.setAnimation(null);
            }, 2200);
        
          },
          () => {
            handleLocationError(true, map.getCenter());
          }
        );     
    } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, map.getCenter());
    }
}


// Om man inte har accepterat geolocation i webbläsaren eller om det inte stöds.
function handleLocationError(browserHasGeolocation, myPosition) {
    console.log(
      browserHasGeolocation
        ? "Error: The Geolocation service failed."
        : "Error: Your browser doesn't support geolocation."
    );
}


// När man söker med hjälp av Google fältet
function getSearchedLocation(myPosition) {
    const options = {
        fields: ["geometry"],
        strictBounds: false,
    };

    const autocomplete = new google.maps.places.Autocomplete(searchInput, options);

    document.body.addEventListener('keyup', function(e){
        if ( showing < 1 ) {
            document.querySelector('.pac-container').classList.remove('hide');
        } else {
            document.querySelector('.pac-container').classList.add('hide');
        }
    });

    autocomplete.bindTo("bounds", map);

    searchMarker = new google.maps.Marker({
        map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener("place_changed", () => {
        searchMarker.setVisible(false);
        const place = autocomplete.getPlace();
    
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
          map.fitBounds(place.geometry.viewport);
        } else {
          map.setCenter(place.geometry.location);
          map.setZoom(8);
        }
        searchMarker.setPosition(place.geometry.location);
        searchMarker.setVisible(true);

        myPosition = {
            lat: parseFloat(place.geometry.location.lat()),
            lng: parseFloat(place.geometry.location.lng()),
        };
        getClosestOffice(myPosition);

        let markerPositions = [centerPos, myPosition];
        bounds = new google.maps.LatLngBounds();
        markerPositions.map(marker => {
            bounds.extend({
                lat: marker.lat,
                lng: marker.lng
            });
        });
        
        map.fitBounds(bounds);
    });
}
document.addEventListener("DOMContentLoaded", getSearchedLocation);

const uparrow = document.querySelector('#uparrow');
const officeWrapper = document.querySelector('.lw-map--offices');
uparrow.addEventListener('click', ()=> {
    officeWrapper.classList.toggle('active');
})


const nothingFound = document.querySelector('.nothing-found');
function displayMatches() {
    var searchVal, i, txtValue, markVal; 
    searchVal = searchInput.value.toUpperCase();    
    showing = 0;

    for (i = 0; i < officeItems.length; i++) {

        txtValue = officeItems[i].textContent || officeItems[i].innerText;
        if (txtValue.toUpperCase().indexOf(searchVal) > -1) {
            showing += 1;
            officeItems[i].classList.remove('hide');
        } else {
            officeItems[i].classList.add('hide');
        }

    }

    for (i = 0; i < markersArray.length; i++) {
        markVal = markersArray[i].address;
        if (markVal.toUpperCase().indexOf(searchVal) > -1) {
            markersArray[i].setZIndex(100);
            markersArray[i].setIcon(largePin);
            currentMarker = markersArray[i];
        } else {
            markersArray[i].setZIndex(0);
            markersArray[i].setIcon(pin);
        }
    }

    if ( searchInput.value === '' ) {
        resetAll();
    } 
}

searchInput.addEventListener('keyup', displayMatches);


function resetAll() {
    map.markers.map(marker => {
        marker.setZIndex(0)
        marker.setIcon(pin)
    });
    officeItems.forEach(officeItem => officeItem.classList.remove('hide'));
    searchInput.value = '';
    if ( searchMarker ) searchMarker.setMap(null);
    if ( myMarker ) myMarker.setMap(null);
    centerMap( map );
}
document.querySelector('.reset-offices').addEventListener('click', resetAll);

document.querySelectorAll('.lw-office-item--find-btn').forEach(btn => btn.addEventListener('click', function() {
    btn.parentNode.classList.toggle('active');
}));


// let dropDownItems;
// document.body.addEventListener('keyup', function(e){
//     e.preventDefault();
//     if ( e.code === 'Enter' ) {
//         const dropDownItem = document.getElementsByClassName('pac-item-selected');
//         console.log(e.code, dropDownItem.innerHTML);
//         if( dropDownItem ) {
//             console.log(dropDownItem);
//         }
//         // dropDownItems.forEach(item => {
//         // })
//     }
// })