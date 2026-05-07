<?php
session_start();
include '../config/koneksi.php';

// proteksi siswa
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'siswa') {
    header("Location: ../index.php");
    // exit;
}

// cek token
if (!isset($_GET['token'])) {
    die("Token tidak ditemukan");
}

$token = $_GET['token'];
$siswa_id = $_SESSION['id'];
$pesan = "";
$status_alert = "secondary";

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
        $status_alert = "danger";

    } else {

        // cek sudah absen
        $cek = mysqli_query($conn, "
            SELECT * FROM absensi 
            WHERE siswa_id='$siswa_id' 
            AND sesi_id='$sesi_id'
        ");

        if (mysqli_num_rows($cek) > 0) {

            $pesan = "Kamu sudah absen!";
            $status_alert = "warning";

        } else {

            // hitung keterlambatan
            $jam_mulai = strtotime($data['jam_mulai']);
            $jam_sekarang = strtotime($sekarang);

            $selisih = ($jam_sekarang - $jam_mulai) / 60;

            if ($selisih <= 15) {
                $status = 'hadir';
                $keterlambatan = 0;
                $pesan = "Absensi berhasil (tepat waktu)";
                $status_alert = "success";
            } else {
                $status = 'telat';
                $keterlambatan = floor($selisih);
                $pesan = "Absensi berhasil (telat $keterlambatan menit)";
                $status_alert = "warning";
            }

            // simpan ke database
            mysqli_query($conn, "INSERT INTO absensi 
                (siswa_id, sesi_id, status, keterlambatan) 
                VALUES (
                    '$siswa_id',
                    '$sesi_id',
                    '$status',
                    '$keterlambatan'
                )
            ");
        }
    }

} else {
    $pesan = "Token tidak valid!";
    $status_alert = "danger";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scan Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="col-md-6 mx-auto">

        <div class="card shadow-sm text-center">
            <div class="card-body">

                <h4 class="mb-3">Hasil Absensi</h4>

                <div class="alert alert-<?= $status_alert ?>">
                    <?= $pesan ?>
                </div>

                <a href="../index.php?page=dashboard" class="btn btn-primary">
                    Kembali ke Dashboard
                </a>

            </div>
        </div>

    </div>

</div>

</body>
</html>