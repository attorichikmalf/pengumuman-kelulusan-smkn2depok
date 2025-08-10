<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
            <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']) ?>">
        <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Data Sekolah</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
        }
        .footer {
            background: #f8f9fa;
            padding: 10px 0;
            text-align: center;
            position: relative;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php $this->load->view('admin/layout/navbar'); ?>

    <div class="container content">
        <br>
        <h2>DATA Sekolah</h2>
        
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"> <?= $this->session->flashdata('success'); ?> </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Logo</th>
                        <th>Background</th>
                        <th>Nama Sekolah</th>
                        <th>NPSN</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>Provinsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($list_sekolah as $s): ?>

                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center">
                            <?php if (!empty($s['logo']) && file_exists(FCPATH . 'uploads/logo/' . $s['logo'])): ?>
                                <img src="<?= base_url('uploads/logo/' . $s['logo']) ?>" alt="Logo" style="height: 50px;">
                            <?php else: ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if (!empty($s['background']) && file_exists(FCPATH . 'uploads/background/' . $s['background'])): ?>
                                <img src="<?= base_url('uploads/background/' . $s['background']) ?>" alt="background" style="height: 50px;">
                            <?php else: ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($s['nama_sekolah']); ?></td>
                        <td><?= htmlspecialchars($s['npsn']); ?></td>
                        <td><?= htmlspecialchars($s['alamat']); ?></td>
                        <td><?= htmlspecialchars($s['kota']); ?></td>
                        <td><?= htmlspecialchars($s['provinsi']); ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('admin/sekolah/edit/'.$s['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
    
<footer class="footer mt-auto py-1 bg-dark text-white text-center" style="font-size: 0.8rem;">
    <div class="container">
        <?php $this->load->view('layouts/footer'); ?>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>