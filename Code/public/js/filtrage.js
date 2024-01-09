let blocks = document.querySelectorAll(".block");
let selectAll = true;

blocks.forEach((otherBlock) => {
    otherBlock.style.border = "0.5em solid lightgreen";
});

blocks.forEach((block) => {

    block.addEventListener("click", () => {
        let category = block.classList[1];
        if (category === "nonfiltré") {
            blocks.forEach((otherBlock) => {
                if (selectAll) {
                    otherBlock.style.border = "none";
                } else {
                    otherBlock.style.border = "0.5em solid lightgreen";
                }
            });
            selectAll = !selectAll;
        } else {
            if (block.style.border === "0.5em solid lightgreen") {
                block.style.border = "none";
            } else {
                block.style.border = "0.5em solid lightgreen";
            }
            selectAll = false;
        }

        if (window.location.pathname === "/") {
            if (block.style.border === "0.5em solid lightgreen") { // vient d'etre cliqué
                console.log("cliqué sur " + category);
                markers.forEach(m => {
                    if (category === "nonfiltré" || m.d.kinds.includes(category)) {
                        m.mark.setOpacity(1);
                    }
                });
            } else {
                console.log("décliqué sur " + category);
                markers.forEach(m => {
                    if (category === "nonfiltré" || m.d.kinds.includes(category)) {
                        m.mark.setOpacity(0);
                    }
                });
            }
        }
    });
});
