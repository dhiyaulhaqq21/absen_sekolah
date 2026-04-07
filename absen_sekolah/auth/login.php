<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // cek ke tabel staf (admin)
    $queryAdmin = mysqli_query($conn, "SELECT * FROM staf WHERE username='$username'");
    if (mysqli_num_rows($queryAdmin) === 1) {
        $data = mysqli_fetch_assoc($queryAdmin);

        if (password_verify($password, $data['password'])) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = 'admin';

            header("Location: ../admin/dashboard.php");
            exit;
        }
    }

    // cek ke tabel siswa
    $querySiswa = mysqli_query($conn, "SELECT * FROM siswa WHERE username='$username'");
    if (mysqli_num_rows($querySiswa) === 1) {
        $data = mysqli_fetch_assoc($querySiswa);

        if (password_verify($password, $data['password'])) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = 'siswa';

            header("Location: ../siswa/dashboard.php");
            exit;
        }
    }

    echo "<script>alert('Login gagal!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-4 mx-auto">
        <div class="card p-4 shadow">
            <h4 class="text-center">Login</h4>
            <form method="POST">
                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                <button name="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>