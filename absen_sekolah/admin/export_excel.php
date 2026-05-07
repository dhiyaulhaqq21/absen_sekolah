<?php
include '../config/koneksi.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap_absensi.xls");

$tanggal = $_GET['tanggal'] ?? '';

$query = "
SELECT s.nama, s.kelas, se.tanggal, a.waktu_absen, a.status
FROM absensi a
JOIN siswa s ON a.siswa_id = s.id
JOIN absensi_sesi se ON a.sesi_id = se.id
";

if ($tanggal != '') {
    $query .= " WHERE se.tanggal = '$tanggal'";
}

$data = mysqli_query($conn, $query);
?>

<h3>Rekap Absensi</h3>

<table border="1">
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
