<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard Admin</title>
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
            padding: 80px 20px 20px;
        }
        footer.footer {
        padding-top: 5px;    /* padding atas kecil */
        padding-bottom: 5px; /* padding bawah kecil */
        font-size: 0.8rem;   /* teks kecil */
        min-height: auto;    /* supaya gak terlalu tinggi */
        line-height: 1.2;    /* jarak antar baris */
    }
    </style>
</head>
<body>

<!-- Include Navbar -->
<?php $this->load->view('admin/layout/navbar'); ?>

<!-- Content -->
<div class="container mt-4">
    <h2 class="text-center">Statistik Pengumuman</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3 shadow">
                <p class="fw-bold fs-4">Total Siswa: <span class="fw-bolder"><?= isset($total_siswa) ? $total_siswa : 0; ?></span></p>
                <p class="text-success fs-4">Siswa Sudah Melihat: <span class="fw-bolder"><?= isset($sudah_melihat) ? $sudah_melihat : 0; ?></span></p>
                <p class="text-danger fs-4">Siswa Belum Melihat: <span class="fw-bolder"><?= isset($belum_melihat) ? $belum_melihat : 0; ?></span></p>
            </div>
        </div>
        <div class="col-md-6">
            <canvas id="pengumumanChart"></canvas>
        </div>
    </div>
</div>

<script>
    var ctx = document.getElementById('pengumumanChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Sudah Melihat', 'Belum Melihat'],
            datasets: [{
                data: [<?= isset($sudah_melihat) ? $sudah_melihat : 0; ?>, <?= isset($belum_melihat) ? $belum_melihat : 0; ?>],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>

<footer class="footer mt-auto py-1 bg-dark text-white text-center" style="font-size: 0.8rem;">
    <div class="container">
        <?php $this->load->view('layouts/footer'); ?>
    </div>
</footer>

</body>
</html>