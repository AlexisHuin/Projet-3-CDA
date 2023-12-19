// Fonction pour géré l'état du bouton de géolocalisation

(function switchGeo() {
  let geoloc = document.querySelector(".geoloc");
  let geoIcon = document.querySelector(".geoloc-loc");
  let geoIconBlue = document.querySelector(".geoloc-loc_blue");

  geoloc.addEventListener("click", () => {
    if (geoIcon.style.display !== "none") {
      geoIcon.style.display = "none";
      geoIconBlue.style.display = "block";
    } else {
      geoIconBlue.style.display = "none";
      geoIcon.style.display = "block";
    }
  });
})();

// Fonction de transition pour le menu burger

(function switchMenu() {
  document.querySelector(".burger").addEventListener("click", () => {
    let line1 = document.getElementById("line1");
    let line2 = document.getElementById("line2");
    let line3 = document.getElementById("line3");

    if (line1.style.transform === "rotate(-45deg)") { // is X, transform back to burger

      line1.style.transform = "rotate(0deg)";
      line1.style.top = "1rem";
      line1.style.left = "1rem";

      line2.style.top = "5rem";
      line2.style.opacity = "1";
      line2.style.left = "1rem";

      line3.style.top = "3rem";
      line3.style.left = "1rem";
      line3.style.transform = "rotate(0deg)";

    } else { // is burger, transform to X

      line2.style.opacity = "0";

      line1.style.transform = "rotate(-45deg)";
      line1.style.top = "3rem";
      line1.style.transition = "0.25s";

      line3.style.transform = "rotate(45deg)";
      line3.style.bottom = "3rem";
      line3.style.transition = "0.25s";

    }
  });
})();

(function displayNav() {
    let nav = document.querySelector('#nav');
    let burger = document.querySelector(".burger")
    burger.addEventListener('click', () => {
        if (nav.style.display === "flex") {
            nav.classList.remove('nav-visible')
            nav.style.display = "none";
          } else {
            nav.classList.toggle('nav-visible');
            nav.style.display = "flex";
            }  
    })
}) ();


// Créer une fonction asynchrone pour gérer la requête et le traitement des données
async function fetchAndDisplayPlaces() {
  try {
    
    const response = await fetch('https://opentripmap-places-v1.p.rapidapi.com/en/places/bbox?lon_max=2.325511&lat_min=46.784633&lon_min=-1.75033&lat_max=48.199482&limit=20', {
      method: 'GET',
      headers: {
        'X-RapidAPI-Host': 'opentripmap-places-v1.p.rapidapi.com',
        'X-RapidAPI-Key': 'a0da21aed5mshc79b166d2ac2bbdp1f12a8jsn024a611abaf3',
      }
    });

    // Vérifier si la requête est réussie (statut HTTP 200)
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    // Parser la réponse en JSON
    const data = await response.json();
    
    // Ajouter des marqueurs pour chaque lieu
    data.features.forEach(place => {
      const latitude = place.geometry.coordinates[1];
      const longitude = place.geometry.coordinates[0];
      const name = place.properties.name;

      L.marker([latitude, longitude]).addTo(map).bindPopup(name);
    });

  } catch (error) {
    console.error('Erreur lors de la récupération des données:', error);
  }
}

// Appeler la fonction pour démarrer le processus
fetchAndDisplayPlaces();
