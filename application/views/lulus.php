<!DOCTYPE html>
<html lang="id">
<head>
    <?php if (!empty($sekolah['logo'])): ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/logo/' . $sekolah['logo']); ?>">
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <title>Pengumuman Kelulusan <?= htmlspecialchars($siswa['nama'], ENT_QUOTES, 'UTF-8'); ?> </title>
</head>
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
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }

    /* Animasi fade-in dan slide-up untuk kontainer utama */
    .fade-slide-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeSlideUp 0.8s ease forwards;
        animation-delay: 0.3s;
    }

    .fade-slide-up-child {
        opacity: 0;
        transform: translateY(20px);
        animation-name: fadeSlideUp;
        animation-duration: 0.6s;
        animation-fill-mode: forwards;
        animation-timing-function: ease;
    }

    @keyframes fadeSlideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    a.flex-1 {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    a.flex-1:hover {
        transform: scale(1.07) rotate(-2deg);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    }

    .confetti-canvas {
        position: fixed !important;
        pointer-events: none !important;
        top: 0;
        left: 0;
        width: 100vw !important;
        height: 100vh !important;
        opacity: 0;
        animation: fadeInOut 4s ease forwards;
        z-index: 9999; /* <- TOPI DI DEPAN */
    }

    @keyframes fadeInOut {
        0% {opacity: 0;}
        20% {opacity: 1;}
        80% {opacity: 1;}
        100% {opacity: 0;}
    }
</style>


<body class="bg-gray-800 flex items-center justify-center min-h-screen p-4">
    <canvas id="capCanvas" class="confetti-canvas"></canvas>
    <div class="bg-gray-900 text-white rounded-lg shadow-lg overflow-hidden w-full max-w-2xl fade-slide-up" id="mainContainer">
        <div class="bg-gradient-to-r from-blue-900 to-blue-500 shadow-lg p-6 flex flex-row justify-between items-center fade-slide-up-child">
            <div class="text-left flex-1">
                <h1 class="text-xl md:text-2xl font-bold fade-slide-up-child">ANDA DINYATAKAN LULUS <br> TAHUN <?= date('Y'); ?></h1>
                <p class="mt-2 text-sm md:text-base fade-slide-up-child"> <?= html_entity_decode($siswa['pesan'], ENT_QUOTES, 'UTF-8'); ?> </p>
            </div>
            <img alt="Logo Sekolah" src="<?= base_url('assets/img/logo.png'); ?>" class="w-24 h-auto ml-4 fade-slide-up-child" />
        </div>
        <div class="p-6">
    <p class="text-blue-500 fade-slide-up-child">
        NISN : <span><?= htmlspecialchars($siswa['nisn'], ENT_QUOTES, 'UTF-8'); ?> 
        <span>NIS : <?= htmlspecialchars($siswa['nisn'], ENT_QUOTES, 'UTF-8'); ?></span></span>
    </p>
    <h2 class="text-2xl md:text-3xl font-bold mt-2 fade-slide-up-child">
        <span><?= strtoupper(htmlspecialchars($siswa['nama'], ENT_QUOTES, 'UTF-8')); ?></span>
    </h2>
    <p class="mt-1 fade-slide-up-child"> <?= htmlspecialchars($siswa['kelas'], ENT_QUOTES, 'UTF-8'); ?> </p>
    
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- 1. Tanggal Lahir -->
    <div class="fade-slide-up-child">
        <p class="text-blue-400">Tanggal Lahir</p>
        <p class="mt-1"><?= htmlspecialchars($siswa['tanggal_lahir'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <!-- 2. Nama Sekolah -->
    <div class="fade-slide-up-child">
        <p class="text-blue-400">Nama Sekolah</p>
        <p class="mt-1"><?= strtoupper(htmlspecialchars($sekolah['nama_sekolah'], ENT_QUOTES, 'UTF-8')); ?></p>
    </div>

    <!-- 3. Kabupaten/Kota -->
    <div class="fade-slide-up-child">
        <p class="text-blue-400">Kabupaten/Kota</p>
        <p class="mt-1"><?= isset($sekolah['kota']) ? strtoupper(htmlspecialchars($sekolah['kota'], ENT_QUOTES, 'UTF-8')) : 'Tidak tersedia'; ?></p>
    </div>

    <!-- 4. Provinsi -->
    <div class="fade-slide-up-child">
        <p class="text-blue-400">Provinsi</p>
        <p class="mt-1"><?= strtoupper(htmlspecialchars($sekolah['provinsi'], ENT_QUOTES, 'UTF-8')); ?></p>
    </div>

    <!-- 5. NPSN -->
    <div class="fade-slide-up-child">
        <p class="text-blue-400">NPSN</p>
        <p class="mt-1"><?= htmlspecialchars($sekolah['npsn'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <!-- 6. Alamat Sekolah -->
    <div class="fade-slide-up-child">
        <p class="text-blue-400">Alamat Sekolah</p>
        <p class="mt-1"><?= htmlspecialchars($sekolah['alamat'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</div><br>


            <p class="mt-2 text-sm md:text-base bg-red-500 text-white p-2 fade-slide-up-child">
                <b><i>NOTE : PASTIKAN DATA DI SKL SUDAH SESUAI , JIKA ADA TIDAK KESESUAIAN DATA WAJIB KE SEKOLAH DAN KE BAGIAN TATA USAHA.</i></b>
            </p>

            <div class="mt-10 flex flex-col md:flex-row gap-6 justify-center items-center w-full">
            <?php
                $show_button = false;
                if (!empty($siswa['link_google_drive'])) {
                    $link_google_drive = $siswa['link_google_drive'];
                    if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $link_google_drive, $matches)) {
                        $file_id = $matches[1];
                        $download_url = "https://drive.google.com/uc?export=download&id=" . $file_id;
                        $show_button = true;
                    }
                }
            ?>

            <?php if ($show_button): ?>
                <a id="downloadBtn"
                    href="<?= htmlspecialchars($download_url, ENT_QUOTES, 'UTF-8'); ?>"
                    class="flex-1 px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition transform hover:scale-105 shadow-lg text-center fade-slide-up-child"
                    onclick="handleDownload(event)">
                    📄 <span id="downloadText">Download Document SKL</span>
                </a>
            <?php else: ?>
                <p class="text-red-500 font-semibold fade-slide-up-child">📄 Dokumen SKL belum tersedia.</p>
            <?php endif; ?>

                <a id="countdownButton" href="<?= site_url('dashboard'); ?>"
                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition transform hover:scale-105 text-center fade-slide-up-child">
                    ⬅ Kembali ke Home (<span id="countdown">10:00</span>)
                </a>
            </div>

            
            <footer class="text-center mt-6 text-white text-sm p-4 fade-slide-up-child">
                <?php $this->load->view('layouts/footer'); ?>
            </footer>
        </div>
    </div>

    <!-- Audio musik latar, tanpa autoplay di tag -->
    <audio id="bgMusic" src="<?= base_url('assets/audio/music.mp3'); ?>"></audio>
<audio id="clickSound" src="<?= base_url('assets/audio/click.mp3'); ?>"></audio>

<!-- Confetti -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>


<script>
    // --- Countdown dengan redirect setelah selesai ---
    const countdownElement = document.getElementById("countdown");
    const totalCountdown = 300; // 5 menit dalam detik (kamu tulis 10 menit tapi 300 detik adalah 5 menit)
    const redirectURL = "<?= site_url('dashboard'); ?>";

    function startCountdown() {
        let startTime = sessionStorage.getItem("countdownStartTime");
        const currentTime = Math.floor(Date.now() / 1000);

        if (!startTime) {
            startTime = currentTime;
            sessionStorage.setItem("countdownStartTime", startTime);
        }

        let elapsedTime = currentTime - startTime;
        let remainingTime = totalCountdown - elapsedTime;

        if (remainingTime <= 0) {
            sessionStorage.removeItem("countdownStartTime");
            window.location.href = redirectURL;
            return;
        }

        updateCountdown(remainingTime);
    }

    function updateCountdown(remainingTime) {
        function tick() {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            if (remainingTime > 0) {
                setTimeout(() => {
                    remainingTime--;
                    tick();
                }, 1000);
            } else {
                sessionStorage.removeItem("countdownStartTime");
                window.location.href = redirectURL;
            }
        }
        tick();
    }

    window.onload = startCountdown;
</script>

<script>
    // --- Delay download button dengan cooldown ---
    let delaySeconds = 20;
    let isCooldown = false;

    function handleDownload(event) {
        if (isCooldown) {
            event.preventDefault();
            return;
        }

        isCooldown = true;
        const btn = document.getElementById("downloadBtn");
        const text = document.getElementById("downloadText");

        let countdown = delaySeconds;
        text.textContent = `Jika Ingin Download Kembali Tunggu ${countdown}s...`;

        btn.classList.add('pointer-events-none', 'bg-gray-400');
        btn.classList.remove('bg-green-500', 'hover:bg-green-600');

        const interval = setInterval(() => {
            countdown--;
            text.textContent = `Jika Ingin Download Kembali Tunggu ${countdown}s...`;

            if (countdown <= 0) {
                clearInterval(interval);
                isCooldown = false;
                text.textContent = "Download Document SKL";
                btn.classList.remove('pointer-events-none', 'bg-gray-400');
                btn.classList.add('bg-green-500', 'hover:bg-green-600');
            }
        }, 1000);
    }
</script>
<script>
window.addEventListener('load', () => {
    // --- Confetti animation ---
    const duration = 4000;
    const end = Date.now() + duration;

    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    (function frame() {
        confetti({
            particleCount: 5,
            angle: randomInRange(55, 125),
            spread: randomInRange(50, 70),
            origin: { x: Math.random(), y: Math.random() * 0.6 },
            colors: ['#3b82f6', '#2563eb', '#60a5fa', '#1e40af']
        });

        if (Date.now() < end) {
            requestAnimationFrame(frame);
        }
    })();

    // Tambahkan class animasi fadeInOut ke canvas confetti
    const confettiCanvas = document.querySelector('canvas');
    if (confettiCanvas) {
        confettiCanvas.classList.add('confetti-canvas');
    }

    // --- Audio autoplay with user interaction ---
    const music = document.getElementById('bgMusic');
    if (music) {
        music.volume = 0.3;
        music.loop = true;

        const isAudioPlaying = localStorage.getItem('bgMusicPlaying') === 'true';

        // Fungsi untuk play musik dan set localStorage jika berhasil
        function playMusic() {
            music.play().then(() => {
                localStorage.setItem('bgMusicPlaying', 'true');
            }).catch(() => {
                // Autoplay gagal, jangan set localStorage
            });
        }

        // Tunggu klik user untuk memulai musik (hanya sekali)
        document.body.addEventListener('click', playMusic, { once: true });

        // Update localStorage saat musik dijeda atau selesai
        music.addEventListener('pause', () => {
            localStorage.setItem('bgMusicPlaying', 'false');
        });
        music.addEventListener('ended', () => {
            localStorage.setItem('bgMusicPlaying', 'false');
        });
    }

    // --- Event play suara klik tombol ---
    const playClickSound = () => {
        const clickSound = document.getElementById('clickSound');
        if (clickSound) clickSound.play();
    };

    ['countdownButton', 'downloadBtn'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.addEventListener('click', playClickSound);
    });
});

// --- Animasi delay berurutan untuk elemen dengan class fade-slide-up-child ---
document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".fade-slide-up-child");
    elements.forEach((el, index) => {
        el.style.animationDelay = `${0.3 + index * 0.15}s`; // mulai delay 0.3s, bertambah 0.15s tiap elemen
        el.style.animationPlayState = "running";
    });

    // Animasi utama container (optional)
    const main = document.querySelector(".fade-slide-up");
    if (main) {
        main.style.animationPlayState = "running";
    }
});
</script>
<script>
    const canvas = document.getElementById('capCanvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const caps = [];
    const capImage = new Image();
    capImage.src = '<?= base_url('assets/img/cap.png'); ?>'; // Pastikan file ada

    for (let i = 0; i < 30; i++) {
        caps.push({
            x: Math.random() * canvas.width,
            y: Math.random() * -canvas.height,
            speed: 1 + Math.random() * 2,
            size: 30 + Math.random() * 20,
            rotation: Math.random() * 360,
            rotationSpeed: Math.random() * 2 - 1
        });
    }

    function animateCaps() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        caps.forEach(cap => {
            ctx.save();
            ctx.translate(cap.x, cap.y);
            ctx.rotate(cap.rotation * Math.PI / 180);
            ctx.drawImage(capImage, -cap.size / 2, -cap.size / 2, cap.size, cap.size);
            ctx.restore();

            cap.y += cap.speed;
            cap.rotation += cap.rotationSpeed;

            if (cap.y > canvas.height + 50) {
                cap.y = -50;
                cap.x = Math.random() * canvas.width;
            }
        });
        requestAnimationFrame(animateCaps);
    }

    capImage.onload = () => {
        canvas.style.opacity = 1;
        animateCaps();
        setTimeout(() => {
            canvas.style.opacity = 0;
        }, 4000);
    };
</script>
</body>
</html>
