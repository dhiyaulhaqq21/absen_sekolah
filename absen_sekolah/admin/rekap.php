<?php

$tanggal = $_GET['tanggal'] ?? '';

// AUTO ALFA
$sesi = mysqli_query($conn, "SELECT * FROM absensi_sesi");

date_default_timezone_set('Asia/Jakarta');
$sekarang = date("H:i:s");

$sesi = mysqli_query($conn, "
    SELECT * FROM absensi_sesi
    WHERE jam_selesai < '$sekarang'
");

while ($s = mysqli_fetch_assoc($sesi)) {

    $sesi_id = $s['id'];

    $siswa = mysqli_query($conn, "SELECT * FROM siswa");

    while ($sw = mysqli_fetch_assoc($siswa)) {

        $siswa_id = $sw['id'];

        $cek = mysqli_query($conn, "
            SELECT * FROM absensi
            WHERE siswa_id='$siswa_id'
            AND sesi_id='$sesi_id'
        ");

        if (mysqli_num_rows($cek) == 0) {

            mysqli_query($conn, "
                INSERT INTO absensi
                (
                    siswa_id,
                    sesi_id,
                    status,
                    keterlambatan
                )
                VALUES
                (
                    '$siswa_id',
                    '$sesi_id',
                    'alfa',
                    0
                )
            ");
        }
    }
}

// QUERY
$query = "
SELECT 
    s.nama,
    s.kelas,
    a.waktu_absen,
    a.status,
    a.keterlambatan,
    se.tanggal
FROM absensi a
JOIN siswa s ON a.siswa_id = s.id
JOIN absensi_sesi se ON a.sesi_id = se.id
";

if ($tanggal != '') {
    $query .= " WHERE se.tanggal = '$tanggal'";
}

$query .= " ORDER BY se.tanggal DESC";

$data = mysqli_query($conn, $query);
?>

<style>
.rekap-card {
    border-radius: 15px;
}

.table thead {
    background: #0d6efd;
    color: white;
}

.badge {
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
}
</style>

<div class="container-fluid">

    <div class="card shadow border-0 rekap-card">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h3 class="mb-0">Rekap Absensi</h3>
                    <small class="text-muted">
                        Data kehadiran siswa
                    </small>
                </div>

                <a href="admin/export_excel.php?tanggal=<?= $tanggal ?>" 
                   class="btn btn-success">
                    Export Excel
                </a>

            </div>

            <!-- FILTER -->
            <form method="GET" class="row g-2 mb-4">

                <input type="hidden" name="page" value="rekap">

                <div class="col-md-3">
                    <input type="date" 
                           name="tanggal" 
                           class="form-control"
                           value="<?= $tanggal ?>">
                </div>

                <div class="col-md-3">

                    <button class="btn btn-primary">
                        Filter
                    </button>

                    <a href="index.php?page=rekap" 
                       class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </form>

            <!-- TABEL -->
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Waktu Absen</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php 
                    $no = 1;

                    while($d = mysqli_fetch_assoc($data)) { 
                    ?>

                        <tr>

                            <td><?= $no++ ?></td>

                            <td>
                                <strong><?= $d['nama'] ?></strong>
                            </td>

                            <td><?= $d['kelas'] ?></td>

                            <td><?= $d['tanggal'] ?></td>

                            <td>
                                <?= $d['waktu_absen'] ?: '-' ?>
                            </td>

                            <td>

                                <?php 
                                if ($d['status'] == 'hadir') {

                                    echo "<span class='badge bg-success'>
                                            Hadir
                                          </span>";

                                } elseif ($d['status'] == 'telat') {

                                    echo "<span class='badge bg-warning text-dark'>
                                            Telat {$d['keterlambatan']} menit
                                          </span>";

                                } else {

                                    echo "<span class='badge bg-danger'>
                                            Alfa
                                          </span>";
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