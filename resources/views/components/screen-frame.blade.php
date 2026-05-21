<!-- SCREEN 2: FRAME SELECTION -->
<div class="glass-card w-full bg-white/70 backdrop-blur-xl border border-white/80 rounded-none p-8 md:p-12 flex flex-col items-center text-center transition-all duration-500" id="screen-frame">
    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 mb-3 bg-gradient-to-r from-slate-950 to-slate-700 bg-clip-text text-transparent">Pilih Bingkai Foto</h2>
    <p class="text-base text-slate-500 max-w-md mb-8 leading-relaxed">Pilih desain bingkai favorit Anda yang akan menghiasi hasil jepretan foto strip Anda.</p>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-2xl w-full mb-8">
        <!-- Frame 1 Card -->
        <div class="group relative flex flex-col items-center gap-3 p-5 bg-white/60 hover:bg-white border-2 border-sky-500 bg-sky-50/50 ring-2 ring-sky-500/10 rounded-none cursor-pointer transition-all frame-card" data-frame-id="frame1">
            <div class="w-[100px] h-[160px] relative overflow-hidden shadow-md transition-transform duration-300 group-hover:scale-105 border border-slate-200">
                <img src="/bingkai/1.png" alt="Bingkai 1" class="w-full h-full object-contain bg-slate-100">
            </div>
            <div class="font-bold text-slate-800 text-sm">Bingkai Aesthetic</div>
            <div class="text-[11px] text-slate-400">Modern Staggered Layout</div>
        </div>

        <!-- Frame 2 Card -->
        <div class="group relative flex flex-col items-center gap-3 p-5 bg-white/60 hover:bg-white border-2 border-slate-200 rounded-none cursor-pointer transition-all frame-card" data-frame-id="frame2">
            <div class="w-[100px] h-[160px] relative overflow-hidden shadow-md transition-transform duration-300 group-hover:scale-105 border border-slate-200">
                <img src="/bingkai/2.png" alt="Bingkai 2" class="w-full h-full object-contain bg-slate-100">
            </div>
            <div class="font-bold text-slate-800 text-sm">Bingkai Klasik</div>
            <div class="text-[11px] text-slate-400">Tata Letak Center Vertikal</div>
        </div>
    </div>
    
    <div class="flex gap-4">
        <button class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold px-6 py-4 rounded-none transition-all cursor-pointer" id="btn-back-to-email">
            Kembali
        </button>
        <button class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold text-base px-8 py-4 rounded-none transition-all active:translate-y-0 cursor-pointer" id="btn-confirm-frame">
            Mulai Ambil Foto
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
        </button>
    </div>
</div>
