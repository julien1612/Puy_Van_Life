import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import 'bootstrap';
import './styles/app.scss';

//récupération de la map (div map)
let map = document.querySelector("#map");

if (map !== null) {

    //récupération de mes données en json
    const locationsJson = map.getAttribute('data-location-items');
    let locations = [];
    if (locationsJson) {
        //conversion des données json en tableau ([]locations)
        locations = JSON.parse(locationsJson);
    }

    //vue de base de la map
    map = L.map('map').setView([45.783, 3.083], 9);

    //paramétrage de la map
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    //boucle sur les location
    for (let i = 0; i < locations.length; i++) {
        let location = locations[i]

        //positionnement des marker
        let marker = L.marker([location.latitude, location.longitude]).addTo(map);

        //récupération de la card liée a ma location
        const cardElement = document.querySelector('[data-location-id="' + location.id + '"]');

        //événement au click
        marker.on('click', () => {
            cardElement.style.backgroundColor = 'lightblue';

            //si un marker est déja focus on dé-focus
            const elementAlreadyFocus = document.querySelector('.location-focus');
            if (elementAlreadyFocus) {
                elementAlreadyFocus.classList.remove('location-focus');

            }
            cardElement.scrollIntoView();
            cardElement.classList.add('location-focus');
        });

        //au click une card deplace dans la carte pour voir le marker
        cardElement.addEventListener('click', () => {
            map.flyTo([location.latitude, location.longitude], 12);
            marker.bindPopup("<b>"+location.address+"</b>").openPopup();
        });
    }
}

//Gestion des favoris

//4
const favoriteDiv = document.querySelector('[data-favorite]');
const favoriteSvg = favoriteDiv.querySelector('svg');

favoriteSvg.addEventListener('click', () => {
    const idLocation = favoriteDiv.getAttribute('data-favorite');
    fetch("/favorite/" + idLocation)
        .then((response) =>
        {
            //6
            if (response.status === 200)
            {
                favoriteSvg.innerHTML = "<path d=\"M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z\"/>";
            }
            else if (response.status === 201)
            {
                favoriteSvg.innerHTML = "<path d=\"M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z\"/>";
            }
        });
})

