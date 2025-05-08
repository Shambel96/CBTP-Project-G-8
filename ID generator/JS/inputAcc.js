// JavaScript for dynamic form fields
document
  .getElementById("certificateType")
  .addEventListener("change", function () {
    const certificateType = this.value;
    const dynamicFields = document.getElementById("dynamicFields");

    // Clear previous fields
    dynamicFields.innerHTML = "";

    if (certificateType === "birth") {
      dynamicFields.innerHTML = `
        <div class="form-group">
          <label for="childName">Child's Full Name:</label>
          <input type="text" id="childName" name="childName" placeholder="Enter child's full name" required />
        </div>
        <div class="form-group">
          <label for="dateOfBirth">Date of Birth:</label>
          <input type="date" id="dateOfBirth" name="dateOfBirth" required />
        </div>
        <div class="form-group">
          <label for="placeOfBirth">Place of Birth:</label>
          <input type="text" id="placeOfBirth" name="placeOfBirth" placeholder="Enter place of birth" required />
        </div>
        <div class="form-group">
          <label for="parentNames">Parent's Full Names:</label>
          <input type="text" id="parentNames" name="parentNames" placeholder="Enter parent's full names" required />
        </div>
      `;
    } else if (certificateType === "death") {
      dynamicFields.innerHTML = `
        <div class="form-group">
          <label for="deceasedName">Deceased's Full Name:</label>
          <input type="text" id="deceasedName" name="deceasedName" placeholder="Enter deceased's full name" required />
        </div>
        <div class="form-group">
          <label for="dateOfDeath">Date of Death:</label>
          <input type="date" id="dateOfDeath" name="dateOfDeath" required />
        </div>
        <div class="form-group">
          <label for="placeOfDeath">Place of Death:</label>
          <input type="text" id="placeOfDeath" name="placeOfDeath" placeholder="Enter place of death" required />
        </div>
        <div class="form-group">
          <label for="causeOfDeath">Cause of Death:</label>
          <input type="text" id="causeOfDeath" name="causeOfDeath" placeholder="Enter cause of death" />
        </div>
      `;
    } else if (certificateType === "marriage") {
      dynamicFields.innerHTML = `
        <div class="form-group">
          <label for="spouse1Name">Spouse 1 Full Name:</label>
          <input type="text" id="spouse1Name" name="spouse1Name" placeholder="Enter spouse 1 full name" required />
        </div>
        <div class="form-group">
          <label for="spouse2Name">Spouse 2 Full Name:</label>
          <input type="text" id="spouse2Name" name="spouse2Name" placeholder="Enter spouse 2 full name" required />
        </div>
        <div class="form-group">
          <label for="dateOfMarriage">Date of Marriage:</label>
          <input type="date" id="dateOfMarriage" name="dateOfMarriage" required />
        </div>
        <div class="form-group">
          <label for="placeOfMarriage">Place of Marriage:</label>
          <input type="text" id="placeOfMarriage" name="placeOfMarriage" placeholder="Enter place of marriage" required />
        </div>
      `;
    }
  });

// Form submission
document
  .getElementById("applicationForm")
  .addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent actual form submission for demonstration

    alert("Application submitted successfully!");
  });
