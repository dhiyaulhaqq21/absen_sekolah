<?php
require_once 'config/koneksi.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // cek admin
    $queryAdmin = mysqli_query($conn,
        "SELECT * FROM staf WHERE username='$username'"
    );

    if (mysqli_num_rows($queryAdmin) == 1) {

        $data = mysqli_fetch_assoc($queryAdmin);

        if (password_verify($password, $data['password'])) {

            $_SESSION['id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = 'admin';

            header("Location: index.php");
            exit;
        }
    }

    // cek siswa
    $querySiswa = mysqli_query($conn,
        "SELECT * FROM siswa WHERE username='$username'"
    );

    if (mysqli_num_rows($querySiswa) == 1) {

        $data = mysqli_fetch_assoc($querySiswa);

        if (password_verify($password, $data['password'])) {

            $_SESSION['id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = 'siswa';

            header("Location: index.php");
            exit;
        }
    }

    $error = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#667eea,#764ba2);
        }

        .login-box{
            width:400px;
            background:white;
            padding:35px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
            animation:fade 0.5s ease;
        }

        .login-box h3{
            font-weight:bold;
        }

        .form-control{
            height:45px;
            border-radius:10px;
        }

        .btn-login{
            background:#667eea;
            color:white;
            border:none;
            height:45px;
            border-radius:10px;
            transition:0.3s;
        }

        .btn-login:hover{
            background:#5a67d8;
        }

        @keyframes fade{
            from{
                opacity:0;
                transform:translateY(20px);
            }

            to{
                opacity:1;
                transform:translateY(0);
            }
        }

    </style>
</head>
<body>

<div class="login-box">

    <div class="text-center mb-4">
        <h3>📘 Sistem Absensi</h3>
        <small class="text-muted">
            Silakan login
        </small>
    </div>

    <?php if(isset($error)) { ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label>Username</label>
            <input type="text"
                   name="username"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   required>
        </div>

        <button name="login"
                class="btn btn-login w-100">

            Login

        </button>

    </form>

</div>

</body>
</html>