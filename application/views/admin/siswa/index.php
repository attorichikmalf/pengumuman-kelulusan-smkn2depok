<!DOCTYPE html>
<html lang="id">
<head>
<?php if (!empty($sekolah['logo'])): ?>
    <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
<?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Data Siswa</title>
    <style>
        /* CSS untuk memastikan footer selalu di bawah dan navbar tidak menutupi konten */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: padding-top 0.3s ease-in-out;
        }
        .content {
            flex: 1;
            padding-top: 70px; /* Jarak default dari navbar */
        }
        .container {
            margin-top: 20px; /* Beri jarak agar tidak ketiban navbar */
        }
        .footer {
            padding-top: 10px;
            padding-bottom: 10px;
            min-height: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .footer .container {
            margin: 0 auto;
        }
    </style>
</head>

<body>


    <!-- Include Navbar -->
    <?php $this->load->view('admin/layout/navbar'); ?>

    <div class="container content">
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-primary" role="alert">
        <?= $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('info')): ?>
        <div class="alert alert-secondary" role="alert">
            <?= $this->session->flashdata('info'); ?>
        </div>
    <?php endif; ?>

    <!-- Tombol Tambah dan Import -->
    <div class="d-flex gap-2 mb-3">
        <a href="<?= base_url('admin/siswa/tambah'); ?>" class="btn btn-primary">Tambah Siswa</a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
            Import Excel
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
            Hapus Semua
        </button>
    </div>
    <!-- Modal Konfirmasi Hapus Semua -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus Semua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Untuk menghapus semua data siswa, ketik <strong>"YAKIN SAYA HAPUS"</strong> di bawah ini.</p>
                    <input type="text" id="confirmText" class="form-control" placeholder="Ketik di sini..." onkeyup="validateDelete()">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('admin/siswa/hapus_semua'); ?>" 
                    id="deleteButton" 
                    class="btn btn-danger disabled">
                        Hapus Semua
                    </a>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Form Pencarian -->
    <form action="<?= site_url('admin/siswa/index') ?>" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama atau NISN" 
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <br>

    <!-- Pilihan jumlah data per halaman -->
    <form method="get" action="<?= base_url('admin/siswa'); ?>" class="mb-3">
        <label for="limit">Tampilkan:</label>
        <select name="limit" id="limit" class="form-select w-auto d-inline" onchange="this.form.submit()">
            <option value="25" <?= (isset($_GET['limit']) && $_GET['limit'] == 25) ? 'selected' : ''; ?>>25</option>
            <option value="50" <?= (isset($_GET['limit']) && $_GET['limit'] == 50) ? 'selected' : ''; ?>>50</option>
            <option value="100" <?= (isset($_GET['limit']) && $_GET['limit'] == 100) ? 'selected' : ''; ?>>100</option>
            <option value="200" <?= (isset($_GET['limit']) && $_GET['limit'] == 200) ? 'selected' : ''; ?>>200</option>
            <option value="all" <?= (isset($_GET['limit']) && $_GET['limit'] == 'all') ? 'selected' : ''; ?>>All</option>
        </select>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th class="align-middle">
                    <a href="?sort=id&order=<?= ($order == 'asc') ? 'desc' : 'asc'; ?>&limit=<?= $limit; ?>" class="text-white">
                        ID <?= ($sort == 'id') ? (($order == 'asc') ? '▲' : '▼') : ''; ?>
                    </a>
                </th>
                <th class="align-middle">
                    <a href="?sort=nama&order=<?= ($order == 'asc') ? 'desc' : 'asc'; ?>&limit=<?= $limit; ?>" class="text-white">
                        Nama <?= ($sort == 'nama') ? (($order == 'asc') ? '▲' : '▼') : ''; ?>
                    </a>
                </th>
                <th class="align-middle">
                    <a href="?sort=kelas&order=<?= ($order == 'asc') ? 'desc' : 'asc'; ?>&limit=<?= $limit; ?>" class="text-white">
                        Kelas <?= ($sort == 'kelas') ? (($order == 'asc') ? '▲' : '▼') : ''; ?>
                    </a>
                </th>
                <th class="align-middle">NISN</th>
                <th class="align-middle">NIS</th>
                <th class="align-middle">Tanggal Lahir</th>
                <th class="align-middle">Pesan</th>
                <th class="align-middle">Link Google Drive</th>
                <th class="align-middle">
                    <a href="?sort=status&order=<?= ($order == 'asc') ? 'desc' : 'asc'; ?>&limit=<?= $limit; ?>" class="text-white">
                        Status <?= ($sort == 'status') ? (($order == 'asc') ? '▲' : '▼') : ''; ?>
                    </a>
                </th>
                <th class="align-middle">
                    <a href="?sort=status2&order=<?= ($order == 'asc') ? 'desc' : 'asc'; ?>&limit=<?= $limit; ?>" class="text-white">
                        Status Lihat <?= ($sort == 'status2') ? (($order == 'asc') ? '▲' : '▼') : ''; ?>
                    </a>
                </th>
                <th class="align-middle">Aksi</th>
            </tr>
        </thead>

            <tbody>
            <?php if (!empty($siswa)): ?>
                <?php foreach ($siswa as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['kelas']); ?></td>
                    <td><?= htmlspecialchars($row['nisn']); ?></td>
                    <td><?= htmlspecialchars($row['nis']); ?></td>
                    <td><?= htmlspecialchars($row['tanggal_lahir']); ?></td>
                    <td><?= html_entity_decode($row['pesan']); ?></td>
                    <td>
                        <?php if (!empty($row['link_google_drive'])): ?>
                            <a href="<?= htmlspecialchars($row['link_google_drive']); ?>" class="btn btn-primary btn-sm" target="_blank">Lihat</a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada link</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge <?= ($row['status'] == 'Lulus') ? 'bg-success' : 'bg-danger'; ?>">
                            <?= htmlspecialchars($row['status']); ?>
                        </span>
                    </td>
                    <td class="<?= ($row['status2'] == 'Sudah Melihat') ? 'bg-success text-white' : 'bg-danger text-white'; ?>">
                        <?= ($row['status2'] == 'Sudah Melihat') ? '✅ Sudah Melihat' : '❌ Belum Melihat'; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('admin/siswa/edit/'.$row['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('admin/siswa/delete/'.$row['id']); ?>" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" 
                               class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Tidak ada data siswa.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <span>Menampilkan <?= count($siswa) ?> dari <?= $total_rows; ?> siswa</span>
            <?= $pagination; ?>
        </div>
    </div>

    <!-- Pagination -->
    <!-- <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?= $this->pagination->create_links(); ?>
    </ul> -->
    
</nav>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/siswa/proses_import'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                        value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="mb-3">
                        <label for="file_excel" class="form-label">Pilih File Excel (.xls / .xlsx)</label>
                        <input type="file" name="file_excel" class="form-control" required accept=".xls,.xlsx">
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>



<footer class="footer mt-auto py-1 bg-dark text-white text-center" style="font-size: 0.8rem;">
    <div class="container">
        <?php $this->load->view('layouts/footer'); ?>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateDelete() {
            let input = document.getElementById("confirmText").value;
            let deleteBtn = document.getElementById("deleteButton");
            if (input === "YAKIN SAYA HAPUS") {
                deleteBtn.classList.remove("disabled");
            } else {
                deleteBtn.classList.add("disabled");
            }
        }
    </script>
    
</body>
</html>
