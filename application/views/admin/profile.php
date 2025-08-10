<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Profil Admin</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
        .footer {
            background: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <!-- Include Navbar -->
    <?php $this->load->view('admin/layout/navbar'); ?>

    <div class="container mt-4 content">
        <h2>Profil Saya</h2>

        <!-- Menampilkan notifikasi sukses -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('success'); ?> </div>
        <?php endif; ?>

        <!-- Menampilkan notifikasi error -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"> <?= $this->session->flashdata('error'); ?> </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/profile/update_profile'); ?>" class="mt-3">
            <div class="mb-3">
                <label class="form-label">Nama:</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($admin->nama, ENT_QUOTES, 'UTF-8'); ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($admin->email, ENT_QUOTES, 'UTF-8'); ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($admin->username, ENT_QUOTES, 'UTF-8'); ?>" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= site_url('admin/dashboard'); ?>" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Include Footer -->
<footer class="footer mt-auto py-1 bg-dark text-white text-center" style="font-size: 0.8rem;">
    <div class="container">
        <?php $this->load->view('layouts/footer'); ?>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>