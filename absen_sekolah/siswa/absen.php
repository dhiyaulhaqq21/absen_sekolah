<?php
session_start();
include '../config/koneksi.php';

// proteksi siswa
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'siswa') {
    header("Location: ../auth/login.php");
    exit;
}

$siswa_id = $_SESSION['id'];
$pesan = "";

if (isset($_POST['absen'])) {
    $token = $_POST['token'];

    // cek sesi berdasarkan token
    $sesi = mysqli_query($conn, "SELECT * FROM absensi_sesi WHERE token='$token'");
    
    if (mysqli_num_rows($sesi) == 1) {
        $data = mysqli_fetch_assoc($sesi);
        $sesi_id = $data['id'];

        // cek waktu
        date_default_timezone_set('Asia/Jakarta');
        $sekarang = date("H:i:s");

        if ($sekarang < $data['jam_mulai'] || $sekarang > $data['jam_selesai']) {
            $pesan = "Absensi ditutup!";
        } else {

            // cek sudah absen atau belum
            $cek = mysqli_query($conn, "SELECT * FROM absensi 
                WHERE siswa_id='$siswa_id' AND sesi_id='$sesi_id'");

            if (mysqli_num_rows($cek) > 0) {
                $pesan = "Kamu sudah absen!";
            } else {

                // tentukan status (hadir / telat)
                $status = ($sekarang > $data['jam_mulai']) ? 'telat' : 'hadir';

                // simpan
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
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Absensi Siswa</h3>

    <?php if ($pesan != "") { ?>
        <div class="alert alert-info"><?= $pesan ?></div>
    <?php } ?>

    <form method="POST">
        <input type="text" name="token" class="form-control mb-3" placeholder="Masukkan Token" required>
        <button name="absen" class="btn btn-success">Absen</button>
    </form>
</div>

</body>
</html>