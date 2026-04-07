<?php
session_start();
include '../config/koneksi.php';

// proteksi siswa
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'siswa') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['token'])) {
    die("Token tidak ditemukan");
}

$token = $_GET['token'];
$siswa_id = $_SESSION['id'];
$pesan = "";

// ambil sesi
$sesi = mysqli_query($conn, "SELECT * FROM absensi_sesi WHERE token='$token'");

if (mysqli_num_rows($sesi) == 1) {
    $data = mysqli_fetch_assoc($sesi);
    $sesi_id = $data['id'];

    date_default_timezone_set('Asia/Jakarta');
    $sekarang = date("H:i:s");

    // validasi waktu
    if ($sekarang < $data['jam_mulai'] || $sekarang > $data['jam_selesai']) {
        $pesan = "Absensi ditutup!";
    } else {

        // cek sudah absen
        $cek = mysqli_query($conn, "SELECT * FROM absensi 
            WHERE siswa_id='$siswa_id' AND sesi_id='$sesi_id'");

        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Kamu sudah absen!";
        } else {

            $status = ($sekarang > $data['jam_mulai']) ? 'telat' : 'hadir';

            mysqli_query($conn, "INSERT INTO absensi 
                (siswa_id, sesi_id, status) 
                VALUES ('$siswa_id','$sesi_id','$status')
            ");

            $pesan = "Absensi berhasil!";
        }
    }

} else {
    $pesan = "Token tidak valid!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scan Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 text-center">
    <h3><?= $pesan ?></h3>
    <a href="dashboard.php" class="btn btn-primary mt-3">Kembali</a>
</div>

</body>
</html>