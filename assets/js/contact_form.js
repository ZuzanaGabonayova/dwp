document.addEventListener("DOMContentLoaded", function () {
  var form = document.getElementById("contact-form");
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    var formData = new FormData(form);
    fetch("../actions/contact.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status) {
          // Success message
          document.getElementById("successMessage").innerText = data.message;
          document.getElementById("successMessage").classList.remove("hidden");
          document.getElementById("errorMessage").classList.add("hidden");
          form.reset(); // Reset the form
        } else {
          // Error message
          document.getElementById("errorMessage").innerText = data.message;
          document.getElementById("errorMessage").classList.remove("hidden");
          document.getElementById("successMessage").classList.add("hidden");
        }
      })
      .catch((error) => {
        document.getElementById("errorMessage").innerText =
          "An error occurred: " + error;
        document.getElementById("errorMessage").classList.remove("hidden");
        document.getElementById("successMessage").classList.add("hidden");
      });
  });
});
