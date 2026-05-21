<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MoSafe Photobooth - Ciptakan Momen Serumu!')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,600;1,400;1,600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
        }

        body, button, input, select, textarea, div, p, span, h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif !important;
        }
        
        /* Custom font declaration mapping */
        .font-serif-script {
            font-family: 'Playfair Display', Georgia, serif;
        }
        
        /* Glass card display control */
        .glass-card {
            display: none;
        }
        .glass-card.active {
            display: flex;
        }

        /* Video Frame Overlay Custom Border Layouts */
        .frame-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            box-sizing: border-box;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            z-index: 2;
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-slate-50 via-sky-50/30 to-indigo-50/40 text-slate-800 flex flex-col justify-between relative overflow-hidden font-sans">

    <!-- Ambient Glow Blobs -->
    <div class="absolute top-0 left-0 -translate-x-1/4 -translate-y-1/4 w-[40vw] h-[40vw] bg-sky-200/30 rounded-none blur-[120px] pointer-events-none z-0"></div>
    <div class="absolute bottom-0 right-0 translate-x-1/4 translate-y-1/4 w-[45vw] h-[45vw] bg-pink-100/40 rounded-none blur-[120px] pointer-events-none z-0"></div>
    <div class="absolute top-1/3 right-1/4 w-[30vw] h-[30vw] bg-indigo-100/20 rounded-none blur-[100px] pointer-events-none z-0"></div>

    <!-- Decorative Floating Background Icons -->
    <!-- Camera Icon (Top Left) -->
    <div class="absolute left-[5%] top-[18%] w-16 h-16 md:w-24 md:h-24 text-sky-500/35 -rotate-12 pointer-events-none z-0 hidden sm:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
        </svg>
    </div>

    <!-- Sparkles (Top Right) -->
    <div class="absolute right-[8%] top-[15%] w-12 h-12 md:w-20 md:h-20 text-pink-500/40 rotate-12 pointer-events-none z-0 hidden sm:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 21l-.813-5.096L3 15.093l5.096-.813L9 9.187l.813 5.093 5.096.813-5.096.811ZM19.5 12l-.375 2.375L16.75 14.75l2.375.375.375 2.375.375-2.375 2.375-.375-2.375-.375L19.5 12ZM15.75 3l-.25 1.583-1.583.25 1.583.25.25 1.583.25-1.583 1.583-.25-1.583-.25L15.75 3Z" />
        </svg>
    </div>

    <!-- Polaroid / Picture (Bottom Left) -->
    <div class="absolute left-[8%] bottom-[18%] w-20 h-20 md:w-28 md:h-28 text-indigo-500/35 rotate-6 pointer-events-none z-0 hidden sm:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
        </svg>
    </div>

    <!-- Heart Icon (Bottom Right) -->
    <div class="absolute right-[7%] bottom-[20%] w-14 h-14 md:w-20 md:h-20 text-pink-500/35 -rotate-12 pointer-events-none z-0 hidden sm:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
    </div>

    <!-- Film Roll (Middle Left) -->
    <div class="absolute left-[12%] top-[45%] w-14 h-14 md:w-20 md:h-20 text-slate-500/30 -rotate-6 pointer-events-none z-0 hidden lg:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
            <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M7 3v18M17 3v18M3 7h4M3 12h4M3 17h4M17 7h4M17 12h4M17 17h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>

    <!-- Smiley Face (Middle Right) -->
    <div class="absolute right-[12%] top-[48%] w-12 h-12 md:w-16 md:h-16 text-amber-500/30 rotate-12 pointer-events-none z-0 hidden lg:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75s.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
        </svg>
    </div>

    <!-- Star/Sparkle 1 (Near top center-left) -->
    <div class="absolute left-[28%] top-[12%] w-8 h-8 text-sky-500/35 pointer-events-none z-0 hidden md:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c.132 4.5 3.5 7.868 8 8-.132.132-3.5 3.5-8 8-.132-.132-7.868-3.5-8-8 .132-.132 3.5-3.5 8-8Z" />
        </svg>
    </div>

    <!-- Star/Sparkle 2 (Near bottom center-right) -->
    <div class="absolute right-[30%] bottom-[12%] w-10 h-10 text-indigo-500/35 pointer-events-none z-0 hidden md:block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c.132 4.5 3.5 7.868 8 8-.132.132-3.5 3.5-8 8-.132-.132-7.868-3.5-8-8 .132-.132 3.5-3.5 8-8Z" />
        </svg>
    </div>

    <!-- Header -->
    <header class="px-6 py-5 md:px-12 flex justify-between items-center border-b border-slate-200/60 bg-white/40 backdrop-blur-md z-10 relative">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo/mosafe-logo.png') }}" alt="MoSafe Logo" class="h-8 md:h-10 w-auto object-contain">
            <span class="text-xl md:text-2xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-indigo-600">Photobooth</span>
            <span class="w-2.5 h-2.5 bg-pink-500 rounded-full"></span>
        </div>
        <div class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-3.5 py-1.5 rounded-none flex items-center gap-1.5">
            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
            Siap Digunakan
        </div>
    </header>

    <!-- Main Content Stage -->
    <main class="flex-1 flex items-center justify-center p-4 md:p-8 z-10 relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-5 text-center text-xs text-slate-400 border-t border-slate-200/50 bg-white/20 backdrop-blur-sm z-10 relative">
        Dibuat khusus untuk <a href="#" class="text-sky-500 hover:underline font-semibold">MoSafe</a> &copy; {{ date('Y') }}. Seluruh hak cipta dilindungi.
    </footer>

    @stack('scripts')
</body>
</html>
