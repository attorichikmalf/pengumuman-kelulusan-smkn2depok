<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Admin</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            padding-top: 70px;
            margin-bottom: 50px; /* Menambah jarak antara konten dan footer */
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <?php $this->load->view('admin/layout/navbar'); ?>

    <div class="container content">
        <h2 class="mb-4">Tambah Admin</h2>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/profile/save_admin'); ?>" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirm" class="form-control" placeholder="Konfirmasi Password" required>
            </div>

            <div class="mt-4"> <!-- Menambah jarak tombol dari elemen sebelumnya -->
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/profile'); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <?php $this->load->view('admin/layout/footer'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>