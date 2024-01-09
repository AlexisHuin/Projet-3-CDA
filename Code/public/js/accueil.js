const escapeHtml = (unsafe) => {
    return unsafe
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
};

let map,
    markers = [];
let myModal = document.getElementById("myModal");
let geoloc = document.querySelector(".geoloc");
let geoIcon = document.querySelector(".geoloc-loc");
let geoIconBlue = document.querySelector(".geoloc-loc_blue");
let burger = document.querySelector(".burger");
let imgburger = document.querySelector("#img_burger");
let nav = document.querySelector("#nav");
let logoPlace = document.querySelector("#logo");
let mentionslegales = document.querySelector("#mentionslegales_btn");

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

    await fetch("/api/get_places").then(res => res.json().then(data => {
        const categories = ["castle", ""];
        data.results.forEach(d => {
            let mark = new google.maps.Marker({
                map,
                position: { lat: d.lat, lng: d.long },
                title: d.name,
                icon: "/img/geo-blue.png",
            });
            markers.push({ d, mark });
            mark.addListener("click", async () => {
                try {
                    myModal.style.display = "block";
                    document.getElementById("modalcontent").innerHTML = "Chargement...";
                    let details = (await (await fetch(`/api/places/${d.id}/details`)).json()).data;
                    let commentaires = (await (await fetch(`/api/places/${d.id}/comments`)).json());
                    console.log(commentaires);
                    let name = details.name;
                    let preview = details.preview.source;
                    let address = details.address.county;
                    let wikipedia = details.wikipedia;
                    let wikipedia_extracts = details.wikipedia_extracts.text;
                    let contextText = ` <img src="${preview}" alt="Preview Image - ${preview}"> <p>Name : ${name}</p><p>Address : ${address}</p><p><a href="${wikipedia}" target="_blank">Wikipedia</a></p> <p>Description  : ${wikipedia_extracts}</p> <h2>Commentaires</h2>`;
                    if (commentaires.found === false) {
                        contextText += `<p>${commentaires.msg}</p>`;
                    } else {
                        commentaires.comments.forEach(c => {
                            contextText += `<div class="commentaire"> <div class='commentaire_photo'><h3>${c.user}</h3> <img src='/user_imgs/avatars/${c.user_avatar}'> </div> <p>${escapeHtml(c.comment)}</p></div>`;
                        });
                    }
                    document.getElementById('modalcontent').innerHTML = contextText;
                } catch (error) {
                    console.error("Erreur lors de la récupération des données :", error);
                }

            });
        });
    })).catch(err => console.error(err));
    document.getElementsByClassName("loadingscreen")[0].remove();
}

document.querySelector(".close").addEventListener("click", () => {
    myModal.style.display = "none";
});
window.addEventListener("click", (event) => {
    if (event.target == myModal) {
        myModal.style.display = "none";
    }
});

geoloc.addEventListener("click", () => {
    if (geoIcon.style.display !== "none") {
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                var crd = pos.coords;

                new google.maps.Marker({
                    map,
                    position: { lat: crd.latitude, lng: crd.longitude },
                    title: "bonjour",
                    icon: "/img/geo-blue.png",
                    zIndex: 100,
                });
            },
            function (err) {
                console.warn(err);
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0,
            }
        );

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

        imgburger.src = "img/menu.png";
        imgburger.alt = "menu";
    } else {
        nav.style.display = "flex";
        let logo = document.createElement("img");
        logo.src = "img/logoVDL.png";
        logo.alt = "Logo Val De Loire";

        logoPlace.appendChild(logo);

        imgburger.src = "img/cross.png";
        imgburger.alt = "croix";
    }
});

mentionslegales.addEventListener("click", () => {
    myModal.style.display = "block";
    document.getElementById("modalcontent").innerHTML = `<h1>Mentions Légales</h1>

    <h2>1. Informations légales</h2>
    <p>Raison sociale : [Nom de votre entreprise]</p>
    <p>Statut juridique : [Forme juridique de votre entreprise]</p>
    <p>Adresse : [Adresse de votre entreprise]</p>
    <p>Email : [Votre adresse email]</p>
    <p>Téléphone : [Votre numéro de téléphone]</p>

    <h2>2. Hébergement du site</h2>
    <p>Le site est hébergé par : [Nom de l'hébergeur]</p>
    <p>Adresse : [Adresse de l'hébergeur]</p>

    <h2>3. Propriété intellectuelle</h2>
    <p>Le contenu du site est la propriété de [Nom de votre entreprise]. Toute reproduction totale ou partielle de ce contenu est interdite sans autorisation préalable.</p>

    <h2>4. Collecte de données personnelles</h2>
    <p>Les données personnelles collectées sur ce site sont uniquement destinées à [Nom de votre entreprise] et ne seront en aucun cas cédées à des tiers. Conformément à la loi [Loi sur la protection des données personnelles], vous disposez d'un droit d'accès, de modification et de suppression de vos données. Pour exercer ce droit, veuillez nous contacter à l'adresse [votre@email.com].</p>

    <h2>5. Cookies</h2>
    <p>Ce site utilise des cookies pour améliorer l'expérience utilisateur. En naviguant sur ce site, vous acceptez l'utilisation de cookies.</p>

    <h2>6. Responsabilité</h2>
    <p>[Nom de votre entreprise] décline toute responsabilité quant au contenu des sites externes liés à celui-ci.</p>

    <p>Ces mentions légales ont été mises à jour le [Date de la dernière mise à jour].</p>`;
});






