(()=>{var e={138:()=>{function e(e){return function(e){if(Array.isArray(e))return t(e)}(e)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(e)||function(e,n){if(e){if("string"==typeof e)return t(e,n);var o=Object.prototype.toString.call(e).slice(8,-1);return"Object"===o&&e.constructor&&(o=e.constructor.name),"Map"===o||"Set"===o?Array.from(e):"Arguments"===o||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(o)?t(e,n):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function t(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,o=new Array(t);n<t;n++)o[n]=e[n];return o}var n,o,r,a,s,l,c,d,u,m,p=[],f=document.querySelectorAll(".lw-office-item"),g=document.querySelector(".lw-map--search--input"),v=null;function y(e){r=new google.maps.LatLngBounds,e.markers.forEach((function(e){r.extend({lat:e.position.lat(),lng:e.position.lng()})})),1==e.markers.length?e.setCenter(r.getCenter()):e.fitBounds(r)}f.forEach((function(e){e.addEventListener("mouseover",(function(){p.map((function(t){t.id==e.dataset.id&&(t.setZIndex(100),t.setIcon(s))}))})),e.addEventListener("mouseout",(function(){p.map((function(t){t.id==e.dataset.id&&v!==t&&(t.setZIndex(0),t.setIcon(a))}))}))})),document.addEventListener("DOMContentLoaded",(function(){o=document.querySelectorAll(".marker");var t={zoom:16,mapTypeId:google.maps.MapTypeId.ROADMAP,disableDefaultUI:!0,zoomControl:!1};return window.innerWidth>767&&(t.gestureHandling="greedy"),(n=new google.maps.Map(document.getElementById("f-map"),t)).markers=[],o.forEach((function(t){!function(t,n){var o=t.dataset.lat,r=t.dataset.lng,i=t.dataset.id,c=t.querySelector(".lw-office-item--county"),d=t.querySelector(".lw-office-item--city"),u=t.querySelector(".lw-office-item--address .street_name"),m=t.querySelector(".lw-office-item--address .street_number"),g=t.querySelector(".lw-office-item--address .post_code");a={url:"".concat(lwGlobal.templateDir,"/assets/img/icons/map-pin.png"),scaledSize:new google.maps.Size(27,40),zIndex:0},s={url:"".concat(lwGlobal.templateDir,"/assets/img/icons/map-pin-red.png"),scaledSize:new google.maps.Size(36,56),zIndex:100},l={url:"".concat(lwGlobal.templateDir,"/assets/img/icons/myposition-icon.png"),scaledSize:new google.maps.Size(24,24)};var y={lat:parseFloat(o),lng:parseFloat(r)};t=new google.maps.Marker({position:y,map:n,id:i,icon:a,county:c.textContent,city:d.textContent,address:d.textContent+" "+c.textContent+" "+u.textContent+" "+m.textContent+", "+g.textContent,optimized:!1,animation:google.maps.Animation.DROP}),n.markers.push(t),p.push(t),t.addListener("click",(function(){n.markers.map((function(e){e.setZIndex(0),e.setIcon(a)})),v!==t?(v=t,t.setZIndex(100),t.setIcon(s),f.forEach((function(e){return e.classList.add("hide")})),e(f).find((function(e){return e.dataset.id==t.id})).classList.remove("hide")):(v=null,t.setIcon(a),f.forEach((function(e){return e.classList.remove("hide")})))}))}(t,n)})),y(n),n}));var h=document.querySelector("#location-btn");function w(e){return e*Math.PI/180}function L(t){var n=t.lat,o=t.lng,r=[],a=-1;for(i=0;i<p.length;i++){var l=p[i].position.lat(),c=p[i].position.lng(),d=w(l-n),u=w(c-o),g=Math.sin(d/2)*Math.sin(d/2)+Math.cos(w(n))*Math.cos(w(n))*Math.sin(u/2)*Math.sin(u/2),y=2*Math.atan2(Math.sqrt(g),Math.sqrt(1-g))*6371;r[i]=y,(-1==a||y<r[a])&&(a=i)}m={lat:p[a].position.lat(),lng:p[a].position.lng()},p[a].setIcon(s),p[a].setZIndex(100),v=p[a],f.forEach((function(e){return e.classList.add("hide")})),e(f).find((function(e){return e.dataset.id==p[a].id})).classList.remove("hide")}function x(e,t){console.log(e?"Error: The Geolocation service failed.":"Error: Your browser doesn't support geolocation.")}h.addEventListener("click",(function(e){d&&d.setMap(null),navigator.geolocation?(h.innerHTML="Hittar din närmaste Francks",navigator.geolocation.getCurrentPosition((function(t){L(e={lat:parseFloat(t.coords.latitude),lng:parseFloat(t.coords.longitude)});var o=[m,e];r=new google.maps.LatLngBounds,o.map((function(e){r.extend({lat:e.lat,lng:e.lng})})),n.fitBounds(r),h.innerHTML="Använd min position",d=new google.maps.Marker({position:e,map:n,icon:l,optimized:!1,animation:google.maps.Animation.BOUNCE}),setTimeout((function(){d.setAnimation(null)}),2200)}),(function(){x(!0,n.getCenter())}))):x(!1,n.getCenter())})),document.addEventListener("DOMContentLoaded",(function(e){var t=new google.maps.places.Autocomplete(g,{fields:["geometry"],strictBounds:!1});document.body.addEventListener("keyup",(function(e){u<1?document.querySelector(".pac-container").classList.remove("hide"):document.querySelector(".pac-container").classList.add("hide")})),t.bindTo("bounds",n),c=new google.maps.Marker({map:n,anchorPoint:new google.maps.Point(0,-29)}),t.addListener("place_changed",(function(){c.setVisible(!1);var o=t.getPlace();o.geometry.viewport?n.fitBounds(o.geometry.viewport):(n.setCenter(o.geometry.location),n.setZoom(8)),c.setPosition(o.geometry.location),c.setVisible(!0),L(e={lat:parseFloat(o.geometry.location.lat()),lng:parseFloat(o.geometry.location.lng())});var a=[m,e];r=new google.maps.LatLngBounds,a.map((function(e){r.extend({lat:e.lat,lng:e.lng})})),n.fitBounds(r)}))}));var I=document.querySelector("#uparrow"),S=document.querySelector(".lw-map--offices");function b(){n.markers.map((function(e){e.setZIndex(0),e.setIcon(a)})),f.forEach((function(e){return e.classList.remove("hide")})),g.value="",c&&c.setMap(null),d&&d.setMap(null),y(n)}I.addEventListener("click",(function(){S.classList.toggle("active")})),document.querySelector(".nothing-found"),g.addEventListener("keyup",(function(){var e,t;for(e=g.value.toUpperCase(),u=0,t=0;t<f.length;t++)(f[t].textContent||f[t].innerText).toUpperCase().indexOf(e)>-1?(u+=1,f[t].classList.remove("hide")):f[t].classList.add("hide");for(t=0;t<p.length;t++)p[t].address.toUpperCase().indexOf(e)>-1?(p[t].setZIndex(100),p[t].setIcon(s),v=p[t]):(p[t].setZIndex(0),p[t].setIcon(a));""===g.value&&b()})),document.querySelector(".reset-offices").addEventListener("click",b),document.querySelectorAll(".lw-office-item--find-btn").forEach((function(e){return e.addEventListener("click",(function(){e.parentNode.classList.toggle("active")}))}))}},t={};function n(o){var r=t[o];if(void 0!==r)return r.exports;var a=t[o]={exports:{}};return e[o](a,a.exports,n),a.exports}n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var o in t)n.o(t,o)&&!n.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:t[o]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";n(138)})()})();