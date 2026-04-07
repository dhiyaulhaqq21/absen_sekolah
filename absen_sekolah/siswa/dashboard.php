<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'siswa') {
    header("Location: ../auth/login.php");
    exit;
}

// ambil riwayat absensi siswa
$siswa_id = $_SESSION['id'];

$data = mysqli_query($conn, "
    SELECT a.*, s.tanggal 
    FROM absensi a
    JOIN absensi_sesi s ON a.sesi_id = s.id
    WHERE a.siswa_id = '$siswa_id'
    ORDER BY a.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">Dashboard Siswa</span>
        <a href="../auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">

    <h4>Halo, <?= $_SESSION['nama']; ?></h4>

    <!-- Tombol Absen -->
    <div class="mt-3">
        <a href="absen.php" class="btn btn-success">Absen Sekarang</a>
    </div>

    <!-- Riwayat -->
    <div class="mt-4">
        <h5>Riwayat Absensi</h5>

        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>

            <?php $no=1; while($d = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['tanggal'] ?></td>
                <td><?= $d['waktu_absen'] ?></td>
                <td>
                    <?php if($d['status']=='hadir'){ ?>
                        <span class="badge bg-success">Hadir</span>
                    <?php } else { ?>
                        <span class="badge bg-warning">Telat</span>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>

        </table>
    </div>

</div>

</body>
</html>