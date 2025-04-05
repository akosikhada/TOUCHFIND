// Clear cart after successful order
document.addEventListener("DOMContentLoaded", function () {
  // Clear the cart in localStorage
  localStorage.setItem("touchfindCart", JSON.stringify([]));

  // Add button to go back to shopping with smoother animation
  setTimeout(() => {
    const container = document.querySelector(".success-container");
    const footer = document.querySelector(".footer");

    // Create button with class instead of inline styles
    const button = document.createElement("button");
    button.textContent = "Continue Shopping";
    button.className = "continue-button";

    // Add click handler
    button.onclick = function () {
      window.location.href = "categories.php";
    };

    // Insert before footer
    container.insertBefore(button, footer);

    // Trigger animation after a short delay for smoother effect
    requestAnimationFrame(() => {
      setTimeout(() => {
        button.classList.add("visible");
      }, 50);
    });
  }, 1200);
});
