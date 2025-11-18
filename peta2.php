<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "sumukpol";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}


$hotspot = [];
$query = mysqli_query($conn, "SELECT * FROM tabel_hotspot");

while ($row = mysqli_fetch_assoc($query)) {
    $hotspot[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Peta Hotspot - SUMUKPOL</title>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    body { margin: 0; padding: 0; }
    #map { height: 100vh; width: 100%; }
</style>
</head>

<body>

<!-- PETA -->
<div id="map"></div>

<script>

var map = L.map('map').setView([-1.5, 114], 5);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 18
}).addTo(map);

// AMBIL DATA HOTSPOT DARI PHP
var hotspot = <?php echo json_encode($hotspot); ?>;

// TAMPILKAN TITIK HOTSPOT
hotspot.forEach(h => {
    L.circleMarker([h.latitude, h.longitude], {
        radius: 8,
        color: "red",
        fillColor: "orange",
        fillOpacity: 0.8
    })
    .addTo(map)
    .bindPopup(`
        <b>${h.sumber}</b><br>
        ${h.desa}, ${h.kota}, ${h.provinsi}<br>
        Jumlah Kebakaran: <b>${h.jumlah_kebakaran}</b><br>
        Tanggal: ${h.tanggal}
    `);
});
</script>

</body>
</html>
