<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$tanggal = $_GET['tanggal'] ?? '';

$query = "
SELECT s.nama, s.kelas, a.waktu_absen, a.status, se.tanggal
FROM absensi a
JOIN siswa s ON a.siswa_id = s.id
JOIN absensi_sesi se ON a.sesi_id = se.id
";

if ($tanggal != '') {
    $query .= " WHERE se.tanggal = '$tanggal'";
}

$data = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rekap Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h3>Rekap Absensi</h3>

    <!-- Filter -->
    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <input type="date" name="tanggal" class="form-control">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary">Filter</button>
            <a href="rekap.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Export -->
    <a href="export_excel.php?tanggal=<?= $tanggal ?>" class="btn btn-success mb-3">
        Export Excel
    </a>

    <!-- Tabel -->
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Status</th>
        </tr>

        <?php $no=1; while($d = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['nama'] ?></td>
            <td><?= $d['kelas'] ?></td>
            <td><?= $d['tanggal'] ?></td>
            <td><?= $d['waktu_absen'] ?></td>
            <td><?= $d['status'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>