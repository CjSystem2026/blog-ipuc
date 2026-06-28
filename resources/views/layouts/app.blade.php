<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="" id="html-root">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#F4F1EA" id="meta-theme-color">
        <title>@yield('title', 'Blog Cristiano - Voces de Fe y Esperanza')</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
        
        <!-- Styles & Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --bg-base: #F4F1EA; /* Soft sand background */
                --text-base: #2e2a27; /* Softer dark text */
                --nav-bg: rgba(244, 241, 234, 0.70);
            }
            html.dark {
                --bg-base: #1c1917;
                --text-base: #e7e5e4;
                --nav-bg: rgba(28,25,23,0.85);
            }
            body {
                font-family: 'Outfit', sans-serif;
                background-color: var(--bg-base);
                color: var(--text-base);
                transition: background-color 0.3s ease, color 0.3s ease;
            }
            .font-serif { font-family: 'Playfair Display', Georgia, serif; }

            /* Light mode soft contrast override */
            html:not(.dark) .bg-white {
                background-color: #FAF8F5 !important; /* Soft warm cream instead of pure white */
            }

            /* Dark mode overrides */
            html.dark .bg-white { background-color: #292524 !important; }
            html.dark .bg-stone-50, html.dark .bg-stone-50\/50 { background-color: #1c1917 !important; }
            html.dark .text-stone-900, html.dark .text-stone-950 { color: #f5f5f4 !important; }
            html.dark .text-stone-600, html.dark .text-stone-650, html.dark .text-stone-700 { color: #d6d3d1 !important; }
            html.dark .text-stone-500 { color: #a8a29e !important; }
            html.dark .text-stone-400 { color: #78716c !important; }
            html.dark .border-stone-200\/40, html.dark .border-stone-200\/60, html.dark .border-stone-200\/55 { border-color: rgba(87,83,78,0.4) !important; }
            html.dark nav { background: var(--nav-bg) !important; border-color: rgba(87,83,78,0.3) !important; }
            html.dark footer { background-color: #0c0a09 !important; }
            html.dark .bg-amber-50\/30, html.dark .bg-amber-50\/15 { background-color: rgba(28,25,23,0.8) !important; }

            /* Scroll reveal animations */
            .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.6s ease, transform 0.6s ease; }
            .reveal.visible { opacity: 1; transform: translateY(0); }
            .reveal-delay-1 { transition-delay: 0.1s; }
            .reveal-delay-2 { transition-delay: 0.2s; }
            .reveal-delay-3 { transition-delay: 0.3s; }

            /* Scroll spy active nav */
            .nav-link-active { color: #92400e !important; border-bottom: 2px solid rgba(146,64,14,0.6); padding-bottom: 2px; }

            /* Aurora hero gradient animation */
            @keyframes aurora {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }
            .aurora-bg {
                background: linear-gradient(135deg, #fef3c7, #faf8f5, #fef9ee, #fdf2e0, #faf8f5);
                background-size: 300% 300%;
                animation: aurora 10s ease infinite;
            }
            html.dark .aurora-bg {
                background: linear-gradient(135deg, #1c1917, #292524, #1a1412, #201c1a, #1c1917);
                background-size: 300% 300%;
                animation: aurora 10s ease infinite;
            }

            /* Stat counter number */
            .stat-num { font-variant-numeric: tabular-nums; }

            /* Reading progress bar */
            #reading-progress { position: fixed; top: 0; left: 0; height: 2px; background: linear-gradient(90deg, #92400e, #d97706); width: 0%; z-index: 9999; transition: width 0.1s linear; }

            /* Bottom mobile nav */
            #bottom-mobile-nav { display: none; }
            @media (max-width: 768px) { #bottom-mobile-nav { display: flex; } body { padding-bottom: 72px; } }

            /* Skeleton pulse */
            @keyframes skeleton-pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
            .skeleton { background: #e7e5e4; border-radius: 8px; animation: skeleton-pulse 1.5s ease infinite; }
            html.dark .skeleton { background: #44403c; }
        </style>

        <script>
            // Apply dark mode BEFORE render to avoid flash
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        </script>
    </head>
    <body class="text-stone-800 antialiased selection:bg-amber-100 selection:text-amber-900">
        <!-- Navigation -->
        <nav class="border-b border-stone-200/60 bg-white/70 backdrop-blur-lg sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="flex items-center space-x-3 group">
                            <span class="text-2xl filter drop-shadow-sm group-hover:scale-110 transition-transform duration-300">🕊️</span>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold tracking-widest text-amber-900 uppercase leading-none">IPUC</span>
                                <span class="text-base font-semibold tracking-wide text-stone-900 group-hover:text-amber-800 transition-colors mt-0.5">
                                    Voces de Gracia
                                </span>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Desktop menu -->
                    <div class="hidden md:flex items-center space-x-10">
                        <a href="/" class="text-sm font-medium text-stone-600 hover:text-stone-900 hover:border-b-2 hover:border-amber-800/40 pb-1 transition-all">
                            Inicio
                        </a>
                        <a href="/#articulos" class="text-sm font-medium text-stone-600 hover:text-stone-900 hover:border-b-2 hover:border-amber-800/40 pb-1 transition-all">
                            Artículos
                        </a>
                        <a href="/#eventos" class="text-sm font-medium text-stone-600 hover:text-stone-900 hover:border-b-2 hover:border-amber-800/40 pb-1 transition-all">
                            Eventos
                        </a>
                        <a href="/oraciones" class="text-sm font-medium text-stone-600 hover:text-stone-900 hover:border-b-2 hover:border-amber-800/40 pb-1 transition-all">
                            Peticiones
                        </a>
                        <a href="/testimonios" class="text-sm font-medium text-stone-600 hover:text-stone-900 hover:border-b-2 hover:border-amber-800/40 pb-1 transition-all">
                            Testimonios
                        </a>
                        <a href="/#nosotros" class="text-sm font-medium text-stone-600 hover:text-stone-900 hover:border-b-2 hover:border-amber-800/40 pb-1 transition-all">
                            Nosotros
                        </a>

                        <!-- Dark Mode Toggle -->
                        <button id="dark-mode-toggle" title="Cambiar modo" class="p-2 rounded-xl text-stone-500 hover:text-stone-900 hover:bg-stone-100 transition-colors focus:outline-none flex items-center justify-center">
                            <span id="dark-icon" class="hidden text-base">☀️</span>
                            <span id="light-icon" class="text-base">🌙</span>
                        </button>

                        @auth
                            <!-- Botón de notificaciones -->
                            <div class="relative" id="notifications-menu">
                                <button id="notifications-btn" class="relative p-2 rounded-xl text-stone-500 hover:text-stone-900 hover:bg-stone-100 transition-colors focus:outline-none flex items-center justify-center">
                                    <span class="text-base">🔔</span>
                                    <span id="notifications-badge" class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-red-600 ring-2 ring-white hidden animate-pulse"></span>
                                </button>
                                
                                <!-- Dropdown panel -->
                                <div id="notifications-dropdown" class="absolute right-0 mt-2 w-85 bg-white rounded-3xl border border-stone-200/60 shadow-xl py-4 z-50 hidden">
                                    <div class="px-4 pb-2 border-b border-stone-100 flex items-center justify-between">
                                        <h4 class="text-xs font-semibold text-stone-900">Notificaciones</h4>
                                        <button id="clear-notifications-btn" class="text-[10px] font-semibold text-amber-900 hover:underline">Marcar leídas</button>
                                    </div>
                                    <div class="max-h-60 overflow-y-auto py-2" id="notifications-list">
                                        <!-- Notifications rendered dynamically -->
                                    </div>
                                </div>
                            </div>

                            <!-- Menú de Usuario Autenticado -->
                            <div class="relative" id="user-menu">
                                <button id="user-menu-btn" class="flex items-center gap-2.5 p-1.5 pr-3 rounded-full hover:bg-stone-50 border border-stone-200/40 hover:border-stone-200 transition-all focus:outline-none">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center text-xs font-bold text-white uppercase shadow-sm">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span class="text-xs font-medium text-stone-700 max-w-[100px] truncate">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <svg class="h-3 w-3 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <!-- User Dropdown Panel -->
                                <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-2xl border border-stone-200/60 shadow-xl py-2.5 z-50 hidden">
                                    <div class="px-4 py-2 border-b border-stone-100 mb-2">
                                        <p class="text-[9px] text-stone-400 font-semibold tracking-wider uppercase">Conectado como</p>
                                        <p class="text-xs font-semibold text-stone-900 truncate">{{ auth()->user()->name }}</p>
                                    </div>
                                    <a href="/admin" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-stone-600 hover:text-stone-900 hover:bg-stone-50 transition-colors">
                                        <span>📊</span> Panel de Control
                                    </a>
                                    
                                    <!-- Logout Form -->
                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-xs font-medium text-stone-600 hover:text-red-750 hover:bg-red-50/40 transition-colors cursor-pointer">
                                            <span>🚪</span> Cerrar sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="/login" class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold tracking-wider uppercase text-amber-900 bg-amber-50 hover:bg-amber-100/80 rounded-full border border-amber-900/10 transition-all shadow-sm">
                                Ingresar
                            </a>
                        @endauth
                    </div>

                    <!-- Hamburger Button -->
                    <div class="flex items-center md:hidden">
                        <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-xl text-stone-500 hover:text-stone-900 hover:bg-stone-100 transition-colors focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                            <svg class="h-6 w-6 block" id="menu-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6 hidden" id="close-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div class="hidden md:hidden border-t border-stone-200/60 bg-white" id="mobile-menu">
                <div class="px-6 pt-2 pb-6 space-y-3">
                    <a href="/" class="block text-sm font-medium text-stone-600 hover:text-stone-900 py-2 transition-colors">
                        Inicio
                    </a>
                    <a href="/#articulos" class="block text-sm font-medium text-stone-600 hover:text-stone-900 py-2 transition-colors">
                        Artículos
                    </a>
                    <a href="/#eventos" class="block text-sm font-medium text-stone-600 hover:text-stone-900 py-2 transition-colors">
                        Eventos
                    </a>
                    <a href="/oraciones" class="block text-sm font-medium text-stone-600 hover:text-stone-900 py-2 transition-colors">
                        Peticiones
                    </a>
                    <a href="/testimonios" class="block text-sm font-medium text-stone-600 hover:text-stone-900 py-2 transition-colors">
                        Testimonios
                    </a>
                    <a href="/#nosotros" class="block text-sm font-medium text-stone-600 hover:text-stone-900 py-2 transition-colors">
                        Nosotros
                    </a>
                    @auth
                        <!-- Mobile notifications row -->
                        <div class="py-2 border-t border-stone-100">
                            <button id="mobile-notifications-btn" class="w-full flex items-center justify-between text-sm font-medium text-stone-600 hover:text-stone-900 py-2">
                                <span class="flex items-center gap-2">🔔 Notificaciones</span>
                                <span id="mobile-notifications-badge" class="h-2 w-2 rounded-full bg-red-650 hidden"></span>
                            </button>
                            <div id="mobile-notifications-list-container" class="hidden mt-2 pl-4 space-y-2 max-h-40 overflow-y-auto text-xs text-stone-500 py-1">
                                <!-- Mobile items -->
                            </div>
                        </div>

                        <!-- Mobile User Info & Actions -->
                        <div class="py-3 border-t border-stone-100 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center text-xs font-bold text-white uppercase shadow-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="overflow-hidden max-w-[150px]">
                                    <p class="text-xs font-semibold text-stone-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-stone-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs font-medium text-stone-550 hover:text-red-750 transition-colors py-1 px-2.5 border border-stone-200 rounded-xl">
                                    Salir
                                </button>
                            </form>
                        </div>

                        <div class="pt-3 border-t border-stone-100">
                            <a href="/admin" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold tracking-wider uppercase text-amber-900 bg-amber-50 hover:bg-amber-100/80 rounded-xl border border-amber-900/10 transition-all shadow-sm">
                                Panel de Control
                            </a>
                        </div>
                    @else
                        <div class="pt-3 border-t border-stone-100">
                            <a href="/login" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold tracking-wider uppercase text-stone-600 bg-stone-50 hover:bg-stone-100 rounded-xl border border-stone-200 transition-all text-center">
                                Ingresar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    // ---- Mobile Menu ----
                    const btn = document.getElementById('mobile-menu-button');
                    const menu = document.getElementById('mobile-menu');
                    const menuIcon = document.getElementById('menu-icon');
                    const closeIcon = document.getElementById('close-icon');
                    if (btn && menu) {
                        btn.addEventListener('click', () => {
                            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
                            btn.setAttribute('aria-expanded', !isExpanded);
                            menu.classList.toggle('hidden');
                            menuIcon.classList.toggle('hidden');
                            closeIcon.classList.toggle('hidden');
                        });
                    }

                    // ---- Dark Mode ----
                    const html = document.getElementById('html-root');
                    const toggleBtn = document.getElementById('dark-mode-toggle');
                    const darkIcon = document.getElementById('dark-icon');
                    const lightIcon = document.getElementById('light-icon');
                    const metaTheme = document.getElementById('meta-theme-color');

                    const applyDark = (isDark) => {
                        html.classList.toggle('dark', isDark);
                        darkIcon.classList.toggle('hidden', !isDark);
                        lightIcon.classList.toggle('hidden', isDark);
                        metaTheme.setAttribute('content', isDark ? '#1c1917' : '#F4F1EA');
                        localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    };
                    applyDark(html.classList.contains('dark'));
                    toggleBtn?.addEventListener('click', () => applyDark(!html.classList.contains('dark')));

                    // ---- Scroll Reveal ----
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
                    }, { threshold: 0.12 });
                    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

                    // ---- Scroll Spy ----
                    const sections = document.querySelectorAll('section[id]');
                    const navLinks = document.querySelectorAll('nav a[href*="#"]');
                    const spyObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                navLinks.forEach(link => {
                                    link.classList.remove('nav-link-active');
                                    if (link.getAttribute('href').includes('#' + entry.target.id)) {
                                        link.classList.add('nav-link-active');
                                    }
                                });
                            }
                        });
                    }, { rootMargin: '-30% 0px -60% 0px' });
                    sections.forEach(s => spyObserver.observe(s));

                    // ---- Bottom Nav: open chat ----
                    const bnavChat = document.getElementById('bnav-chat');
                    const chatToggle = document.getElementById('support-chat-toggle');
                    bnavChat?.addEventListener('click', () => chatToggle?.click());

                    // ---- Stat Counter ----
                    const animateCount = (el) => {
                        const target = +el.dataset.target;
                        const duration = 1800;
                        const step = target / (duration / 16);
                        let current = 0;
                        const timer = setInterval(() => {
                            current = Math.min(current + step, target);
                            el.textContent = Math.floor(current).toLocaleString('es-CO');
                            if (current >= target) clearInterval(timer);
                        }, 16);
                    };
                    const statObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                animateCount(entry.target);
                                statObserver.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.5 });
                    document.querySelectorAll('.stat-num').forEach(el => statObserver.observe(el));
                });
            </script>
        </nav>

        <!-- Main Content -->
        <main class="min-h-[70vh]">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-stone-900 text-stone-300 border-t border-stone-800/50 mt-24">
            <div class="max-w-6xl mx-auto py-16 px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <!-- Brand -->
                    <div class="md:col-span-1 space-y-5">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl">🕊️</span>
                            <span class="text-white font-semibold tracking-wider text-base">Voces de Gracia</span>
                        </div>
                        <p class="text-xs text-stone-400 leading-relaxed">
                            Reflexión teológica, edificación mutua y mensajes inspirados en la Palabra de Dios para la iglesia IPUC.
                        </p>
                        <!-- Redes Sociales -->
                        <div class="flex items-center gap-3 pt-1">
                            <a href="#" class="h-8 w-8 rounded-full bg-stone-800 hover:bg-amber-900/60 flex items-center justify-center transition-colors" title="Facebook">📘</a>
                            <a href="#" class="h-8 w-8 rounded-full bg-stone-800 hover:bg-amber-900/60 flex items-center justify-center transition-colors" title="Instagram">📷</a>
                            <a href="#" class="h-8 w-8 rounded-full bg-stone-800 hover:bg-amber-900/60 flex items-center justify-center transition-colors" title="WhatsApp">📱</a>
                            <a href="#" class="h-8 w-8 rounded-full bg-stone-800 hover:bg-amber-900/60 flex items-center justify-center transition-colors" title="YouTube">▶️</a>
                        </div>
                    </div>

                    <!-- Horarios -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-semibold tracking-widest uppercase text-amber-200">⛪ Cultos Semanales</h4>
                        <ul class="space-y-2 text-xs text-stone-400">
                            <li class="flex justify-between"><span>Martes</span><span class="text-stone-300">7:30 PM</span></li>
                            <li class="flex justify-between"><span>Jueves</span><span class="text-stone-300">7:30 PM</span></li>
                            <li class="flex justify-between"><span>Sábado — Jóvenes</span><span class="text-stone-300">7:30 PM</span></li>
                            <li class="flex justify-between"><span>Dom. — Escuela</span><span class="text-stone-300">9:00 AM</span></li>
                            <li class="flex justify-between"><span>Dom. — Culto</span><span class="text-stone-300">7:00 PM</span></li>
                        </ul>
                    </div>

                    <!-- Enlaces -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-semibold tracking-widest uppercase text-amber-200">Navegación</h4>
                        <ul class="space-y-2.5 text-xs text-stone-400">
                            <li><a href="/" class="hover:text-amber-200 transition-colors">🏠 Inicio</a></li>
                            <li><a href="/#articulos" class="hover:text-amber-200 transition-colors">📰 Artículos</a></li>
                            <li><a href="/#eventos" class="hover:text-amber-200 transition-colors">📅 Agenda</a></li>
                            <li><a href="/oraciones" class="hover:text-amber-200 transition-colors">🙏 Peticiones</a></li>
                            <li><a href="/testimonios" class="hover:text-amber-200 transition-colors">✨ Testimonios</a></li>
                        </ul>
                    </div>

                    <!-- Boletín -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-semibold tracking-widest uppercase text-amber-200">📩 Boletín Digital</h4>
                        <p class="text-xs text-stone-400 leading-relaxed">Recibe artículos y novedades de la iglesia directamente en tu correo.</p>
                        <div class="flex gap-2 mt-2">
                            <input type="email" placeholder="tu@correo.com" class="flex-1 px-3 py-2 bg-stone-800 text-xs text-stone-200 rounded-xl border border-stone-700 focus:outline-none focus:border-amber-800/60 placeholder-stone-500">
                            <button class="px-3 py-2 bg-amber-900 hover:bg-amber-800 text-white text-xs rounded-xl transition-colors font-semibold">→</button>
                        </div>
                        <a href="/admin" class="inline-block text-xs font-semibold text-amber-300 hover:text-amber-200 underline underline-offset-4">
                            Escribir como Autor &rarr;
                        </a>
                    </div>
                </div>
                
                <div class="border-t border-stone-800/60 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-[11px] text-stone-500">
                    <p>&copy; {{ date('Y') }} Voces de Gracia &mdash; Iglesia Pentecostal Unida de Colombia (IPUC). Unicidad, paz y comunión.</p>
                    <p class="mt-4 md:mt-0">Diseñado con amor y fe en la Palabra.</p>
                </div>
            </div>
        </footer>

        <!-- Mobile Bottom Navigation Bar -->
        <nav id="bottom-mobile-nav" class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-lg border-t border-stone-200/60 px-2 py-2 items-center justify-around shadow-xl">
            <a href="/" id="bnav-home" class="bnav-item flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl text-stone-400 hover:text-amber-900 transition-colors">
                <span class="text-lg">🏠</span>
                <span class="text-[9px] font-semibold tracking-wide uppercase">Inicio</span>
            </a>
            <a href="/#articulos" id="bnav-art" class="bnav-item flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl text-stone-400 hover:text-amber-900 transition-colors">
                <span class="text-lg">📰</span>
                <span class="text-[9px] font-semibold tracking-wide uppercase">Artículos</span>
            </a>
            <a href="/#eventos" id="bnav-ev" class="bnav-item flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl text-stone-400 hover:text-amber-900 transition-colors">
                <span class="text-lg">📅</span>
                <span class="text-[9px] font-semibold tracking-wide uppercase">Agenda</span>
            </a>
            <a href="/oraciones" id="bnav-pray" class="bnav-item flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl text-stone-400 hover:text-amber-900 transition-colors">
                <span class="text-lg">🙏</span>
                <span class="text-[9px] font-semibold tracking-wide uppercase">Oración</span>
            </a>
            <button id="bnav-chat" class="bnav-item flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl text-stone-400 hover:text-amber-900 transition-colors focus:outline-none">
                <span class="text-lg">💬</span>
                <span class="text-[9px] font-semibold tracking-wide uppercase">Hablar</span>
            </button>
        </nav>

        @include('partials.support_widget')
    </body>
</html>
