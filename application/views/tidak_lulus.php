<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <title>Pengumuman Kelulusan <?= htmlspecialchars($siswa['nama'], ENT_QUOTES, 'UTF-8'); ?></title>
    <style>
        body {
            background: url('<?= base_url('assets/img/background.jpg'); ?>') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            position: relative;
            z-index: 0;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
    </style>
</head>
<body class="bg-gray-800 flex items-center justify-center min-h-screen p-4">
    <div class="bg-gray-900 text-white rounded-lg shadow-lg overflow-hidden w-full max-w-2xl animate-fade-in transition duration-700 ease-in-out transform">
        <div class="bg-gradient-to-r from-red-900 to-red-500 shadow-lg p-6 flex flex-row justify-between items-center">
            <div class="text-left flex-1">
                <h1 class="text-xl md:text-2xl font-bold animate-slide-in-up">ANDA DINYATAKAN TIDAK LULUS <br> TAHUN <?= date('Y'); ?></h1>
                <p class="mt-2 text-sm md:text-base"><?= html_entity_decode($siswa['pesan'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <img alt="Logo Sekolah" src="<?= base_url('assets/img/logo.png'); ?>" class="w-24 h-auto ml-4 animate-fade-in" />
        </div>

        <div class="p-6">
            <p class="text-blue-500 mb-1">NISN : <span><?= htmlspecialchars($siswa['nisn'], ENT_QUOTES, 'UTF-8'); ?> |</span>
                <span> NIS : <?= htmlspecialchars($siswa['nisn'], ENT_QUOTES, 'UTF-8'); ?></span></p>

            <h2 class="text-2xl md:text-3xl font-bold mt-2 animate-fade-in">
                <?= strtoupper(htmlspecialchars($siswa['nama'], ENT_QUOTES, 'UTF-8')); ?>
            </h2>
            <p class="mt-1"><?= htmlspecialchars($siswa['kelas'], ENT_QUOTES, 'UTF-8'); ?></p>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tanggal Lahir -->
                <div class="transition-opacity duration-700 delay-100 opacity-0 animate-fade-in">
                    <p class="text-blue-400">Tanggal Lahir</p>
                    <p class="mt-1"><?= htmlspecialchars($siswa['tanggal_lahir'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <!-- Nama Sekolah -->
                <div class="transition-opacity duration-700 delay-200 opacity-0 animate-fade-in">
                    <p class="text-blue-400">Nama Sekolah</p>
                    <p class="mt-1"><?= strtoupper(htmlspecialchars($sekolah['nama_sekolah'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
                <!-- Kabupaten/Kota -->
                <div class="transition-opacity duration-700 delay-300 opacity-0 animate-fade-in">
                    <p class="text-blue-400">Kabupaten/Kota</p>
                    <p class="mt-1"><?= isset($sekolah['kota']) ? strtoupper(htmlspecialchars($sekolah['kota'])) : 'Tidak tersedia'; ?></p>
                </div>
                <!-- Provinsi -->
                <div class="transition-opacity duration-700 delay-400 opacity-0 animate-fade-in">
                    <p class="text-blue-400">Provinsi</p>
                    <p class="mt-1"><?= strtoupper(htmlspecialchars($sekolah['provinsi'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
            </div>

            <!-- Catatan -->
            <p class="mt-4 text-sm md:text-base bg-red-500 text-white p-2 rounded shadow animate-slide-in-up">
                <b><i>NOTE: PASTIKAN DATA DI SKL SUDAH SESUAI. JIKA ADA KETIDAKSESUAIAN, WAJIB KE SEKOLAH DAN KE BAGIAN TATA USAHA.</i></b>
            </p>

            <!-- Tombol -->
            <div class="mt-10 flex flex-col md:flex-row gap-6 justify-center items-center w-full animate-fade-in">
                <?php
                    $show_button = false;
                    $download_url = '';
                    if (!empty($siswa['link_google_drive']) && preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $siswa['link_google_drive'], $matches)) {
                        $file_id = $matches[1];
                        $download_url = "https://drive.google.com/uc?export=download&id=" . $file_id;
                        $show_button = true;
                    }
                ?>
                <?php if ($show_button): ?>
                    <button id="downloadBtn"
                        data-url="<?= htmlspecialchars($download_url, ENT_QUOTES, 'UTF-8'); ?>"
                        class="flex-1 px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition transform hover:scale-105 shadow-lg text-center">
                        📄 Download Document SKL
                    </button>
                <?php else: ?>
                    <p class="text-red-500 font-semibold">📄 Dokumen SKL belum tersedia.</p>
                <?php endif; ?>
                <a id="countdownButton" href="<?= site_url('dashboard'); ?>"
                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition transform hover:scale-105 text-center">
                    ⬅ Kembali ke Home (<span id="countdown">10:00</span>)
                </a>
            </div>

            <footer class="text-center mt-6 text-white text-sm p-4 fade-slide-up-child">
                <?php $this->load->view('layouts/footer'); ?>
            </footer>
        </div>
    </div>
    <script>
    const downloadBtn = document.getElementById('downloadBtn');
    let canDownload = true;
    let countdownDuration = 20; // dalam detik

    if (downloadBtn) {
        downloadBtn.addEventListener('click', function () {
            if (!canDownload) return;

            const fileUrl = this.getAttribute('data-url');
            window.location.href = fileUrl; // atau gunakan window.location.href jika ingin langsung redirect
            canDownload = false;

            let timeLeft = countdownDuration;
            this.disabled = true;
            this.classList.add("opacity-60", "cursor-not-allowed");
            const originalText = this.innerHTML;

            const interval = setInterval(() => {
                this.innerHTML = `⏳ Tunggu ${timeLeft} detik untuk download ulang`;
                timeLeft--;

                if (timeLeft < 0) {
                    clearInterval(interval);
                    this.innerHTML = originalText;
                    this.disabled = false;
                    this.classList.remove("opacity-60", "cursor-not-allowed");
                    canDownload = true;
                }
            }, 1000);
        });
    }
</script>

    <script>
        const countdownElement = document.getElementById("countdown");
        const totalCountdown = 300; // 10 menit dalam detik
        const redirectURL = "<?= site_url('dashboard'); ?>"; // URL tujuan setelah waktu habis

        function startCountdown() {
            let startTime = sessionStorage.getItem("countdownStartTime");
            let currentTime = Math.floor(Date.now() / 1000); // Waktu sekarang dalam detik

            // Jika tidak ada waktu tersimpan (siswa baru datang dari dashboard), reset countdown
            if (!startTime) {
                startTime = currentTime;
                sessionStorage.setItem("countdownStartTime", startTime);
            }

            let elapsedTime = currentTime - startTime; // Hitung waktu yang telah berlalu
            let remainingTime = totalCountdown - elapsedTime; // Hitung waktu tersisa

            if (remainingTime <= 0) {
                sessionStorage.removeItem("countdownStartTime"); // Hapus penyimpanan saat waktu habis
                window.location.href = redirectURL; // Arahkan ke dashboard
                return;
            }

            updateCountdown(remainingTime);
        }

        function updateCountdown(remainingTime) {
            function tick() {
                let minutes = Math.floor(remainingTime / 60);
                let seconds = remainingTime % 60;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                countdownElement.textContent = `${minutes}:${seconds}`;

                if (remainingTime > 0) {
                    setTimeout(() => {
                        remainingTime--;
                        tick();
                    }, 1000);
                } else {
                    sessionStorage.removeItem("countdownStartTime"); // Hapus penyimpanan saat selesai
                    window.location.href = redirectURL;
                }
            }
            tick();
        }

        // Jalankan countdown saat halaman dimuat
        window.onload = startCountdown;
    </script>

     <!-- Animasi Kustom -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }

        @keyframes slide-in-up {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-slide-in-up {
            animation: slide-in-up 0.6s ease-out forwards;
        }
    </style>

<canvas id="sadStickerCanvas" style="position:fixed; top:0; left:0; pointer-events:none; z-index:50; opacity:0; transition: opacity 1s;"></canvas>
<script>
    const sadCanvas = document.getElementById('sadStickerCanvas');
    const sadCtx = sadCanvas.getContext('2d');
    sadCanvas.width = window.innerWidth;
    sadCanvas.height = window.innerHeight;

    const sadStickers = [];
    const sadImage = new Image();
    sadImage.src = '<?= base_url('assets/img/sad-face.png'); ?>'; // Ganti sesuai lokasi file

    for (let i = 0; i < 20; i++) {
        sadStickers.push({
            x: Math.random() * sadCanvas.width,
            y: Math.random() * -sadCanvas.height,
            speed: 1 + Math.random() * 1.5,
            size: 40 + Math.random() * 20,
            rotation: Math.random() * 360,
            rotationSpeed: Math.random() * 1.5 - 0.75
        });
    }

    function animateSadStickers() {
        sadCtx.clearRect(0, 0, sadCanvas.width, sadCanvas.height);
        sadStickers.forEach(sticker => {
            sadCtx.save();
            sadCtx.translate(sticker.x, sticker.y);
            sadCtx.rotate(sticker.rotation * Math.PI / 180);
            sadCtx.drawImage(sadImage, -sticker.size / 2, -sticker.size / 2, sticker.size, sticker.size);
            sadCtx.restore();

            sticker.y += sticker.speed;
            sticker.rotation += sticker.rotationSpeed;

            if (sticker.y > sadCanvas.height + 50) {
                sticker.y = -50;
                sticker.x = Math.random() * sadCanvas.width;
            }
        });
        requestAnimationFrame(animateSadStickers);
    }

    sadImage.onload = () => {
        sadCanvas.style.opacity = 1;
        animateSadStickers();
        setTimeout(() => {
            sadCanvas.style.opacity = 0;
        }, 5000); // Tampilkan selama 5 detik
    };
</script>

</body>
</html>