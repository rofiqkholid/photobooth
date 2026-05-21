<!-- SCREEN 1: EMAIL INPUT -->
<div class="glass-card active w-full bg-white/70 backdrop-blur-xl border border-white/80 rounded-none p-5 sm:p-8 md:p-12 flex flex-col items-center text-center transition-all duration-500" id="screen-email">
    <div class="relative mb-4 sm:mb-6 flex items-center justify-center">
        <!-- Main Camera Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 sm:w-20 sm:h-20 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
        </svg>
        <!-- Pink Sparkle Accent -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-pink-500 absolute -top-1 -right-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21l-.813-5.096L3 15l5.096-.813L9 9l.813 5.096L15 15l-5.096.813z" />
        </svg>
        <!-- Indigo Sparkle Accent -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-indigo-400 absolute -bottom-1 -left-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21l-.813-5.096L3 15l5.096-.813L9 9l.813 5.096L15 15l-5.096.813z" />
        </svg>
    </div>
    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 mb-2 sm:mb-3 bg-gradient-to-r from-slate-950 to-slate-700 bg-clip-text text-transparent">Mosafe Photobooth</h2>
    <p class="text-xs sm:text-base text-slate-500 max-w-md mb-6 sm:mb-8 leading-relaxed">Masukkan alamat email Anda untuk menerima cetakan foto photobooth instan Anda langsung di kotak masuk.</p>
    
    <div class="w-full max-w-md mb-4 sm:mb-6">
        <input type="email" id="guest-email" class="w-full px-4 py-3 sm:px-6 sm:py-4 bg-white border border-slate-200 rounded-none text-slate-800 placeholder-slate-400 text-center text-base sm:text-lg font-medium transition-all focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-100" placeholder="example@email.com" required autocomplete="email">
    </div>
    
    <button class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-600 hover:to-indigo-700 text-white font-bold text-sm sm:text-base px-6 py-3 sm:px-8 sm:py-4 rounded-none transition-all active:translate-y-0 cursor-pointer" id="btn-submit-email">
        Lanjutkan ke Bingkai
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
    </button>
</div>
