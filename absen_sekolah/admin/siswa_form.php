<?php
$id = $_GET['id'] ?? '';
$edit = false;

if ($id != '') {
    $edit = true;
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM siswa WHERE id='$id'"));
}

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);

    if ($edit) {

        mysqli_query($conn, "
            UPDATE siswa SET 
            nama='$nama',
            username='$username',
            kelas='$kelas',
            nis='$nis'
            WHERE id='$id'
        ");

    } else {

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        mysqli_query($conn, "
            INSERT INTO siswa 
            (nama, username, password, kelas, nis)
            VALUES 
            ('$nama','$username','$password','$kelas','$nis')
        ");
    }

    echo "
    <script>
        alert('Data berhasil disimpan');
        location='index.php?page=siswa';
    </script>
    ";
}
?>

<div class="col-md-6">
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3"><?= $edit ? 'Edit' : 'Tambah' ?> Siswa</h5>

            <form method="POST">

                <label>Nama</label>
                <input type="text" name="nama" class="form-control mb-3"
                       value="<?= $data['nama'] ?? '' ?>" required>

                <label>Username</label>
                <input type="text" name="username" class="form-control mb-3"
                       value="<?= $data['username'] ?? '' ?>" required>

                <label>NIS</label>
                <input type="text" name="nis" class="form-control mb-3"
                       value="<?= $data['nis'] ?? '' ?>" required>

                <?php if (!$edit) { ?>
                <label>Password</label>
                <input type="password" name="password" class="form-control mb-3" required>
                <?php } ?>

                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control mb-3"
                       value="<?= $data['kelas'] ?? '' ?>" required>

                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan
                </button>
                <a href="index.php?page=siswa" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>