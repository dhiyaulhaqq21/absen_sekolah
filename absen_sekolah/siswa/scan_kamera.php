<?php
session_start();

// proteksi siswa
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'siswa') {
    header("Location: ./auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Kamera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-light">

<div class="container mt-5 text-center">

    <h4 class="mb-3">Scan QR Absensi</h4>

    <div id="reader" style="width:300px; margin:auto;"></div>

    <div id="hasil" class="mt-3"></div>

    <a href="../index.php?page=dashboard" class="btn btn-secondary mt-3">
        Kembali
    </a>

</div>

<script>
function onScanSuccess(decodedText) {
    document.getElementById("hasil").innerHTML =
        "<div class='alert alert-success'>QR terdeteksi...</div>";

    // redirect ke scan.php
    window.location.href = decodedText;
}

function onScanError(error) {
    // biarkan saja (tidak perlu ditampilkan)
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
);

html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>

</body>
</html>