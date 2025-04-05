document
  .querySelector(".continue-button")
  .addEventListener("click", function () {
    window.location.href = "categories.php";
  });

// Add touch events for mobile
document
  .querySelector(".continue-button")
  .addEventListener("touchstart", function () {
    this.style.backgroundColor = "#444";
  });

document
  .querySelector(".continue-button")
  .addEventListener("touchend", function () {
    this.style.backgroundColor = "#333";
    window.location.href = "categories.php";
  });
