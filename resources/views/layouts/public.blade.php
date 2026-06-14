<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog IPUC') - Luz y Paz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-serif text-blue-800">IPUC</span>
                <span class="text-sm font-medium text-slate-500 uppercase tracking-widest">Blog</span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="/" class="hover:text-blue-600 transition">Inicio</a>
                <a href="#" class="hover:text-blue-600 transition">Artículos</a>
                <a href="#" class="hover:text-blue-600 transition">Testimonios</a>
                <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Entrar</a>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 mt-20 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-slate-500 text-sm">
            <p>&copy; {{ date('Y') }} Blog IPUC - Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
