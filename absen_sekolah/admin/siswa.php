<?php
$data = mysqli_query($conn, "SELECT * FROM siswa");
?>

<h4 class="mb-3">Data Siswa</h4>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <a href="index.php?page=siswa_form" class="btn btn-primary">
                + Tambah Siswa
            </a>
        </div>

        <div class="table-responsive">
            <table id="tabelSiswa" class="table table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no=1; while($d = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>

                        <td class="text-start"><?= $d['nama'] ?></td>

                        <td>
                            <span class="badge bg-secondary">
                                <?= $d['username'] ?>
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-info text-dark">
                                <?= $d['kelas'] ?>
                            </span>
                        </td>

                        <td>
                            <a href="index.php?page=siswa_form&id=<?= $d['id'] ?>" 
                               class="btn btn-warning btn-sm">Edit</a>

                            <a href="admin/siswa_hapus.php?id=<?= $d['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus data ini?')">
                               Hapus
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<script>
$(document).ready(function() {
    $('#tabelSiswa').DataTable();
});
</script>