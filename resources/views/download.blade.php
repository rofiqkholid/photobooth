<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unduh Foto Photobooth Anda - MoSafe</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    
    <style>
        body {
            font-family: 'Outfit', sans-serif !important;
        }
    </style>
</head>
<body class="min-h-full bg-gradient-to-br from-slate-50 via-sky-50/30 to-indigo-50/40 text-slate-800 flex flex-col justify-between relative overflow-x-hidden">
    
    <!-- Ambient Glow Blobs -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-0 left-0 -translate-x-1/4 -translate-y-1/4 w-[40vw] h-[40vw] bg-sky-200/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 translate-x-1/4 translate-y-1/4 w-[45vw] h-[45vw] bg-pink-100/30 rounded-full blur-[120px]"></div>
    </div>

    <!-- Header -->
    <header class="px-6 py-5 md:px-12 flex justify-between items-center border-b border-slate-200/60 bg-white/40 backdrop-blur-md z-10 relative">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo/mosafe-logo.png') }}" alt="MoSafe Logo" class="h-8 md:h-10 w-auto object-contain">
            <span class="text-xl md:text-2xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-600">Photobooth</span>
        </div>
    </header>

    <!-- Main Content Stage -->
    <main class="flex-1 flex flex-col items-center justify-center p-4 md:p-8 z-10 relative max-w-4xl mx-auto w-full">
        
        <canvas id="confetti-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

        <div class="w-full bg-white/70 backdrop-blur-xl border border-white/80 p-6 md:p-10 flex flex-col-reverse md:flex-row items-center justify-center gap-8 shadow-2xl relative z-10">
            
            <!-- Left Side: Photo Preview Mockup -->
            <div class="w-full md:w-1/2 flex justify-center">
                <div class="relative max-w-[280px] md:max-w-[320px] bg-white p-3 shadow-[0_15px_30px_-5px_rgba(0,0,0,0.15)] border border-slate-100 hover:rotate-1 transition-transform duration-300">
                    <img src="{{ $imageUrl }}" alt="Photobooth Strip" class="w-full h-auto max-h-[70vh] object-contain border border-slate-200/50">
                    <div class="text-center pt-3 pb-1">
                        <span class="text-[12px] text-slate-400 font-medium tracking-widest">MoSafe Memory</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Download & Action Cards -->
            <div class="w-full md:w-1/2 flex flex-col text-center md:text-left gap-6">
                <div>
                    <span class="text-md font-extrabold tracking-wider text-pink-500">Yeay! Foto Kamu Siap</span>
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 mt-1 mb-2 bg-gradient-to-r from-slate-950 to-slate-700 bg-clip-text text-transparent">Simpan Kenangan Indahmu!</h2>
                    <p class="text-sm text-slate-500 leading-relaxed">Terima kasih telah berpartisipasi di MoSafe Photobooth. Klik tombol di bawah ini untuk menyimpan file foto strip dengan kualitas penuh ke perangkat Anda.</p>
                </div>

                <div class="flex flex-col gap-3">
                    <a href="{{ route('photo.download-file', ['filename' => $filename]) }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold text-base px-6 py-4 transition-all shadow-lg hover:shadow-pink-500/25 cursor-pointer">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Unduh Foto Sekarang (JPG)
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-400 border-t border-slate-200/50 bg-white/20 backdrop-blur-sm z-10 relative">
        Dibuat khusus untuk <a href="#" class="text-sky-500 hover:underline font-semibold">MoSafe</a> &copy; {{ date('Y') }}. Seluruh hak cipta dilindungi.
    </footer>

    <!-- Confetti Particle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvasConfetti = document.getElementById('confetti-canvas');
            const ctxConfetti = canvasConfetti.getContext('2d');
            let confettiParticles = [];
            let confettiInterval = null;

            function resizeConfettiCanvas() {
                canvasConfetti.width = window.innerWidth;
                canvasConfetti.height = window.innerHeight;
            }

            window.addEventListener('resize', resizeConfettiCanvas);

            function startConfetti() {
                resizeConfettiCanvas();
                const colors = ['#38bdf8', '#818cf8', '#ec4899', '#db2777', '#10b981', '#fbbf24'];
                
                for (let i = 0; i < 100; i++) {
                    confettiParticles.push({
                        x: Math.random() * canvasConfetti.width,
                        y: Math.random() * canvasConfetti.height - canvasConfetti.height,
                        r: Math.random() * 5 + 3,
                        d: Math.random() * canvasConfetti.height,
                        color: colors[Math.floor(Math.random() * colors.length)],
                        tilt: Math.random() * 10 - 5,
                        tiltAngleIncremental: Math.random() * 0.07 + 0.02,
                        tiltAngle: 0
                    });
                }

                function drawConfetti() {
                    ctxConfetti.clearRect(0, 0, canvasConfetti.width, canvasConfetti.height);
                    
                    confettiParticles.forEach((p, index) => {
                        p.tiltAngle += p.tiltAngleIncremental;
                        p.y += (Math.cos(p.d) + 3 + p.r / 2) / 2.5;
                        p.x += Math.sin(p.tiltAngle);
                        p.tilt = Math.sin(p.tiltAngle - (index / 3)) * 12;

                        ctxConfetti.beginPath();
                        ctxConfetti.lineWidth = p.r;
                        ctxConfetti.strokeStyle = p.color;
                        ctxConfetti.moveTo(p.x + p.tilt + p.r / 2, p.y);
                        ctxConfetti.lineTo(p.x + p.tilt, p.y + p.tilt + p.r / 2);
                        ctxConfetti.stroke();

                        if (p.y > canvasConfetti.height) {
                            confettiParticles[index] = {
                                x: Math.random() * canvasConfetti.width,
                                y: -20,
                                r: p.r,
                                d: p.d,
                                color: p.color,
                                tilt: p.tilt,
                                tiltAngleIncremental: p.tiltAngleIncremental,
                                tiltAngle: p.tiltAngle
                            };
                        }
                    });
                }

                confettiInterval = setInterval(drawConfetti, 1000 / 60);
                
                // Stop confetti after 5 seconds to preserve battery/CPU
                setTimeout(() => {
                    clearInterval(confettiInterval);
                    ctxConfetti.clearRect(0, 0, canvasConfetti.width, canvasConfetti.height);
                }, 5000);
            }

            startConfetti();
        });
    </script>
</body>
</html>
