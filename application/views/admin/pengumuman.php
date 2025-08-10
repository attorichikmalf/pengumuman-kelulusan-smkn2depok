<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Waktu Pengumuman</title>

    <!-- Menggunakan Bootstrap untuk styling utama -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Tailwind untuk elemen tambahan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            padding-top: 80px; /* Padding untuk menghindari navbar fixed-top */
        }

        .alert {
            margin-bottom: 20px;
        }

        .navbar-nav {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    </style>    
</head>
<body class="bg-white">

<!-- Include Navbar -->
<?php $this->load->view('admin/layout/navbar'); ?>

<!-- Content -->
<div class="content">
    <div class="container">
        <!-- Notifikasi pesan sukses/error -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <!-- Form Pengelolaan Waktu Pengumuman -->
        <div class="bg-light p-4 rounded shadow-lg w-full max-w-md mx-auto">
            <div class="text-center mb-3">
                <h1 class="text-3xl font-bold text-dark">Pengelolaan Waktu Pengumuman</h1>
                <p class="text-secondary">Pengaturan waktu untuk menampilkan pengumuman kelulusan.</p>
            </div>

            <!-- Form untuk mengupdate waktu countdown -->
            <form action="<?= site_url('admin/pengumuman/update_time'); ?>" method="post">
                <div class="mb-3">
                    <label class="form-label text-dark" for="target_time">Waktu Pengumuman</label>
                    <input class="form-control" id="target_time" name="target_time" type="datetime-local" 
                        value="<?= !empty($countdown_time) ? $countdown_time : date('Y-m-d\TH:i'); ?>" required>
                </div>

                <button class="btn btn-primary w-100" type="submit">
                    UPDATE WAKTU
                </button>
            </form>

            <!-- Tombol Kembali ke Dashboard -->
            <div class="text-center mt-3">
                <a href="<?= site_url('admin/dashboard'); ?>" class="btn btn-danger">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-1 bg-dark text-white text-center" style="font-size: 0.8rem;">
    <div class="container">
        <?php $this->load->view('layouts/footer'); ?>
    </div>
</footer>
</body>
</html>
