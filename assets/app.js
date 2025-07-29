import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import 'bootstrap';
import './styles/app.scss';


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');


let map = document.querySelector("#map");

if (map !== null) {

    const locationsJson = map.getAttribute('data-location-items');
    let locations = [];
    if (locationsJson) {
        locations = JSON.parse(locationsJson);
    }

    map = L.map('map').setView([45.783, 3.083], 9);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    for (let i = 0; i < locations.length; i++) {
        let location = locations[i]

        let marker = L.marker([location.latitude, location.longitude]).addTo(map);

        const cardElement = document.querySelector('[data-location-id="' + location.id + '"]');
        marker.on('click', () => {
            cardElement.style.backgroundColor = 'lightblue';

            const elementAlreadyFocus = document.querySelector('.location-focus');
            if (elementAlreadyFocus) {
                elementAlreadyFocus.classList.remove('location-focus');

            }
            cardElement.scrollIntoView();
            cardElement.classList.add('location-focus');
        });
        cardElement.addEventListener('click', () => {
            console.log(location)
            map.flyTo([location.latitude, location.longitude], 12);
            marker.bindPopup("<b>"+location.address+"</b>").openPopup();
        });
    }
}


