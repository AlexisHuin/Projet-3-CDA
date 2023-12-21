let blocks = document.querySelectorAll(".block");
let selectAll = false;

blocks.forEach((block) => {
  let originalBorderStyle = window.getComputedStyle(block).border;

  block.addEventListener("click", () => {
    let category = block.classList[1];

    if (category === "nonfiltré") {
      blocks.forEach((otherBlock) => {
        if (selectAll) {
          otherBlock.style.border = originalBorderStyle;
        } else {
          otherBlock.style.border = "0.5em solid lightgreen";
        }
      });

      selectAll = !selectAll;
    } else {
      if (block.style.border === "0.5em solid lightgreen") {
        block.style.border = originalBorderStyle;
      } else {
        block.style.border = "0.5em solid lightgreen";
      }
      selectAll = false;
    }
  });
});
