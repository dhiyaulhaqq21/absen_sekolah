<?php
include './lib/phpqrcode/qrlib.php';


$data = mysqli_query($conn, "SELECT * FROM absensi_sesi ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Data Absensi</span>
    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Sesi Absensi</h4>
        <a href="index.php?page=buat_absen" class="btn btn-primary">+ Buat Absensi</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table id="tabelAbsensi" class="table table-hover align-middle text-center">                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Token</th>
                            <th>QR Code</th>
                            <th>Aksi</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no=1; while($d = mysqli_fetch_assoc($data)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>

                            <td><?= $d['tanggal'] ?></td>

                            <td>
                                <span class="badge bg-secondary">
                                    <?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?>
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-primary fs-6">
                                    <?= $d['token'] ?>
                                </span>
                            </td>

                            <td>
                                <?php
                                $link = "http://localhost/absensi/siswa/scan.php?token=" . $d['token'];

                                $file = "./assets/qr/" . $d['token'] . ".png";

                                // jika file belum ada, buat QR
                                if (!file_exists($file)) {
                                    QRcode::png($link, $file, QR_ECLEVEL_L, 5);
                                }
                                ?>

                                <img src="./assets/qr/<?= $d['token'] ?>.png" width="100">                          </td>

                            <td>
                                <a href="./assets/qr/<?= $d['token'] ?>.png" 
                                   download 
                                   class="btn btn-success btn-sm">
                                   Download
                                </a>
                                <a href="index.php?page=hapus_absen&id=<?= $d['id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">

                                Hapus
                                </a>
                            </td>
                            <td>
                                <?php
                                date_default_timezone_set('Asia/Jakarta');
                                $now = date("H:i:s");

                                if ($now < $d['jam_mulai']) {
                                    echo '<span class="badge bg-secondary">Belum Mulai</span>';
                                } elseif ($now >= $d['jam_mulai'] && $now <= $d['jam_selesai']) {
                                    echo '<span class="badge bg-success">Aktif</span>';
                                } else {
                                    echo '<span class="badge bg-danger">Selesai</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#tabelAbsensi').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        ordering: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "Sebelumnya",
                next: "Berikutnya"
            }
        }
    });
});
</script>
</body>
</html>
