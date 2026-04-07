<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// statistik
$total_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa"));
$total_sesi  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM absensi_sesi"));
$total_absen = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM absensi"));

$hadir = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM absensi WHERE status='hadir'"));
$telat = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM absensi WHERE status='telat'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
            background: #343a40;
            color: white;
            position: fixed;
            width: 220px;
        }
        .sidebar a {
            color: #ccc;
            display: block;
            padding: 12px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
            color: white;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .card {
            border-radius: 12px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center py-3">Admin</h4>

    <a href="dashboard.php">Dashboard</a>
    <a href="buat_absen.php">Buat Absensi</a>
    <a href="data_absen.php">Data Absensi</a>
    <a href="rekap.php">Rekap</a>
    <a href="../auth/logout.php" class="text-danger">Logout</a>
</div>

<!-- Content -->
<div class="content">

    <h4>Halo, <?= $_SESSION['nama']; ?></h4>

    <!-- Statistik -->
    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card shadow p-3 bg-primary text-white">
                <h6>Total Siswa</h6>
                <h2><?= $total_siswa ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-3 bg-success text-white">
                <h6>Total Sesi</h6>
                <h2><?= $total_sesi ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-3 bg-warning text-white">
                <h6>Total Absensi</h6>
                <h2><?= $total_absen ?></h2>
            </div>
        </div>

    </div>

    <!-- Grafik -->
    <div class="card mt-4 shadow">
        <div class="card-body">
            <h5>Statistik Kehadiran</h5>
            <canvas id="chartAbsensi"></canvas>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="mt-4">
        <h5>Menu Cepat</h5>

        <a href="buat_absen.php" class="btn btn-primary">+ Buat Absensi</a>
        <a href="data_absen.php" class="btn btn-success">Lihat Data</a>
        <a href="rekap.php" class="btn btn-warning">Rekap</a>
    </div>

</div>

<script>
const ctx = document.getElementById('chartAbsensi');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Hadir', 'Telat'],
        datasets: [{
            data: [<?= $hadir ?>, <?= $telat ?>]
        }]
    }
});
</script>

</body>
</html>