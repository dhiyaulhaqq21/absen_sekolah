<?php
$data = mysqli_query($conn, "SELECT * FROM staf");
?>

<h4 class="mb-3">Data Staf</h4>

<div class="card shadow-sm">
    <div class="card-body">

        <a href="index.php?page=staf_form" class="btn btn-primary mb-3">
            + Tambah Staf
        </a>

        <table class="table table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
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
                        <a href="index.php?page=staf_form&id=<?= $d['id'] ?>" 
                           class="btn btn-warning btn-sm">Edit</a>

                        <a href="admin/staf_hapus.php?id=<?= $d['id'] ?>" 
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