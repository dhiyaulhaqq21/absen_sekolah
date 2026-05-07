<?php

// fungsi generate token
function generateToken($length = 6) {
    return strtoupper(bin2hex(random_bytes($length/2)));
}

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $token = generateToken();
    $admin_id = $_SESSION['id'];

    mysqli_query($conn, "INSERT INTO absensi_sesi 
        (tanggal, jam_mulai, jam_selesai, token, dibuat_oleh) 
        VALUES ('$tanggal','$jam_mulai','$jam_selesai','$token','$admin_id')
    ");

    echo "<script>alert('Sesi berhasil dibuat! Token: $token');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Buat Sesi Absensi</h3>

    <form method="POST">
        <input type="date" name="tanggal" class="form-control mb-2" required>
        <input type="time" name="jam_mulai" class="form-control mb-2" required>
        <input type="time" name="jam_selesai" class="form-control mb-3" required>

        <button name="simpan" class="btn btn-primary">Buat Absensi</button>
    </form>
</div>

</body>
</html>
