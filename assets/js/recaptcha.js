document
  .getElementById("contact-form")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    grecaptcha.ready(function () {
      grecaptcha
        .execute("6LepMS8pAAAAAJPGIRlkaEZr7EdRB1yVdYaXCWnp", {
          action: "submit",
        })
        .then(function (token) {
          // Add your logic to submit to your backend server here.
          var recaptchaResponse = document.getElementById("recaptchaResponse");
          recaptchaResponse.value = token;

          // Now submit the form programmatically
          document.getElementById("contact-form").submit();
        });
    });
  });
