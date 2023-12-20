const escapeHtml = (unsafe) => {
    return unsafe.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;').replaceAll("'", '&#039;');
};

let map, markers = [];

async function initMap() {
    const zoom = 8.35;
    var center = new google.maps.LatLng(47.5751, 0.31366);
    map = new google.maps.Map(document.getElementById("map"), {
        zoom,
        center,
        minZoom: zoom,
        disableDefaultUI: true,
        restriction: {
            latLngBounds: {
                north: 48.1,
                south: 46.8,
                west: -1.7,
                east: 2.4
            }
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
        data.results.forEach(d => {
            let mark = new google.maps.Marker({
                map,
                position: { lat: d.lat, lng: d.long },
                title: d.name,
            });
            markers.push(mark);
            mark.addListener("click", async () => {
                try {
                    document.getElementById("myModal").style.display = "block";
                    document.getElementById("modalcontent").innerHTML = "Chargement...";
                    let response = await fetch("/api/details?l=" + d.id);

                    if (response.ok) {
                        let data = (await response.json()).data;

                        let name = data.name;
                        let preview = data.preview.source;
                        let address = data.address.county;
                        let wikipedia = data.wikipedia;
                        let wikipedia_extracts = data.wikipedia_extracts.text;

                        let contextText = ` <img src="${preview}"> <br> <alt="Preview Image - ${preview}"> <br> Name : ${name} <br> Address : ${address} <br> wikipedia : <a href="${wikipedia}" target="_blank">${wikipedia}</a> <br> Description  : ${wikipedia_extracts}`;

                        document.getElementById('modalcontent').innerHTML = contextText;
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
        document.getElementsByClassName("loadingscreen")[0].remove();
    }
    )).catch(err => console.log(err));
}

let geoloc = document.querySelector(".geoloc");
let geoIcon = document.querySelector(".geoloc-loc");
let geoIconBlue = document.querySelector(".geoloc-loc_blue");
let burger = document.querySelector(".burger");
let nav = document.querySelector("#nav");
let logoPlace = document.querySelector("#logo");

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

burger.addEventListener("click", () => {
    nav.classList.toggle("nav-visible");
    burger.classList.toggle("cross");
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

