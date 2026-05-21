@extends('layouts.app')

@section('content')
<canvas id="confetti-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-1"></canvas>

<div class="w-full max-w-4xl lg:max-w-5xl xl:max-w-6xl transition-all duration-500">
    <!-- Include all photobooth screen steps -->
    @include('components.screen-email')
    @include('components.screen-frame')
    @include('components.screen-capture')
    @include('components.screen-sending')
    @include('components.screen-success')
</div>
@endsection

@push('scripts')
<script>
    // Configuration
    const config = {
        frameTemplates: {
            frame1: {
                src: '/bingkai/1.png',
                slots: [
                    { x: 345, y: 500, w: 1285, h: 835 },
                    { x: 530, y: 1430, w: 1285, h: 840 },
                    { x: 395, y: 2420, w: 1285, h: 840 }
                ]
            },
            frame2: {
                src: '/bingkai/2.png',
                slots: [
                    { x: 454, y: 709, w: 1213, h: 1216 },
                    { x: 454, y: 1974, w: 1213, h: 1215 }
                ]
            }
        }
    };

    // App State
    let userEmail = '';
    let selectedFrameId = 'frame1';
    let capturedPhotos = [];
    let webcamStream = null;
    let countdownTimer = null;
    let autoRestartTimer = null;

    // Dom Elements
    const screens = {
        email: document.getElementById('screen-email'),
        frame: document.getElementById('screen-frame'),
        capture: document.getElementById('screen-capture'),
        sending: document.getElementById('screen-sending'),
        success: document.getElementById('screen-success')
    };

    const inputEmail = document.getElementById('guest-email');
    const frameOverlay = document.getElementById('active-frame-overlay');
    const webcam = document.getElementById('webcam');
    const countdownOverlay = document.getElementById('countdown-overlay');
    const countdownNumber = document.getElementById('countdown-number');
    const flashOverlay = document.getElementById('flash-overlay');
    const sendingStatusText = document.getElementById('sending-status-text');
    const successEmailText = document.getElementById('success-email-text');
    const restartSecondsSpan = document.getElementById('restart-seconds');

    // Navigation helpers
    function showScreen(screenKey) {
        Object.keys(screens).forEach(key => {
            if (key === screenKey) {
                screens[key].classList.add('active');
            } else {
                screens[key].classList.remove('active');
            }
        });
    }

    // Screen 1: Email handler
    document.getElementById('btn-submit-email').addEventListener('click', () => {
        const email = inputEmail.value.trim();
        if (!email || !validateEmail(email)) {
            alert('Silakan masukkan alamat email yang valid.');
            inputEmail.focus();
            return;
        }
        userEmail = email;
        showScreen('frame');
    });

    // Email validation helper
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Screen 2: Frame Selectors
    document.querySelectorAll('.frame-card').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.frame-card').forEach(c => {
                c.classList.remove('border-sky-500', 'bg-sky-50/50', 'ring-2', 'ring-sky-500/10');
                c.classList.add('border-slate-200');
            });
            card.classList.add('border-sky-500', 'bg-sky-50/50', 'ring-2', 'ring-sky-500/10');
            card.classList.remove('border-slate-200');
            selectedFrameId = card.dataset.frameId;
        });
    });

    document.getElementById('btn-back-to-email').addEventListener('click', () => {
        showScreen('email');
    });

    document.getElementById('btn-confirm-frame').addEventListener('click', async () => {
        // Clear background image on camera screen so the feed is clean
        frameOverlay.style.backgroundImage = '';
        
        // Update instruction text with dynamic photo count
        const activeFrame = config.frameTemplates[selectedFrameId];
        const numPhotos = activeFrame.slots.length;
        document.getElementById('photo-count-text').textContent = numPhotos + ' foto';
        
        showScreen('capture');
        await startWebcam();
    });

    async function startWebcam() {
        try {
            // Request camera permission
            const constraints = {
                video: {
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                    facingMode: 'user'
                },
                audio: false
            };
            
            webcamStream = await navigator.mediaDevices.getUserMedia(constraints);
            webcam.srcObject = webcamStream;
            webcam.play();
            
            // Reset capture parameters
            capturedPhotos = [];
            resetThumbnails();
            document.getElementById('btn-start-photoshoot').disabled = false;
            document.getElementById('btn-start-photoshoot').textContent = 'Jepret Sekarang!';
            document.getElementById('btn-cancel-capture').disabled = false;
        } catch (err) {
            console.error('Error accessing webcam:', err);
            alert('Gagal mengakses kamera Anda. Harap berikan izin akses kamera di browser Anda.');
            showScreen('frame');
        }
    }

    function stopWebcam() {
        if (webcamStream) {
            webcamStream.getTracks().forEach(track => track.stop());
            webcamStream = null;
        }
    }

    function resetThumbnails() {
        const activeFrame = config.frameTemplates[selectedFrameId];
        const numPhotos = activeFrame.slots.length;
        
        for (let i = 0; i < 3; i++) {
            const thumb = document.getElementById('thumb-' + i);
            if (i >= numPhotos) {
                thumb.style.display = 'none';
                continue;
            } else {
                thumb.style.display = '';
            }
            
            thumb.className = 'w-24 h-18 lg:w-28 lg:h-21 rounded-none bg-white border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center relative shadow-sm transition-all duration-300 thumb';
            const img = thumb.querySelector('img');
            if (img) img.remove();
            
            // Add back the number
            let badge = thumb.querySelector('span');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'absolute bottom-1 right-2 bg-black/60 text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-none';
                badge.textContent = i + 1;
                thumb.appendChild(badge);
            }
        }
    }

    document.getElementById('btn-cancel-capture').addEventListener('click', () => {
        stopWebcam();
        showScreen('frame');
    });

    // Web Audio Camera Shutter Synth Sound
    function playShutterSound() {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            
            // Create shutter noise buffer
            const bufferSize = audioCtx.sampleRate * 0.12; // ~120ms
            const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
            const data = buffer.getChannelData(0);
            for (let i = 0; i < bufferSize; i++) {
                data[i] = Math.random() * 2 - 1;
            }

            const noise = audioCtx.createBufferSource();
            noise.buffer = buffer;

            const filter = audioCtx.createBiquadFilter();
            filter.type = 'bandpass';
            filter.frequency.value = 1200;
            filter.Q.value = 3;

            const gain = audioCtx.createGain();
            gain.gain.setValueAtTime(0.6, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);

            noise.connect(filter);
            filter.connect(gain);
            gain.connect(audioCtx.destination);

            // Quick beeping focus tone
            const osc = audioCtx.createOscillator();
            const oscGain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(900, audioCtx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(400, audioCtx.currentTime + 0.06);
            oscGain.gain.setValueAtTime(0.2, audioCtx.currentTime);
            oscGain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.06);

            osc.connect(oscGain);
            oscGain.connect(audioCtx.destination);

            noise.start();
            osc.start();
            
            noise.stop(audioCtx.currentTime + 0.12);
            osc.stop(audioCtx.currentTime + 0.06);
        } catch (e) {
            console.warn("Audio shutter context failed to play", e);
        }
    }

    // Action trigger: Start the photoshoot 3-shot sequence
    document.getElementById('btn-start-photoshoot').addEventListener('click', () => {
        document.getElementById('btn-start-photoshoot').disabled = true;
        document.getElementById('btn-start-photoshoot').textContent = 'Sedang Berjalan...';
        document.getElementById('btn-cancel-capture').disabled = true;
        
        runPhotoshootSequence();
    });

    // Sequential photo shooter
    async function runPhotoshootSequence() {
        const activeFrame = config.frameTemplates[selectedFrameId];
        const numPhotos = activeFrame.slots.length;
        
        for (let i = 0; i < numPhotos; i++) {
            // Countdown phase: 10 seconds for each photo
            const countdownTime = 10;
            await runCountdown(countdownTime);
            
            // Capture phase
            triggerFlashEffect();
            playShutterSound();
            captureSnapshot(i);
            
            // Brief pause to let user see flash/thumbnail update before starting next countdown
            if (i < numPhotos - 1) {
                await delay(1000);
            }
        }
        
        // All photos captured successfully
        stopWebcam();
        showScreen('sending');
        generateAndSendComposite();
    }

    function runCountdown(seconds) {
        return new Promise((resolve) => {
            countdownOverlay.style.display = 'flex';
            let count = seconds;
            countdownNumber.textContent = count;
            
            countdownTimer = setInterval(() => {
                count--;
                if (count <= 0) {
                    clearInterval(countdownTimer);
                    countdownOverlay.style.display = 'none';
                    resolve();
                } else {
                    countdownNumber.textContent = count;
                }
            }, 1000); // 1-second interval for real-time countdown
        });
    }

    function triggerFlashEffect() {
        flashOverlay.classList.add('opacity-100');
        setTimeout(() => {
            flashOverlay.classList.remove('opacity-100');
        }, 150);
    }

    function captureSnapshot(index) {
        const captureCanvas = document.createElement('canvas');
        captureCanvas.width = webcam.videoWidth || 640;
        captureCanvas.height = webcam.videoHeight || 480;
        const captureCtx = captureCanvas.getContext('2d');
        
        // Draw mirrored image on temp capture canvas (so left stays left like the mirror feedback)
        captureCtx.translate(captureCanvas.width, 0);
        captureCtx.scale(-1, 1);
        captureCtx.drawImage(webcam, 0, 0, captureCanvas.width, captureCanvas.height);
        
        const dataUrl = captureCanvas.toDataURL('image/jpeg', 0.95);
        capturedPhotos.push(dataUrl);

        // Update UI thumbnail
        const thumb = document.getElementById('thumb-' + index);
        thumb.classList.add('border-solid', 'border-sky-500', 'ring-4', 'ring-sky-100');
        thumb.classList.remove('border-dashed', 'border-slate-300');
        
        const img = document.createElement('img');
        img.src = dataUrl;
        img.className = 'w-full h-full object-cover rounded-none';
        thumb.appendChild(img);
    }

    const delay = (ms) => new Promise(res => setTimeout(res, ms));

    // Object cover image helper for HTML Canvas (avoids stretching images)
    function drawImageProp(ctx, img, x, y, w, h, offsetX = 0.5, offsetY = 0.5) {
        const iw = img.width || img.videoWidth;
        const ih = img.height || img.videoHeight;
        const r = Math.min(w / iw, h / ih);
        let nw = iw * r;
        let nh = ih * r;
        let cx, cy, cw, ch, ar = 1;

        if (nw < w) ar = w / nw;
        if (Math.abs(nh - h) < 0.0001 && nw < w) ar = w / nw;
        if (nh < h) ar = h / nh;
        
        nw *= ar;
        nh *= ar;

        cw = iw / (nw / w);
        ch = ih / (nh / h);

        cx = (iw - cw) * offsetX;
        cy = (ih - ch) * offsetY;

        if (cx < 0) cx = 0;
        if (cy < 0) cy = 0;
        if (cw > iw) cw = iw;
        if (ch > ih) ch = ih;

        ctx.drawImage(img, cx, cy, cw, ch, x, y, w, h);
    }

    const loadImage = (src) => new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = reject;
        img.src = src;
    });

    // Assemble 3 photos into a styled strip canvas and send payload
    async function generateAndSendComposite() {
        sendingStatusText.textContent = "Sedang menyatukan lembar kenangan foto Anda...";
        
        try {
            // Dimensions of high-res photobooth strip matching the new frames (2160 x 3840)
            const canvas = document.createElement('canvas');
            canvas.width = 2160;
            canvas.height = 3840;
            const ctx = canvas.getContext('2d');
            
            const activeFrame = config.frameTemplates[selectedFrameId];
            
            // Wait for all images to load (the 3 photos and the frame template PNG)
            const [loadedImages, frameImg] = await Promise.all([
                Promise.all(capturedPhotos.map(src => loadImage(src))),
                loadImage(activeFrame.src)
            ]);
            
            // 1. Draw Photos under the frame
            for (let i = 0; i < activeFrame.slots.length; i++) {
                const img = loadedImages[i];
                const slot = activeFrame.slots[i];
                drawImageProp(ctx, img, slot.x, slot.y, slot.w, slot.h);
            }
            
            // 2. Draw Frame template PNG on top (this overlays the frames/borders/text beautifully)
            ctx.drawImage(frameImg, 0, 0, canvas.width, canvas.height);
            
            // Get JPEG base64 string
            const compositeDataUrl = canvas.toDataURL('image/jpeg', 0.9);
            
            // 3. Submit to backend
            sendingStatusText.textContent = "Mengunggah foto dan mengirim ke email: " + userEmail + "...";
            
            const response = await fetch('/send-photo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: userEmail,
                    image: compositeDataUrl
                })
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                successEmailText.innerHTML = `Foto strip photobooth Anda yang keren telah dikirim ke email <strong>${userEmail}</strong>. Harap periksa folder kotak masuk atau spam dalam beberapa menit!`;
                showScreen('success');
                startConfetti();
                startAutoRestartTimer(15);
            } else {
                throw new Error(data.message || 'Gagal mengirim email.');
            }
            
        } catch (err) {
            console.error(err);
            alert("Kesalahan pengiriman: " + err.message);
            showScreen('capture');
            // Re-enable capture screen controls
            document.getElementById('btn-start-photoshoot').disabled = false;
            document.getElementById('btn-start-photoshoot').textContent = 'Jepret Sekarang!';
            document.getElementById('btn-cancel-capture').disabled = false;
            startWebcam(); // Restart webcam feed
        }
    }

    // Restart flow handlers
    document.getElementById('btn-restart').addEventListener('click', () => {
        resetToStart();
    });

    function resetToStart() {
        stopAutoRestartTimer();
        stopConfetti();
        
        // Clean values
        inputEmail.value = '';
        userEmail = '';
        capturedPhotos = [];
        
        // Go back
        showScreen('email');
    }

    function startAutoRestartTimer(seconds) {
        let timeLeft = seconds;
        restartSecondsSpan.textContent = timeLeft;
        
        autoRestartTimer = setInterval(() => {
            timeLeft--;
            restartSecondsSpan.textContent = timeLeft;
            if (timeLeft <= 0) {
                resetToStart();
            }
        }, 1000);
    }

    function stopAutoRestartTimer() {
        if (autoRestartTimer) {
            clearInterval(autoRestartTimer);
            autoRestartTimer = null;
        }
    }

    // Success Celebration Confetti Particle Engine
    let confettiInterval = null;
    let confettiParticles = [];
    const canvasConfetti = document.getElementById('confetti-canvas');
    const ctxConfetti = canvasConfetti.getContext('2d');

    function resizeConfettiCanvas() {
        canvasConfetti.width = window.innerWidth;
        canvasConfetti.height = window.innerHeight;
    }

    window.addEventListener('resize', resizeConfettiCanvas);

    function startConfetti() {
        resizeConfettiCanvas();
        confettiParticles = [];
        const colors = ['#38bdf8', '#818cf8', '#ec4899', '#db2777', '#10b981', '#fbbf24'];
        
        // Initialize particles
        for (let i = 0; i < 150; i++) {
            confettiParticles.push({
                x: Math.random() * canvasConfetti.width,
                y: Math.random() * canvasConfetti.height - canvasConfetti.height,
                r: Math.random() * 6 + 4,
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
                p.y += (Math.cos(p.d) + 3 + p.r / 2) / 2;
                p.x += Math.sin(p.tiltAngle);
                p.tilt = Math.sin(p.tiltAngle - (index / 3)) * 15;

                ctxConfetti.beginPath();
                ctxConfetti.lineWidth = p.r;
                ctxConfetti.strokeStyle = p.color;
                ctxConfetti.moveTo(p.x + p.tilt + p.r / 2, p.y);
                ctxConfetti.lineTo(p.x + p.tilt, p.y + p.tilt + p.r / 2);
                ctxConfetti.stroke();

                // Recycle particles falling off bottom
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
    }

    function stopConfetti() {
        if (confettiInterval) {
            clearInterval(confettiInterval);
            confettiInterval = null;
        }
        ctxConfetti.clearRect(0, 0, canvasConfetti.width, canvasConfetti.height);
        confettiParticles = [];
    }
</script>
@endpush
