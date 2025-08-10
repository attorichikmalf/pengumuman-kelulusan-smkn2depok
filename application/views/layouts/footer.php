<?php
if (!function_exists('footer_verified')) {
    function footer_verified() {
        return true;
    }
}
?>
<style>
    #footer-credit {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 1rem 0;
        color: white;
        text-align: center;
    }

    #footer-credit a {
        color: #60a5fa; /* Tailwind blue-400 */
        text-decoration: none;
        transition: color 0.3s ease;
    }

    #footer-credit a:hover {
        color: #93c5fd; /* Tailwind blue-300 */
        text-decoration: underline;
    }

    #footer-credit p {
        margin: 0.25rem 0;
    }
</style>

<footer id="footer-credit" class="footer bg-dark text-white text-center animate-fadeInUp py-1">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <p class="mb-0">
            <?= date('Y'); ?> - V5.5 | 
            Created and Developed by 
            <a href="https://www.instagram.com/attoricq_hf/" target="_blank" rel="noopener noreferrer" 
               class="text-blue-400 hover:underline hover:text-blue-300 transition inline-flex items-center gap-1">
               Attoric Hikmal 
            </a> | 
            &copy; <?= isset($sekolah['nama_sekolah']) 
                ? strtoupper(htmlspecialchars($sekolah['nama_sekolah'], ENT_QUOTES, 'UTF-8')) 
                : 'NAMA SEKOLAH'; ?>
        </p>
    </div>
</footer>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const footer = document.getElementById("footer-credit");
    const showLockScreen = (message) => {
        const warning = document.createElement("div");
        warning.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(to bottom, #7f1d1d, #b91c1c);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 2rem;
            z-index: 99999;
            animation: shake 0.6s infinite;
        `;
        warning.innerHTML = message;
        document.body.innerHTML = ''; // clear existing content
        document.body.appendChild(warning);
    };

    const requiredHTML = `Created and Developed by <a href="https://www.instagram.com/attoricq_hf/" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:underline hover:text-blue-300 transition inline-flex items-center gap-1"> Attoric Hikmal </a>`.replace(/\s+/g, '');
    const actualHTML = footer?.innerHTML.replace(/\s+/g, '') || '';

    if (!footer) {
        showLockScreen("⚠️ Footer dihapus. Sistem dikunci.");
        return;
    }

    if (!actualHTML.includes(requiredHTML)) {
        showLockScreen("⚠️ Footer telah diubah atau ditambah. Sistem dikunci.");
        return;
    }

    const style = window.getComputedStyle(footer);
    if (style.display === "none" || style.visibility === "hidden" || footer.offsetHeight === 0) {
        showLockScreen("⚠️ Footer disembunyikan. Sistem dikunci.");
        return;
    }

    // Animasi CSS
    const styleElement = document.createElement('style');
    styleElement.textContent = `
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            50% { transform: translateX(10px); }
            75% { transform: translateX(-10px); }
            100% { transform: translateX(0); }
        }
    `;
    document.head.appendChild(styleElement);
});
</script>

