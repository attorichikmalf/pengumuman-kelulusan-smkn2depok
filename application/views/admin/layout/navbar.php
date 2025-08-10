<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>SMKN 2 DEPOK</title>
    <style>
        body {
            padding-top: 56px; /* Agar konten tidak tertutup navbar */
        }
        .nav-item {
            margin: 0 5px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(90deg, #0056b3, #8a2be2);">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-semibold" href="#">SMKN 2 DEPOK</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse navbar-nav-scroll" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item border border-light px-3 py-2 rounded">
                    <a class="nav-link text-white fw-semibold fs-6" href="<?= site_url('admin/dashboard'); ?>">Dashboard</a>
                </li>
                <li class="nav-item border border-light px-3 py-2 rounded">
                    <a class="nav-link text-white fw-semibold fs-6" href="<?= site_url('admin/siswa'); ?>">Kelola Siswa</a>
                </li>
                <li class="nav-item border border-light px-3 py-2 rounded">
                    <a class="nav-link text-white fw-semibold fs-6" href="<?= site_url('admin/pengumuman'); ?>">Kelola Pengumuman</a>
                </li>
                <li class="nav-item border border-light px-3 py-2 rounded">
                    <a class="nav-link text-white fw-semibold fs-6" href="<?= site_url('admin/sekolah'); ?>">Kelola Sekolah</a>
                </li>

                <!-- Dropdown Menu untuk Profil/Admin -->
                <li class="nav-item dropdown border border-light px-3 py-2 rounded">
                    <a class="nav-link dropdown-toggle text-white fw-semibold fs-6" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kelola Admin
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="<?= site_url('admin/profile'); ?>">Profil Saya</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('admin/profile/change_password'); ?>">Ganti Password</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('admin/profile/manage_admin'); ?>">Kelola Admin</a></li>
                    </ul>
                </li>

                <li class="nav-item border border-light px-3 py-2 rounded">
                    <a class="nav-link text-warning fw-semibold fs-6" href="<?= site_url('admin/auth/logout'); ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap Bundle (Popper.js & JavaScript) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
});
</script>

</body>
</html>
