<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ginjo Subcity Map - Jimma, Ethiopia</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <style>
    #map {
      height: 500px;
      width: 100%;
      border-radius: 10px;
    }

    .map-container {
      margin-top: 50px;
    }

    .map-header {
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <div class="container map-container">
    <div class="map-header">
      <h2>Map of Ginjo Subcity, Jimma, Ethiopia</h2>
      <p>Explore the Ginjo area using the interactive map below.</p>
    </div>
    <div id="map"></div>
  </div>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
    // Initialize the map
    const map = L.map('map').setView([7.6700, 36.8300], 15); // Approx. coordinates for Ginjo, Jimma

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Optional: Add marker
    L.marker([7.6700, 36.8300]).addTo(map)
      .bindPopup('<b>Ginjo Subcity</b><br>Jimma, Ethiopia')
      .openPopup();
  </script>

</body>
</html>
