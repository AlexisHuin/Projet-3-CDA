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

    if (line1.style.transform === "rotate(-45deg)") {
      line1.style.transform = "rotate(0deg)";
      line1.style.top = "1rem";
      line2.style.top = "5rem";
      line3.style.top = "3rem";
      line1.style.left = "1rem";
      line2.style.left = "1rem";
      line3.style.left = "1rem";
      line2.style.opacity = "1";
      line3.style.transform = "rotate(0deg)";
    } else {
      line1.style.transform = "rotate(-45deg)";
      line1.style.top = "3rem";
      line2.style.opacity = "0";
      line3.style.transform = "rotate(45deg)";
      line3.style.bottom = "3rem";
      line1.style.transition = "0.5s";
      line3.style.transition = "0.5s";
    }
  });
})();
