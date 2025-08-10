<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #007bff, #00d4ff);
        }
        .login-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
        .input-group-text {
            cursor: pointer;
        }
        .modal-content {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <?php if (!empty($sekolah['logo']) && file_exists(FCPATH . 'uploads/logo/' . $sekolah['logo'])): ?>
        <img src="<?= base_url('uploads/logo/' . $sekolah['logo']) ?>" alt="Logo Sekolah" class="logo">
        <?php else: ?>
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Default" class="logo">
        <?php endif; ?>

        <h2 class="text-dark">Login Admin</h2>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="modal fade show" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true" style="display: block;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-danger" id="errorModalLabel">Login Gagal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                        </div>
                        <div class="modal-body text-center">
                            <?= $this->session->flashdata('error'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function closeModal() {
                    document.getElementById('errorModal').style.display = 'none';
                }
            </script>
        <?php endif; ?>
        
        <form action="<?= site_url('admin/auth/process_login'); ?>" method="POST">
            <div class="mb-3">
                <input type="text" name="username" placeholder="Username" class="form-control" required>
            </div>
            <div class="mb-3 input-group">
                <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
                <span class="input-group-text" id="togglePassword"><i class="bi bi-eye"></i></span>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        
        <div class="mt-3 text-muted small">
            &copy; <?= date('Y'); ?> Admin Panel. All Rights Reserved.
        </div>
    </div>
    
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>