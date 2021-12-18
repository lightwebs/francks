// const Qs = require('qs');
// const axios = require('axios');
var map, marker, allMarkers, bounds, pin, largePin, me;
var markers = [];
let officeItems = document.querySelectorAll('.lw-office-item');
const storeItemHeaders = document.querySelectorAll('.store-item-header');

function initMap() {
    allMarkers = document.querySelectorAll('.marker');
    
    // Create gerenic map.
    var mapArgs = {
        zoom        : 16,
        mapTypeId   : google.maps.MapTypeId.ROADMAP,
        // center: true,
        disableDefaultUI: true,
        gestureHandling: "greedy",
        zoomControl: false,
        // restriction: {
        //     latLngBounds: {
        //         north: 69.5,
        //         south: 55.1331192,
        //         east: 25.0,
        //         west: 10.6,
        //     },
        //     // strictBounds: true,
        // },
    };
    
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
    pin = {
        url: `${lwGlobal.templateDir}/assets/img/icons/map-pin.png`,
        scaledSize: new google.maps.Size(27, 44),
    }
    largePin = {
        url: `${lwGlobal.templateDir}/assets/img/icons/map-pin-red.png`,
        scaledSize: new google.maps.Size(36, 56),
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
        optimized: false,
        animation: google.maps.Animation.DROP
    });

    // Append to reference for later use.
    map.markers.push( marker );

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

// function getStore( ajaxData ) {
//     const noStoresToShow = document.querySelector('.no-stores-to-show');
    
//     axios.post(lwGlobal.adminUrl, Qs.stringify(ajaxData))
//     .then(function(response) {
//         officeItems = document.querySelectorAll('.store-item');
//         bounds = new google.maps.LatLngBounds();
//         markers = map.markers;

//         if( [...response.data].length == '' ){
//             officeItems.forEach(store => store.classList.add('hide'));
//             noStoresToShow.classList.add('show');
//             markers.map(marker => marker.setMap(null));
//             return;
//         } else {
//             noStoresToShow.classList.remove('show');
//         }

//         // Loopar igenom resultatet och retunerar en array med lat och lang
//         const markerProps = [...response.data].map(marker => {
//             return { 
//                 lat : parseFloat(marker.lat),
//                 lng : parseFloat(marker.lng),
//                 id : parseFloat(marker.id)
//             }
//         });

//         // Filtrerar bort marker vars id inte finns med i det retunerade resultatet - del 1
//         markers.map(marker => marker.setMap(null));

//         // Filtrerar bort butiker vars id inte finns med i det retunerade resultatet - del 1
//         officeItems.forEach(store => store.classList.add('hide'));
//         // Loopar igenom resultatet och lägger till markerna på kartan utifrån vilken lat och lang som retuneras
//         var i;
//         for ( i in [...response.data] ) {
//             bounds.extend({
//                 lat: parseFloat(markerProps[i].lat),
//                 lng: parseFloat(markerProps[i].lng)
//             });
            
//             // Filtrerar bort butiker vars id inte finns med i det retunerade resultatet - del 2
//             officeItems.forEach(store => {
//                 if (store.dataset.id == markerProps[i].id) {
//                     store.classList.remove('hide');
//                 }
//             });
                                
//             // Filtrerar bort marker vars id inte finns med i det retunerade resultatet - del 2
//             markers.map(marker => {
//                 if( marker.id == markerProps[i].id ){
//                     marker.setMap(map)
//                 }
//             });
//         }
    
//         // 2. Centrerar kartan utifrån kartgränserna
//         // Om det bara är ett resultat/marker
//         if( response.length == 1 ){
//             map.setCenter( bounds.getCenter() );
//             map.setZoom(16);
            
//             // Om det är flera resultat/marker
//         } else {
//             map.fitBounds( bounds );                    
//         }
        
//         storeQty.innerHTML = response.data.length;
//     })
//     .catch(err => console.log(err));

// };


// export function populateAjax(e) {
//     const filterCats = document.querySelectorAll('#filter-categories .filter-item');
//     const filterGenders = document.querySelectorAll('#filter-gender .filter-item');
//     const filterAreas = document.querySelectorAll('#filter-areas .filter-item');
//     const filterCities = document.querySelectorAll('#filter-cities .filter-item');
//     const filterSubareas = document.querySelectorAll('#filter-subareas .filter-item');
    
//     if( e && e.target.matches('.clear-filters') ) {
//         clearFilterParent = e.target.parentElement;
//         checkedInputs = clearFilterParent.querySelectorAll('input');
//         checkedInputs.forEach(input => {
//             input.checked = false;
//         });
//     }

//     var ajaxData = {
//         action : 'get_store',
//         security : lwGlobal.getStore
//     };

//     if( e && e.target.matches('.store-name') ) {
//         ajaxData.storeId = parseInt(e.target.dataset.id);
//     };

//     const cats = [];
//     filterCats.forEach(filterCat => {
//         if( filterCat.checked ){
//             cats.push(parseInt(filterCat.dataset.id));
//             ajaxData.catId = cats;
//         }
//     });
    
//     const genders = [];
//     filterGenders.forEach(filterGender => {
//         if( filterGender.checked ){
//             genders.push(parseInt(filterGender.dataset.id));
//             ajaxData.genId = genders;
//         }
//     });
    
//     const cities = [];
//     filterCities.forEach(filterCity => {
//         if( filterCity.checked ) {
//             cities.push(parseInt(filterCity.dataset.id))
//             ajaxData.cityId = cities;
//         } 
//     });
    
//     const subareas = [];
//     filterSubareas.forEach(filterSubareas => {
//         if( filterSubareas.checked ) {
//             subareas.push(parseInt(filterSubareas.dataset.id))
//             ajaxData.subareaId = subareas;
//         } 
//     });
    
//     const areas = [];
//     filterAreas.forEach(filterAreas => {
//         if( filterAreas.checked ) {
//             areas.push(filterAreas.dataset.id)
//             ajaxData.areaId = areas;
//         } 
//     });
    
//     getStore(ajaxData, e);
//     return ajaxData;
// }


officeItems.forEach(officeItem => officeItem.addEventListener('mouseover', function() {
    map.markers.map(marker => {
        if( marker.id == officeItem.dataset.id ) {   
            marker.setIcon(largePin);
            marker.setZIndex(100);
        }
    });
}));

officeItems.forEach(officeItem => officeItem.addEventListener('mouseout', function() {
    map.markers.map(marker => {
        if( marker.id == officeItem.dataset.id && currentMarker !== marker ) {   
            marker.setIcon(pin);
            marker.setZIndex(0);
        }
    });
}));


document.addEventListener("DOMContentLoaded", initMap);

const locationButton = document.querySelector('#location-btn');
locationButton.addEventListener("click", getMyLocation);
function rad(x) {return x*Math.PI/180;}

function getMyLocation(myPosition) {
    if (navigator.geolocation) {
        locationButton.innerHTML = 'Hittar din position';
        navigator.geolocation.getCurrentPosition(
          (position) => {
            myPosition = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };            
            map.setCenter(myPosition);
            map.setZoom(6);
            locationButton.innerHTML = 'Använd min position';
            showStoresCloseToMe(myPosition);
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


function showStoresCloseToMe( myPosition ) {
    // var lat = myPosition.lat;
    // var lng = myPosition.lng;
    // var R = 6371; // radius of earth in km
    // var distances = [];
    // var closest = -1;
    // for( i=0; i<map.markers.length; i++ ) {
    //     var mlat = map.markers[i].position.lat();
    //     var mlng = map.markers[i].position.lng();
    //     var dLat  = rad(mlat - lat);
    //     var dLong = rad(mlng - lng);
    //     var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
    //         Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
    //     var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    //     var d = R * c;
    //     distances[i] = d;

    //     if ( closest == -1 || d < distances[closest] ) {
    //         closest = i;
    //     }
    // }
    // console.log('name: ' + map.markers[closest]);

    
    // var markerContent = marker.innerHTML;

    // Create marker instance.
    marker = new google.maps.Marker({
        position : myPosition,
        map,
        icon: me,
        optimized: false,
        animation: google.maps.Animation.BOUNCE
    });

    setTimeout(() => {
        marker.setAnimation(null);
    }, 2200);

    officeItems.forEach(officeItem => {
        const officeLat = officeItem.dataset.lat;
        const officeLng = officeItem.dataset.lng;

        if ( myPosition.lat - officeLat > 0.5 && myPosition.lng - officeLng > 0.5 ) {
            officeItem.classList.add('hide');
        }
        // console.log(myPosition.lat - officeLat, myPosition.lng - officeLng);
    })
}

function handleLocationError(browserHasGeolocation, myPosition) {
    console.log(
      browserHasGeolocation
        ? "Error: The Geolocation service failed."
        : "Error: Your browser doesn't support geolocation."
    );
}


const uparrow = document.querySelector('#uparrow');
const officeWrapper = document.querySelector('.lw-map--offices');
uparrow.addEventListener('click', ()=> {
    officeWrapper.classList.toggle('active');
})



const searchInput = document.querySelector('.lw-map--search--input');
const nothingFound = document.querySelector('.nothing-found');

function displayMatches(e) {
    var searchVal, i, txtValue, marker;
    searchVal = searchInput.value.toUpperCase();
    marker = map.markers;

    for (i = 0; i < officeItems.length; i++) {
        txtValue = officeItems[i].textContent || officeItems[i].innerText;
        if (txtValue.toUpperCase().indexOf(searchVal) > -1) {
            officeItems[i].classList.remove('hide');
            
            marker.map(mar => {
                if ( mar.id == officeItems[i].dataset.id && searchInput.value != '' ) {
                    mar.setIcon(largePin);
                    mar.setZIndex(100);
                }
            });

        } else {
            marker[i].setIcon(pin);
            marker[i].setZIndex(0);
            officeItems[i].classList.add('hide');
        }
    }

    if ( searchInput.value === '' ) {
        resetAll();
    } 
}

if (searchInput) {
    searchInput.addEventListener('keyup', displayMatches);
}



function resetAll() {
    map.markers.map(marker => {
        marker.setZIndex(0)
        marker.setIcon(pin)
    });
    officeItems.forEach(officeItem => officeItem.classList.remove('hide'));
    centerMap( map );
}
const resetOffices = document.querySelector('.reset-offices');
resetOffices.addEventListener('click', resetAll);