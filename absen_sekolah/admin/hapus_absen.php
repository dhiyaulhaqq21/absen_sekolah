<?php

if ($_SESSION['level'] != 'admin') {
    header("Location:index.php");
    exit;
}

$id = $_GET['id'] ?? '';

if ($id != '') {

    mysqli_query($conn,
        "DELETE FROM absensi_sesi WHERE id='$id'"
    );
}

header("Location:index.php?page=data_absen");
exit;