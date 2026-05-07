<?php

$siswa_id = $_SESSION['id'];
$pesan = "";
$status_alert = "info";

if (isset($_POST['absen'])) {

    $token = mysqli_real_escape_string($conn, $_POST['token']);

    // cek token
    $sesi = mysqli_query($conn, "
        SELECT * FROM absensi_sesi 
        WHERE token='$token'
    ");

    if (mysqli_num_rows($sesi) == 1) {

        $data = mysqli_fetch_assoc($sesi);
        $sesi_id = $data['id'];

        date_default_timezone_set('Asia/Jakarta');
        $sekarang = date("H:i:s");

        // validasi waktu
        if (
            $sekarang < $data['jam_mulai'] ||
            $sekarang > $data['jam_selesai']
        ) {

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

                // toleransi 15 menit
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

                // simpan absensi
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
}
?>

<div class="container-fluid">

    <div class="col-md-6 mx-auto">

        <div class="card shadow border-0">

            <div class="card-body">

                <h3 class="mb-4">
                    Absensi Siswa
                </h3>

                <?php if ($pesan != "") { ?>

                    <div class="alert alert-<?= $status_alert ?>">
                        <?= $pesan ?>
                    </div>

                <?php } ?>

                <form method="POST">

                    <label class="mb-2">
                        Token Absensi
                    </label>

                    <input 
                        type="text"
                        name="token"
                        class="form-control mb-3"
                        placeholder="Masukkan token..."
                        required
                    >

                    <div class="d-flex gap-2">

                        <a href="siswa/scan_kamera.php"
                           class="btn btn-success">
                            📷 Scan QR
                        </a>

                        <button name="absen"
                                class="btn btn-primary">
                            Absen
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>