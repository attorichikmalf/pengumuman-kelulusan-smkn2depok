<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kelulusan <?= strtoupper(htmlspecialchars($sekolah['nama_sekolah'], ENT_QUOTES, 'UTF-8')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>

<style>
    body {
    background-image: var(--bg-image);
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    background-size: cover;
    position: relative;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }
    .content {
        position: relative;
        z-index: 1;
    }
    @media (max-width: 768px) {
        body {
            background-size: cover;
            background-position: center;
        }
    }

    /* Animasi Tambahan */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulseOnce {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.03);
        }
        100% {
            transform: scale(1);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.8s ease-out;
    }

    .animate-pulseOnce {
        animation: pulseOnce 1s ease-in-out;
    }
</style>

<body
    style="background-image: url('<?= base_url('uploads/background/' . $sekolah['background']); ?>'); background-size: cover; background-position: center; background-attachment: fixed;"
    class="bg-gray-900 flex items-center justify-center min-h-screen w-full px-4"
>

<div class="content bg-black bg-opacity-60 p-8 rounded-lg shadow-lg w-full max-w-md animate-fadeInUp">
    
    <?php if ($this->session->flashdata('error')): ?>
        <?php foreach ((array) $this->session->flashdata('error') as $error): ?>
            <div class="bg-red-500 text-white p-3 mb-3 rounded"> <?= $error; ?> </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="text-center mb-6 animate-fadeInUp">
        <h1 class="text-3xl font-extrabold text-white mb-2">HASIL PENGUMUMAN KELULUSAN</h1>
        <?php if (!empty($sekolah['logo']) && file_exists(FCPATH . 'uploads/logo/' . $sekolah['logo'])): ?>
        <img src="<?= base_url('uploads/logo/' . $sekolah['logo']) ?>" alt="Logo Sekolah" class="mx-auto mb-4 animate-pulseOnce" width="150" height="50">
        <?php else: ?>
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo Default" class="mx-auto mb-4 animate-pulseOnce" width="150" height="50">
        <?php endif; ?>
        <p class="text-gray-300">Masukkan NISN / NIS dan Tanggal Lahir Anda.</p>
    </div>

    <!-- Countdown Timer -->
    <div class="text-center text-white mb-6 animate-fadeInUp" id="countdown-timer">
        <p id="target-info" class="text-blue-400 mt-2"></p><br>
        <p id="timer" class="text-xl font-semibold">Waktu Tersisa:</p>
        <div id="countdown-boxes" class="flex justify-center space-x-2 mt-2">
            <div class="bg-gray-800 p-4 rounded-lg shadow-md text-center">
                <p id="days" class="text-2xl font-bold">00</p>
                <span class="text-sm">Hari</span>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-md text-center">
                <p id="hours" class="text-2xl font-bold">00</p>
                <span class="text-sm">Jam</span>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-md text-center">
                <p id="minutes" class="text-2xl font-bold">00</p>
                <span class="text-sm">Menit</span>
            </div>
            <div class="bg-gray-800 p-4 rounded-lg shadow-md text-center">
                <p id="seconds" class="text-2xl font-bold">00</p>
                <span class="text-sm">Detik</span>
            </div>
        </div>
    </div>

    <!-- Form Input -->
    <form action="<?= site_url('dashboard/cek_pengumuman'); ?>" method="post" id="form-pengumuman" class="hidden animate-fadeInUp">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="mb-4">
            <label class="block text-sm font-medium text-blue-400">Silahkan Pilih Gunakan NISN/NIS</label>
            <select id="pilih-identitas" onchange="toggleInput()" class="w-full px-4 py-3 bg-gray-700 text-gray-300 rounded-md">
                <option value="nisn">NISN</option>
                <option value="nis">NIS</option>
            </select>
        </div>
        <div class="mb-4" id="nisn-input">
            <label class="block text-sm font-medium text-blue-400">NISN</label>
            <input id="nisn" name="nisn" type="text" class="w-full px-4 py-3 bg-gray-700 text-gray-300 rounded-md" maxlength="15" placeholder="Masukan NISN">
        </div>
        <div class="mb-4 hidden" id="nis-input">
            <label class="block text-sm font-medium text-blue-400">NIS</label>
            <input id="nis" name="nis" type="text" class="w-full px-4 py-3 bg-gray-700 text-gray-300 rounded-md" maxlength="15" placeholder="Masukan NIS">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-blue-400">Tanggal Lahir</label>
            <input id="tanggal_lahir" name="tanggal_lahir" type="text" placeholder="YYYY-MM-DD"
                class="w-full px-4 py-3 bg-gray-700 text-gray-300 rounded-md" required>
        </div>
        <button class="w-full py-3 px-6 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 transform hover:scale-105" type="submit">LIHAT HASIL</button>
    </form>

    <!-- Pesan expired -->
    <div id="expired-message" class="text-center text-red-500 mt-4 hidden animate-fadeInUp">
        Masa akses pengumuman telah berakhir, maksimal akses hanya 2 hari.
    </div>
<br>
    <?php $this->load->view('layouts/footer'); ?>
</div>

<!-- Flatpickr CSS dan JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Fungsi toggle input berdasarkan pilihan identitas
    function toggleInput() {
        const pilih = document.getElementById("pilih-identitas").value;
        document.getElementById("nisn-input").classList.toggle("hidden", pilih !== "nisn");
        document.getElementById("nis-input").classList.toggle("hidden", pilih !== "nis");
    }

    // Ambil nilai target waktu dari PHP (format: 'YYYY-MM-DD HH:mm:ss')
    const targetTime = "<?= $target_time ?? ''; ?>";

    if (targetTime) {
        // Konversi ke objek Date JavaScript (ganti spasi dengan 'T' agar valid ISO string)
        const targetDate = new Date(targetTime.replace(' ', 'T'));
        const targetMillis = targetDate.getTime();

        // Element-elemen DOM yang digunakan
        const formPengumuman = document.getElementById('form-pengumuman');
        const countdownTimer = document.getElementById('countdown-timer');
        const messageContainer = document.getElementById('expired-message');
        const targetInfo = document.getElementById('target-info');

        // Fungsi untuk update countdown
        function updateCountdown() {
            const now = Date.now();
            const distance = targetMillis - now;
            const twoDays = 2 * 24 * 60 * 60 * 1000; // 2 hari dalam ms

            if (now >= targetMillis && now <= targetMillis + twoDays) {
                // Reload hanya sekali setelah target waktu tercapai
                if (!localStorage.getItem('pengumumanRefreshed')) {
                    localStorage.setItem('pengumumanRefreshed', 'true');
                    location.reload();
                    return;
                }

                // Tampilkan form pengumuman, sembunyikan countdown dan pesan expired
                formPengumuman?.classList.remove('hidden');
                countdownTimer?.classList.add('hidden');
                messageContainer?.classList.add('hidden');

                clearInterval(countdownInterval);
            } else if (now > targetMillis + twoDays) {
                // Jika sudah lewat 2 hari setelah target, pengumuman kedaluwarsa
                formPengumuman?.classList.add('hidden');
                countdownTimer?.classList.add('hidden');
                messageContainer?.classList.remove('hidden');

                clearInterval(countdownInterval);
            } else {
                // Update tampilan countdown waktu berjalan
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Update setiap elemen countdown jika ada
                const updateText = (id, value) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = String(value).padStart(2, '0');
                };

                updateText('days', days);
                updateText('hours', hours);
                updateText('minutes', minutes);
                updateText('seconds', seconds);

                // Pastikan form dan pesan expired tersembunyi, countdown tampil
                formPengumuman?.classList.add('hidden');
                countdownTimer?.classList.remove('hidden');
                messageContainer?.classList.add('hidden');
            }
        }

        // Jalankan fungsi updateCountdown setiap detik
        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown(); // Jalankan segera saat halaman dimuat

        // Format dan tampilkan informasi target waktu
        const daysName = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const monthsName = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const d = targetDate;
        const formatted = `${daysName[d.getDay()]}, ${d.getDate()} ${monthsName[d.getMonth()]} ${d.getFullYear()} Pukul ${String(d.getHours()).padStart(2, '0')}.${String(d.getMinutes()).padStart(2, '0')}`;

        if (targetInfo) {
            targetInfo.innerHTML = `Pengumuman akan dibuka pada:<br>${formatted}`;
        }
    }
</script>

<script>
flatpickr("#tanggal_lahir", {
    dateFormat: "Y-m-d",
    allowInput: true,
    defaultDate: "2005-01-01", // bisa diatur default-nya
    altInput: true,
    altFormat: "F j, Y", // tampil cantik, tapi value tetap YYYY-MM-DD
    disableMobile: true // paksa pakai flatpickr di mobile
});
</script>

</body>
</html>
