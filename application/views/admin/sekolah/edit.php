<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Sekolah</title>
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

    <div class="container content">
        <h2 class="mt-4">Edit Sekolah</h2>
        <form action="<?= site_url('admin/sekolah/update/'.$sekolah['id']) ?>" method="post" enctype="multipart/form-data" class="mt-3">
            <div class="mb-3">
                <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" value="<?= $sekolah['nama_sekolah'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="npsn" class="form-label">NPSN</label>
                <input type="text" name="npsn" id="npsn" class="form-control" 
                    value="<?= htmlspecialchars($sekolah['npsn']) ?>" 
                    required pattern="[0-9]+" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                <small class="text-muted">Hanya boleh berisi angka.</small>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="<?= $sekolah['alamat'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" name="kota" id="kota" class="form-control" value="<?= $sekolah['kota'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" name="provinsi" id="provinsi" class="form-control" value="<?= $sekolah['provinsi'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo Sekolah</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                <?php if (!empty($sekolah['logo'])): ?>
                    <div class="mt-2">
                        <p>Logo saat ini:</p>
                        <img src="<?= base_url('uploads/logo/' . $sekolah['logo']) ?>" alt="Logo Sekolah" style="max-height: 100px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="background" class="form-label">Background Sekolah</label>
                <input type="file" name="background" id="background" class="form-control" accept="image/*">
                <?php if (!empty($sekolah['background'])): ?>
                    <div class="mt-2">
                        <p>Background saat ini:</p>
                        <img src="<?= base_url('uploads/background/' . $sekolah['background']) ?>" alt="Background Sekolah" style="max-height: 100px;">
                    </div>
                <?php endif; ?>
            </div>


            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <?php $this->load->view('admin/layout/footer'); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>