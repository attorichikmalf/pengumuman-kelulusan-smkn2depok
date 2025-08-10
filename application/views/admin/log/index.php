<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <h1><?= $title ?></h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>IP Address</th>
                <th>Waktu</th>
                <th>NISN</th>
                <th>NIS</th>
                <th>Tanggal Lahir Input</th>
                <th>Status</th>
                <th>Nama Diduga</th>
                <th>ID Siswa Diduga</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log->id ?></td>
                <td><?= $log->ip_address ?></td>
                <td><?= $log->waktu ?></td>
                <td><?= $log->nisn ?></td>
                <td><?= $log->nis ?></td>
                <td><?= $log->tanggal_lahir_input ?></td>
                <td><?= $log->status_cocok ?></td>
                <td><?= $log->nama_diduga ?></td>
                <td><?= $log->id_siswa_diduga ?></td>
                <td><a href="<?= site_url('admin/log/detail/'.$log->id) ?>">Detail</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Total Siswa: <?= $total ?></h2>
    <h2>Siswa yang sudah melihat: <?= count($sudah_melihat) ?></h2>
    <h2>Siswa yang belum melihat: <?= count($belum_melihat) ?></h2>
</body>
</html>
