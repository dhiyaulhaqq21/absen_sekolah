<?php
session_start();
require_once 'config/koneksi.php';

// jika belum login
if (!isset($_SESSION['level'])) {
    include 'auth/login.php';
    exit;
}

// routing halaman
$page = $_GET['page'] ?? 'dashboard';

// folder berdasarkan level
$folder = $_SESSION['level'];
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Sistem Absensi</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7fb;
            overflow-x:hidden;
            font-family:'Segoe UI',sans-serif;
        }

        /* SIDEBAR */
        .sidebar{
            position:fixed;
            top:0;
            left:0;
            width:240px;
            height:100vh;
            background:linear-gradient(180deg,#4f6df5,#3557e0);
            color:white;
            transition:0.3s;
            z-index:1000;
            padding-top:20px;
        }

        .sidebar.hide{
            left:-240px;
        }

        .sidebar h3{
            text-align:center;
            margin-bottom:30px;
            font-weight:bold;
        }

        .sidebar a{
            display:block;
            padding:14px 25px;
            color:white;
            text-decoration:none;
            transition:0.2s;
            font-size:16px;
        }

        .sidebar a:hover{
            background:rgba(255,255,255,0.15);
            padding-left:30px;
        }

        /* CONTENT */
        .content{
            margin-left:240px;
            padding:25px;
            transition:0.3s;
            min-height:100vh;
        }

        .content.full{
            margin-left:0;
        }

        /* TOGGLE BUTTON */
        .toggle-btn{
            background:#4f6df5;
            border:none;
            color:white;
            width:45px;
            height:45px;
            border-radius:12px;
            font-size:22px;
            margin-bottom:20px;
            box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }

        /* FOOTER */
        .footer{
            background:linear-gradient(90deg,#3557e0,#4f6df5);
            color:white;
            padding:18px 30px;
            margin-left:240px;
            transition:0.3s;
        }

        .footer.full{
            margin-left:0;
        }

        .footer-content{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:10px;
        }

        .footer-title{
            font-size:20px;
            font-weight:bold;
        }

        .footer-sub{
            font-size:14px;
            opacity:0.9;
        }

        /* RESPONSIVE */
        @media(max-width:768px){

            .sidebar{
                left:-240px;
            }

            .sidebar.show{
                left:0;
            }

            .content{
                margin-left:0;
            }

            .footer{
                margin-left:0;
            }
        }
    </style>
    </head>
    <body id="body">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <h4>Sistem Absensi</h4>

            <?php if ($_SESSION['level'] == 'admin') { ?>

                <a href="index.php?page=dashboard">🏠 Dashboard</a>
                <a href="index.php?page=buat_absen">📝 Buat Absensi</a>
                <a href="index.php?page=data_absen">📋 Data Absensi</a>
                <a href="index.php?page=rekap">📊 Rekap</a>
                <a href="index.php?page=siswa">👨‍🎓 Data Siswa</a>
                <a href="index.php?page=staf">👨‍💼 Data Staf</a>

            <?php } ?>

            <?php if ($_SESSION['level'] == 'siswa') { ?>

                <a href="index.php?page=dashboard">🏠 Dashboard</a>
                <a href="index.php?page=absen">✅ Absen</a>

            <?php } ?>

            <a href="auth/logout.php" class="logout">🚪 Logout</a>

        </div>

        <!-- CONTENT -->
        <div class="content" id="content">

            <!-- TOPBAR -->
            <div class="topbar mb-4">

                <button class="toggle-btn" onclick="toggleSidebar()">
                    ☰
                </button>

                <h5 class="m-0">
                    Dashboard
                </h5>

            </div>

        <?php

        $file = "$folder/$page.php";

        if (file_exists($file)) {
            include $file;
        } else {
            echo "
            <div class='alert alert-danger'>
                Halaman tidak ditemukan!
            </div>
            ";
        }

        ?>

        </div>
        <!-- FOOTER -->
        <footer class="footer" id="footer">
            <div class="footer-content">

                <div>
                    <div class="footer-title">Sistem Absensi</div>
                    <div class="footer-sub">
                        Website absensi siswa berbasis QR Code
                    </div>
                </div>

                <div class="footer-sub">
                    © <?= date('Y') ?> Sistem Absensi
                </div>

            </div>
        </footer>
        <script>
        function toggleSidebar(){

            document.querySelector('.sidebar').classList.toggle('hide');

            document.getElementById('content').classList.toggle('full');

            document.getElementById('footer').classList.toggle('full');
        }
        </script>
    </body>
</html>