<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Form Siswa</title>
    <style>
        /* CSS untuk memastikan footer selalu di bawah */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body>

    <!-- Include Navbar -->
    <?php $this->load->view('admin/layout/navbar'); ?>
    
    <div class="container mt-5 content">
        <h2 class="mb-4"><?= isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa'; ?></h2>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <form method="post" action="<?= isset($siswa) ? site_url('admin/siswa/update/' . $siswa->id) : site_url('admin/siswa/simpan'); ?>">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" 
                    value="<?= set_value('nama', isset($siswa) ? $siswa->nama : ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="nisn" class="form-label">NISN:</label>
                <input type="text" class="form-control" id="nisn" name="nisn" pattern="[0-9]+" 
                    value="<?= set_value('nisn', isset($siswa) ? $siswa->nisn : ''); ?>" 
                    required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                <small class="text-muted">Hanya boleh berisi angka.</small>
            </div>

            <div class="mb-3">
                <label for="nis" class="form-label">NIS:</label>
                <input type="text" class="form-control" id="nis" name="nis" pattern="[0-9]+" 
                    value="<?= set_value('nis', isset($siswa) ? $siswa->nis : ''); ?>" 
                    required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                <small class="text-muted">Hanya boleh berisi angka.</small>
            </div>

            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas:</label>
                <input type="text" class="form-control" id="kelas" name="kelas" 
                    value="<?= set_value('kelas', isset($siswa) ? $siswa->kelas : ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" 
                    value="<?= set_value('tanggal_lahir', isset($siswa) ? $siswa->tanggal_lahir : ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="pesan" class="form-label">Pesan:</label>
                <textarea class="form-control" id="pesan" name="pesan" rows="3"><?= set_value('pesan', isset($siswa) ? $siswa->pesan : ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="link_google_drive" class="form-label">Link Google Drive:</label>
                <input type="url" class="form-control" id="link_google_drive" name="link_google_drive" 
                    value="<?= set_value('link_google_drive', isset($siswa) ? $siswa->link_google_drive : ''); ?>">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Lulus" <?= set_select('status', 'Lulus', (isset($siswa) && $siswa->status == 'Lulus')); ?>>Lulus</option>
                    <option value="Tidak Lulus" <?= set_select('status', 'Tidak Lulus', (isset($siswa) && $siswa->status == 'Tidak Lulus')); ?>>Tidak Lulus</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mb-3"><?= isset($siswa) ? 'Update' : 'Simpan'; ?></button>
            <a href="<?= site_url('admin/siswa'); ?>" class="btn btn-secondary mb-3">Batal</a>
        </form>

    </div>

    <!-- Include Footer -->
    <?php $this->load->view('admin/layout/footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
