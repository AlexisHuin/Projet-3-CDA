let map;

async function initMap() {
    const zoom = 8.25;
    var center = new google.maps.LatLng(47.363, 0.6);
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
            mark.addListener("click", async () => {
                console.log(d);
                await fetch("/api/details?l=" + d.id).then(async res => {
                    console.log(await res.text());
                    // await res.json().then(data => {
                    //     console.log(data);
                    // });
                }).catch(err =>
                    console.log(err)
                );
            });
        });
    })).catch(err => console.log(err));
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
