<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birth Certificate Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            color: #8B0000;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        .photo-preview {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ddd;
            margin-top: 10px;
        }

        .btn-submit {
            background-color: #8B0000;
            border: none;
            padding: 10px 30px;
            font-weight: bold;
        }

        .btn-submit:hover {
            background-color: #6d0000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Birth Certificate Registration Form</h2>
            <form id="birthForm" action="generate_certificate.php" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="childName" class="form-label required-field">Child's Full Name</label>
                        <input type="text" class="form-control" id="childName" name="childName" required>
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label required-field">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="birthDay" class="form-label required-field">Day of Birth</label>
                        <select class="form-select" id="birthDay" name="birthDay" required>
                            <option value="">Day</option>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="birthMonth" class="form-label required-field">Month of Birth</label>
                        <select class="form-select" id="birthMonth" name="birthMonth" required>
                            <option value="">Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="birthYear" class="form-label required-field">Year of Birth</label>
                        <select class="form-select" id="birthYear" name="birthYear" required>
                            <option value="">Year</option>
                            <?php for ($i = date('Y'); $i >= 1950; $i--): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fatherName" class="form-label required-field">Father's Full Name</label>
                        <input type="text" class="form-control" id="fatherName" name="fatherName" required>
                    </div>
                    <div class="col-md-6">
                        <label for="motherName" class="form-label required-field">Mother's Full Name</label>
                        <input type="text" class="form-control" id="motherName" name="motherName" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="placeOfBirth" class="form-label required-field">Place of Birth</label>
                    <input type="text" class="form-control" id="placeOfBirth" name="placeOfBirth" value="Ginjo Kebele, Jimma" readonly>
                </div>

                <div class="mb-3">
                    <label for="childPhoto" class="form-label required-field">Child's Photo (35mm x 45mm)</label>
                    <input type="file" class="form-control" id="childPhoto" name="childPhoto" accept="image/*" required>
                    <small class="text-muted">Please upload a passport-sized photo</small>
                    <img id="photoPreview" class="photo-preview d-none" alt="Photo Preview">
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                    <button type="submit" class="btn btn-primary btn-submit">Generate Certificate</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Photo preview functionality
        document.getElementById('childPhoto').addEventListener('change', function(e) {
            const preview = document.getElementById('photoPreview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>