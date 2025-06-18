<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marriage Certificate Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .form-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #0d6efd;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        .photo-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="form-title">Marriage Certificate Registration</h2>
        <form id="marriageForm" action="save_marriage_certificate.php" method="POST" enctype="multipart/form-data" novalidate>
            <!-- Certificate Number -->
            <div class="mb-3">
                <label for="certificate_number" class="form-label required-field">Certificate Number</label>
                <input type="text" class="form-control" id="certificate_number" name="certificate_number" required>
                <div class="invalid-feedback">Please provide a certificate number.</div>
            </div>

            <!-- Groom Information -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="groom_name" class="form-label required-field">Groom Name</label>
                    <input type="text" class="form-control" id="groom_name" name="groom_name" required>
                    <div class="invalid-feedback">Please provide the groom's name.</div>
                </div>
                <div class="col-md-6">
                    <label for="groom_photo" class="form-label required-field">Groom Photo</label>
                    <input type="file" class="form-control" id="groom_photo" name="groom_photo" accept="image/*" required>
                    <img id="groomPreview" class="photo-preview" src="#" alt="Groom photo preview">
                    <div class="invalid-feedback">Please upload a photo of the groom.</div>
                </div>
            </div>

            <!-- Bride Information -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="bride_name" class="form-label required-field">Bride Name</label>
                    <input type="text" class="form-control" id="bride_name" name="bride_name" required>
                    <div class="invalid-feedback">Please provide the bride's name.</div>
                </div>
                <div class="col-md-6">
                    <label for="bride_photo" class="form-label required-field">Bride Photo</label>
                    <input type="file" class="form-control" id="bride_photo" name="bride_photo" accept="image/*" required>
                    <img id="bridePreview" class="photo-preview" src="#" alt="Bride photo preview">
                    <div class="invalid-feedback">Please upload a photo of the bride.</div>
                </div>
            </div>

            <!-- Marriage Date -->
            <div class="mb-3">
                <label for="marriage_date" class="form-label required-field">Marriage Date</label>
                <input type="date" class="form-control" id="marriage_date" name="marriage_date" required>
                <div class="invalid-feedback">Please select the marriage date.</div>
            </div>

            <!-- State/Region -->
            <div class="mb-3">
                <label for="state" class="form-label required-field">State/Region</label>
                <input type="text" class="form-control" id="state" name="state" value="Oromia Region" required readonly>
            </div>

            <!-- Witnesses -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="witness1_name" class="form-label required-field">Witness 1 Name</label>
                    <input type="text" class="form-control" id="witness1_name" name="witness1_name" required>
                    <div class="invalid-feedback">Please provide witness 1 name.</div>
                </div>
                <div class="col-md-6">
                    <label for="witness2_name" class="form-label required-field">Witness 2 Name</label>
                    <input type="text" class="form-control" id="witness2_name" name="witness2_name" required>
                    <div class="invalid-feedback">Please provide witness 2 name.</div>
                </div>
            </div>

            <!-- Recorded Date -->
            <div class="mb-3">
                <label for="recorded_on" class="form-label">Recorded On</label>
                <input type="date" class="form-control" id="recorded_on" name="recorded_on">
            </div>

            <!-- Submit Button -->
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary px-5 py-2">Submit</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Form validation
        (function() {
            'use strict'

            // Fetch the form we want to apply custom Bootstrap validation styles to
            const form = document.getElementById('marriageForm')

            // Add event listener for form submission
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)

            // Set recorded date to today by default
            document.getElementById('recorded_on').valueAsDate = new Date();

            // Set maximum marriage date to today
            document.getElementById('marriage_date').max = new Date().toISOString().split("T")[0];

            // Image preview functionality
            document.getElementById('groom_photo').addEventListener('change', function(e) {
                const preview = document.getElementById('groomPreview');
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                    preview.style.display = 'none';
                }
            });

            document.getElementById('bride_photo').addEventListener('change', function(e) {
                const preview = document.getElementById('bridePreview');
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "";
                    preview.style.display = 'none';
                }
            });

            // Validate file type for photos
            const photoInputs = [document.getElementById('groom_photo'), document.getElementById('bride_photo')];

            photoInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!validTypes.includes(file.type)) {
                            this.setCustomValidity('Please upload an image file (JPEG, PNG, or GIF)');
                            this.reportValidity();
                            this.value = '';
                        } else {
                            this.setCustomValidity('');
                        }
                    }
                });
            });
        })()
    </script>
</body>

</html>