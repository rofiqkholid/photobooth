<!-- SCREEN 3: CAMERA CAPTURE -->
<div class="glass-card w-full bg-white/70 backdrop-blur-xl border border-white/80 rounded-none p-8 md:p-12 flex flex-col items-center text-center transition-all duration-500" id="screen-capture">
    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 mb-2 bg-gradient-to-r from-slate-950 to-slate-700 bg-clip-text text-transparent">Pose Terbaikmu!</h2>
    <p class="text-base text-slate-500 mb-6 max-w-md">Siapkan senyum terbaikmu! Kita akan mengambil <strong class="text-sky-500">3 foto</strong> berturut-turut dengan jeda waktu 10 detik.</p>
    
    <!-- Flex Container for Side-by-Side Layout on large screens -->
    <div class="flex flex-col lg:flex-row items-center justify-between gap-6 w-full mt-4">
        
        <!-- Left Side: Captured Thumbnail List (Vertical on Desktop, Horizontal on Mobile) -->
        <div class="flex flex-row lg:flex-col gap-4 justify-center items-center order-2 lg:order-1 lg:w-32">
            <div class="w-24 h-18 lg:w-28 lg:h-21 rounded-none bg-white border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center relative transition-all duration-300 thumb" id="thumb-0">
                <span class="absolute bottom-1 right-2 bg-black/60 text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-none animate-none">1</span>
            </div>
            <div class="w-24 h-18 lg:w-28 lg:h-21 rounded-none bg-white border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center relative transition-all duration-300 thumb" id="thumb-1">
                <span class="absolute bottom-1 right-2 bg-black/60 text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-none animate-none">2</span>
            </div>
            <div class="w-24 h-18 lg:w-28 lg:h-21 rounded-none bg-white border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center relative transition-all duration-300 thumb" id="thumb-2">
                <span class="absolute bottom-1 right-2 bg-black/60 text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-none animate-none">3</span>
            </div>
        </div>

        <!-- Center: Large Camera Viewport -->
        <div class="relative w-full max-w-2xl aspect-[4/3] bg-slate-950 border-4 border-white rounded-none overflow-hidden order-1 lg:order-2 flex-1">
            <video id="webcam" autoplay playsinline class="w-full h-full object-cover transform scale-x-[-1]"></video>
            
            <!-- Frame Overlay -->
            <div class="frame-overlay" id="active-frame-overlay"></div>
            
            <!-- Countdown Display -->
            <div class="absolute inset-0 bg-slate-950/40 items-center justify-center z-40" id="countdown-overlay" style="display: none;">
                <span class="text-9xl font-black text-white" id="countdown-number">10</span>
            </div>
            
            <!-- Flash Effect -->
            <div class="absolute inset-0 bg-white opacity-0 transition-opacity duration-75 pointer-events-none z-30" id="flash-overlay"></div>
        </div>

        <!-- Right Side: Action Control Buttons (Vertical on Desktop, Horizontal on Mobile) -->
        <div class="flex flex-row lg:flex-col gap-4 justify-center items-stretch order-3 lg:w-48 w-full">
            <button class="flex-1 lg:flex-none inline-flex items-center justify-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold text-base px-6 py-4 rounded-none transition-all active:translate-y-0 cursor-pointer" id="btn-start-photoshoot">
                Jepret Sekarang!
            </button>
            <button class="flex-1 lg:flex-none inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold px-6 py-4 rounded-none transition-all cursor-pointer" id="btn-cancel-capture">
                Ubah Bingkai
            </button>
        </div>

    </div>
</div>
