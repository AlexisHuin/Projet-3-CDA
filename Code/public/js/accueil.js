let map;

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
    map = new google.maps.Map(document.getElementById("map"), {
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
    await fetch("/api/search").then(res => res.json().then(data => {
        console.log(data);
        data.results.forEach(d => {
            let mark = new google.maps.Marker({
                map,
                position: { lat: d.lat, lng: d.long },
                title: d.name,
            });
            mark.addListener("click", async () => {
                try {
                    let response = await fetch("/api/details?l=" + d.id);
                    
                    if (response.ok) {
                        let data = await response.json();
                        console.log(data)
                        let name = data.data.name;
                        let preview = data.data.preview.source
                        let address = data.data.address.county;
                        let wikipedia = data.data.wikipedia;
                        let wikipedia_extracts = data.data.wikipedia_extracts.text;

                        let contextText = ` <img src="${preview}"> <br> <alt="Preview Image - ${preview}"> <br> Name : ${name} <br> Address : ${address} <br> wikipedia : <a href="${wikipedia}" target="_blank">${wikipedia}</a> <br> Description  : ${wikipedia_extracts}`
                        
                        

                        
                
                        document.getElementById('modalcontent').innerHTML = contextText
                        document.getElementById("myModal").style.display = "block";
                    } else {
                        console.error("La requête a échoué avec le statut :", response.status);
                    }
                } catch (error) {
                    console.error("Erreur lors de la récupération des données :", error);
                }
                document.querySelector(".close").addEventListener("click", () => {
                    document.getElementById("myModal").style.display = "none";
                });
                window.addEventListener("click", (event) => {
                    if (event.target == document.getElementById("myModal")) {
                        document.getElementById("myModal").style.display = "none";
                    }
                });
            });
        });
    })).catch(err => console.log(err));
}


// Fonction pour géré l'état du bouton de géolocalisation
(function switchGeo() {
    let geoloc = document.querySelector(".geoloc");
    let geoIcon = document.querySelector(".geoloc-loc");
    let geoIconBlue = document.querySelector(".geoloc-loc_blue");

    geoloc.addEventListener("click", () => {
        if (geoIcon.style.display !== "none") {
            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    var crd = pos.coords;

                    new google.maps.Marker({
                        map,
                        position: { lat: crd.latitude, lng: crd.longitude },
                        title: "bonjour",
                        icon: "/img/geo-blue.png"
                    });
                },
                function (err) {
                    console.warn(err);
                }, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0,
            });


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

        if (line1.style.transform === "rotate(-45deg)") {
            // is X, transform back to burger

            line1.style.transform = "rotate(0deg)";
            line1.style.top = "1rem";
            line1.style.left = "1rem";

            line2.style.top = "5rem";
            line2.style.opacity = "1";
            line2.style.left = "1rem";

            line3.style.top = "3rem";
            line3.style.left = "1rem";
            line3.style.transform = "rotate(0deg)";
        } else {
            // is burger, transform to X

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
    let nav = document.querySelector("#nav");
    let logoPlace = document.querySelector("#logo");
    let burger = document.querySelector(".burger");

    burger.addEventListener("click", () => {
        nav.classList.toggle("nav-visible");
        if (nav.style.display === "flex") {
            logoPlace.innerHTML = "";
            nav.style.display = "none";
        } else {
            nav.style.display = "flex";
            let logo = document.createElement("img");
            logo.src = "img/logoVDL.png";
            logo.alt = "Logo Val De Loire";

            logoPlace.appendChild(logo);

        }
    });
})();


