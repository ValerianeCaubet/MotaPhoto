

///////////////////// MINIATURES ////////////////////////
console.log("single-photo.js est lancé");

window.addEventListener("DOMContentLoaded", () => {
  const arrowLeft = document.getElementById("arrow-left");
  const arrowRight = document.getElementById("arrow-right");
  const previousImage = document.getElementById("previous-image");
  const nextImage = document.getElementById("next-image");
  const currentImage = document.getElementById("current-image"); 

  if (previousImage != null && arrowLeft != null && currentImage != null) {
    arrowLeft.addEventListener('mouseenter', function(event) {
      previousImage.style.visibility = "visible";
      currentImage.style.visibility = "hidden"; // Cache la miniature de la photo actuelle
      if (nextImage != null) {
        nextImage.style.visibility = "hidden";
      }
    });

    arrowLeft.addEventListener('mouseleave', function(event) {
      previousImage.style.visibility = "hidden";
      currentImage.style.visibility = "visible"; // Réaffiche la miniature de la photo actuelle
    });
  }

  if (nextImage != null && arrowRight != null && currentImage != null) {
    arrowRight.addEventListener('mouseenter', function(event) {
      nextImage.style.visibility = "visible";
      currentImage.style.visibility = "hidden"; // Cache la miniature de la photo actuelle
      previousImage.style.visibility = "hidden";
    });

    arrowRight.addEventListener('mouseleave', function(event) {
      nextImage.style.visibility = "hidden";
      currentImage.style.visibility = "visible"; // Réaffiche la miniature de la photo actuelle
    });
  }
});




