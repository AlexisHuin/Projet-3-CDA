let blocks = document.querySelectorAll(".block");
let selectAll = true;
let cadeauItems = document.querySelectorAll(".accordion");
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
      if (block.style.border === "0.5em solid lightgreen") {
        // vient d'etre cliqué
        markers.forEach((m) => {
          if (category === "nonfiltré" || m.d.kinds.includes(category)) {
            m.mark.setOpacity(1);
          }
        });
      } else {
        markers.forEach((m) => {
          if (category === "nonfiltré" || m.d.kinds.includes(category)) {
            m.mark.setOpacity(0);
          }
        });
      }
    }
    if (window.location.pathname === "/gift") {
      let selectedCategories = Array.from(blocks)
        .filter((block) => block.style.border === "0.5em solid lightgreen")
        .map((block) => block.classList[1].toLowerCase());
      cadeauItems.forEach((cadeauItem) => {
        let itemCategory = Array.from(cadeauItem.classList).filter(
          (className) => className !== "accordion-item"
        );
        itemCategory=itemCategory[itemCategory.length-1]

        if (category === "nonfiltré" || selectedCategories.includes(itemCategory.toLowerCase())) {
          cadeauItem.style.display = "block";
        } else {
          cadeauItem.style.display = "none";
        }
      });
    }
  });
});
