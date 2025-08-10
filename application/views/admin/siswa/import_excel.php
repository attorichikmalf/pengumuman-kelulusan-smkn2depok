<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <title>Import Data Siswa</title>
</head>
<body>
    <h2>Import Data Siswa dari Excel</h2>
    
    <?php if ($this->session->flashdata('error')): ?>
        <p style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <form action="<?php echo site_url('admin/siswa/proses_import'); ?>" method="post" enctype="multipart/form-data">
        <label>Pilih File Excel:</label>
        <input type="file" name="file_excel" accept=".xls, .xlsx" required>
        <button type="submit">Import</button>
    </form>

    <br>
    <a href="<?php echo site_url('admin/siswa'); ?>">Kembali ke Data Siswa</a>
</body>
</html>
