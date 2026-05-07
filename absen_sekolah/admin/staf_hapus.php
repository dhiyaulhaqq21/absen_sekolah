<?php
include '../config/koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM staf WHERE id='$id'");

header("Location: ../index.php?page=staf");