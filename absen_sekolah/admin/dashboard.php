<?php

$total_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa"));
$total_sesi  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM absensi_sesi"));
$total_absen = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM absensi"));

$hadir = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM absensi WHERE status='hadir'"));
$telat = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM absensi WHERE status='telat'"));
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.dashboard-card {
    border-radius: 15px;
    transition: 0.3s;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

.chart-container {
    width: 100%;
    max-width: 400px;
    margin: auto;
}
</style>

<h2 class="mb-4">
    Halo, <?= $_SESSION['nama']; ?> 👋
</h2>

<div class="row">

    <div class="col-md-4 mb-3">
        <div class="card dashboard-card shadow border-0 bg-primary text-white p-4">
            <h6>Total Siswa</h6>
            <h1><?= $total_siswa ?></h1>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card dashboard-card shadow border-0 bg-success text-white p-4">
            <h6>Total Sesi</h6>
            <h1><?= $total_sesi ?></h1>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card dashboard-card shadow border-0 bg-warning text-white p-4">
            <h6>Total Absensi</h6>
            <h1><?= $total_absen ?></h1>
        </div>
    </div>

</div>

<div class="card shadow border-0 mt-4">
    <div class="card-body">

        <h5 class="mb-4">Statistik Kehadiran</h5>

        <div class="chart-container">
            <canvas id="chartAbsensi"></canvas>
        </div>

    </div>
</div>

<script>
const ctx = document.getElementById('chartAbsensi');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Hadir', 'Telat'],
        datasets: [{
            data: [<?= $hadir ?>, <?= $telat ?>],
            backgroundColor: [
                '#0d6efd',
                '#ffc107'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});
</script>
