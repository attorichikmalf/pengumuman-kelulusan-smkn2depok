<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Kelola Admin</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: padding-top 0.3s ease-in-out;
        }
        .content {
            flex: 1;
            padding-top: 70px;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Include Navbar -->
    <?php $this->load->view('admin/layout/navbar'); ?>

    <div class="container content">
        <h3 class="mb-3 text-center">Kelola Admin</h3>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <!-- Tombol Tambah Admin -->
        <div class="mb-3">
            <a href="<?= site_url('admin/profile/add_admin'); ?>" class="btn btn-primary">+ Tambah Admin</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="align-middle">Nama</th>
                        <th class="align-middle">Username</th>
                        <th class="align-middle">Email</th>
                        <th class="align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($admins)): ?>
                        <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?= htmlspecialchars($admin->nama); ?></td>
                            <td><?= htmlspecialchars($admin->username); ?></td>
                            <td><?= htmlspecialchars($admin->email); ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('admin/profile/delete_admin/'.$admin->id); ?>" 
                                   onclick="return confirm('Yakin ingin menghapus?');" 
                                   class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data admin.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tombol Kembali ke Dashboard -->
        <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>

    <!-- Include Footer -->
    <?php $this->load->view('admin/layout/footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
