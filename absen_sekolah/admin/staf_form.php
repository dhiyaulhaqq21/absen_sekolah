<?php
$id = $_GET['id'] ?? '';
$edit = false;

if ($id != '') {
    $edit = true;
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM staf WHERE id='$id'"));
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];

    if ($edit) {
        mysqli_query($conn, "UPDATE staf SET 
            nama='$nama',
            username='$username'
            WHERE id='$id'
        ");
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        mysqli_query($conn, "INSERT INTO staf (nama, username, password)
            VALUES ('$nama','$username','$password')");
    }

    echo "<script>location='index.php?page=staf'</script>";
}
?>

<div class="col-md-6">
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3"><?= $edit ? 'Edit' : 'Tambah' ?> Staf</h5>

            <form method="POST">

                <label>Nama</label>
                <input type="text" name="nama" class="form-control mb-3"
                       value="<?= $data['nama'] ?? '' ?>" required>

                <label>Username</label>
                <input type="text" name="username" class="form-control mb-3"
                       value="<?= $data['username'] ?? '' ?>" required>

                <?php if (!$edit) { ?>
                <label>Password</label>
                <input type="password" name="password" class="form-control mb-3" required>
                <?php } ?>

                <button class="btn btn-success">Simpan</button>
                <a href="index.php?page=staf" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>
</div>