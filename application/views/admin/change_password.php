<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Ganti Password</title>
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
            max-width: 500px;
        }
    </style>
</head>

<body>

    <!-- Include Navbar -->
    <?php $this->load->view('admin/layout/navbar'); ?>

    <div class="container content">
        <h3 class="mb-3 text-center">Ganti Password</h3>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('admin/profile/change_password'); ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                        value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="mb-3">
                        <label class="form-label">Password Lama:</label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru:</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password:</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <small id="passwordMismatch" class="text-danger d-none">Password tidak cocok</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Ubah Password</button>
                    
                    <!-- Tombol Kembali ke Dashboard -->
                    <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-secondary w-100 mt-2">Kembali ke Dashboard</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php $this->load->view('admin/layout/footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('confirm_password').addEventListener('input', function() {
            let newPassword = document.getElementById('new_password').value;
            let confirmPassword = this.value;
            let errorMessage = document.getElementById('passwordMismatch');

            if (newPassword !== confirmPassword) {
                errorMessage.classList.remove('d-none');
            } else {
                errorMessage.classList.add('d-none');
            }
        });
    </script>
</body>
</html>
