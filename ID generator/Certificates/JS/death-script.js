document
  .getElementById("deathCertificateForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Validate form
    if (!this.checkValidity()) {
      alert("Please fill all required fields!");
      return;
    }

    // Simulate certificate generation
    alert("Certificate generated successfully!");
    // In a real app, redirect to a PDF or display a preview.
  });
