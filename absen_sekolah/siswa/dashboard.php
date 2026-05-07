<?php

$siswa_id = $_SESSION['id'];

// riwayat absensi
$data = mysqli_query($conn, "
    SELECT 
        a.*,
        s.tanggal
    FROM absensi a
    JOIN absensi_sesi s 
        ON a.sesi_id = s.id
    WHERE a.siswa_id = '$siswa_id'
    ORDER BY a.id DESC
");
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.dashboard-card {
    border-radius: 15px;
}

.table thead {
    background: #0d6efd;
    color: white;
}

.badge {
    padding: 7px 10px;
    border-radius: 8px;
}
</style>

<h3 class="mb-4">
    Halo, <?= $_SESSION['nama']; ?> 👋
</h3>

<div class="mb-4">

    <a href="index.php?page=absen"
       class="btn btn-success">
        Absen Sekarang
    </a>

</div>

<div class="card shadow border-0 dashboard-card">

    <div class="card-body">

        <h5 class="mb-4">
            Riwayat Absensi
        </h5>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
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

                        <td><?= $d['tanggal'] ?></td>

                        <td>
                            <?= $d['waktu_absen'] ?: '-' ?>
                        </td>

                        <td>

                            <?php 

                            if ($d['status'] == 'hadir') {

                                echo "
                                <span class='badge bg-success'>
                                    Hadir
                                </span>";

                            } elseif ($d['status'] == 'telat') {

                                $telat = $d['keterlambatan'] ?? 0;

                                echo "
                                <span class='badge bg-warning text-dark'>
                                    Telat {$telat} menit
                                </span>";

                            } else {

                                echo "
                                <span class='badge bg-danger'>
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