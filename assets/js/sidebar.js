document.addEventListener("DOMContentLoaded", function () {
  const hamburgerMenuButton = document.getElementById("hamburger-menu");
  const menu = document.getElementById("menu");

  hamburgerMenuButton.addEventListener("click", function () {
    menu.classList.toggle("hidden");
  });
});
