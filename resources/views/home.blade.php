@extends('layouts.app')

@section('title', 'Inicio - Voces de Gracia')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 lg:py-32 overflow-hidden aurora-bg">
    <div class="max-w-4xl mx-auto text-center px-6">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50/80 border border-amber-900/10 px-3 py-1.5 text-xs font-semibold tracking-wider uppercase text-amber-900 mb-6 reveal">
            🕊️ Palabra de Vida y Paz
        </span>
        <h1 class="text-5xl sm:text-7xl font-serif tracking-tight text-stone-900 font-semibold leading-tight text-balance reveal reveal-delay-1">
            Edificando la fe con <span class="italic text-amber-800 font-normal">amor y gracia</span>
        </h1>

        <!-- Rotating Bible Quote -->
        <div class="mt-8 min-h-[64px] flex items-center justify-center reveal reveal-delay-2">
            <p id="hero-quote" class="text-sm/relaxed text-stone-500 italic font-serif max-w-xl transition-all duration-700 opacity-100">
                "La fe es la certeza de lo que se espera, la convicción de lo que no se ve." — Hebreos 11:1
            </p>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 reveal reveal-delay-3">
            <a href="#articulos" class="w-full sm:w-auto px-8 py-3.5 text-sm font-semibold text-white bg-amber-900 hover:bg-amber-850 rounded-full shadow-md shadow-amber-900/10 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                Leer Artículos
            </a>
            <a href="/admin" class="w-full sm:w-auto px-8 py-3.5 text-sm font-semibold text-stone-700 hover:text-stone-900 bg-white hover:bg-stone-50 rounded-full border border-stone-200 shadow-sm hover:-translate-y-0.5 transition-all duration-300">
                Escribir como Autor
            </a>
        </div>

        <!-- Stats Counter -->
        @php
            $postCount  = isset($posts)  ? $posts->count()  : 0;
            $prayerCount = \App\Models\PrayerRequest::count();
            $testiCount  = \App\Models\Testimonial::count();
        @endphp
        <div class="mt-16 grid grid-cols-3 gap-6 max-w-sm mx-auto reveal">
            <div class="text-center">
                <p class="text-3xl font-serif font-bold text-amber-900 stat-num" data-target="{{ \App\Models\Post::count() }}">0</p>
                <p class="text-[10px] uppercase tracking-widest text-stone-400 font-semibold mt-1">Artículos</p>
            </div>
            <div class="text-center border-x border-stone-200/60">
                <p class="text-3xl font-serif font-bold text-amber-900 stat-num" data-target="{{ $prayerCount }}">0</p>
                <p class="text-[10px] uppercase tracking-widest text-stone-400 font-semibold mt-1">Oraciones</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-serif font-bold text-amber-900 stat-num" data-target="{{ $testiCount }}">0</p>
                <p class="text-[10px] uppercase tracking-widest text-stone-400 font-semibold mt-1">Testimonios</p>
            </div>
        </div>
    </div>
</section>

<script>
    // Rotating Bible quotes in hero
    const quotes = [
        '"La fe es la certeza de lo que se espera, la convicción de lo que no se ve." — Hebreos 11:1',
        '"Todo lo puedo en Cristo que me fortalece." — Filipenses 4:13',
        '"El Señor es mi pastor; nada me faltará." — Salmo 23:1',
        '"Un Señor, una fe, un bautismo." — Efesios 4:5',
        '"Porque de tal manera amó Dios al mundo, que ha dado a su Hijo unigénito." — Juan 3:16',
    ];
    let qIdx = 0;
    const quoteEl = document.getElementById('hero-quote');
    setInterval(() => {
        quoteEl.style.opacity = '0';
        quoteEl.style.transform = 'translateY(8px)';
        setTimeout(() => {
            qIdx = (qIdx + 1) % quotes.length;
            quoteEl.textContent = quotes[qIdx];
            quoteEl.style.opacity = '1';
            quoteEl.style.transform = 'translateY(0)';
        }, 500);
    }, 5000);
</script>

<!-- Articles Section -->
<section id="articulos" class="max-w-6xl mx-auto px-6 py-16 scroll-mt-24">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 border-b border-stone-200/60 pb-8 reveal">
        <div>
            <h2 class="text-3xl font-serif text-stone-950 font-bold">Escritos Recientes</h2>
            <p class="text-sm text-stone-500 mt-2">Encuentra inspiración y teología para tu vida diaria.</p>
        </div>
    </div>

    @if(isset($posts) && $posts->count() > 0)
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $i => $post)
                @php $readTime = max(1, ceil(str_word_count(strip_tags($post->content ?? '')) / 200)); @endphp
                <article class="reveal reveal-delay-{{ min($i+1,3) }} flex flex-col bg-white rounded-3xl border border-stone-200/40 overflow-hidden shadow-sm hover:shadow-lg hover:border-amber-850/20 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="h-48 overflow-hidden bg-stone-100 relative">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <!-- Reading time badge -->
                        <div class="absolute top-3 right-3 bg-stone-900/75 backdrop-blur-xs text-white text-[9px] font-bold uppercase tracking-wider px-2 py-1 rounded-lg">
                            ⏱ {{ $readTime }} min
                        </div>
                    </div>
                    <div class="p-8 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-x-3 text-xs text-stone-400 mb-4">
                                <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('M d, Y') }}</time>
                                <span>&bull;</span>
                                <span class="font-medium text-amber-800">Por {{ $post->author->name ?? 'Autor' }}</span>
                            </div>
                            <h3 class="text-xl font-serif text-stone-950 font-semibold leading-snug group-hover:text-amber-850 transition-colors">
                                <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                            </h3>
                            <p class="mt-4 text-sm/relaxed text-stone-600 line-clamp-3">{{ $post->excerpt }}</p>
                        </div>
                        <div class="mt-8 pt-6 border-t border-stone-100 flex justify-between items-center">
                            <a href="/posts/{{ $post->slug }}" class="text-xs font-semibold text-amber-900 group-hover:underline inline-flex items-center gap-1">
                                Leer artículo completo <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <!-- Fallback Cards de Demostración si no hay posts en la BD -->
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
            <!-- Card 1 -->
            <article class="flex flex-col bg-white rounded-3xl border border-stone-200/40 overflow-hidden shadow-sm hover:shadow-md hover:border-amber-900/10 transition-all duration-300 group">
                <div class="h-48 overflow-hidden bg-stone-100 relative">
                    <img src="https://images.unsplash.com/photo-1438243447756-93db277bd280?w=800&auto=format&fit=crop&q=60" alt="La Unicidad de Dios" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-x-3 text-xs text-stone-400 mb-4">
                            <span>Junio 18, 2026</span>
                            <span>&bull;</span>
                            <span class="font-medium text-amber-800">Por Pastor Alexander</span>
                        </div>
                        <h3 class="text-xl font-serif text-stone-950 font-semibold leading-snug group-hover:text-amber-800 transition-colors">
                            <a href="/posts/la-unicidad-de-dios">
                                La Unicidad de Dios y la Revelación en la Escritura
                            </a>
                        </h3>
                        <p class="mt-4 text-sm/relaxed text-stone-600 line-clamp-3">
                            Un análisis bíblico sistemático sobre el misterio y la simplicidad de la unicidad de Dios, cimiento de nuestra doctrina y fe apostólica.
                        </p>
                    </div>
                    <div class="mt-8 pt-6 border-t border-stone-100">
                        <a href="/posts/la-unicidad-de-dios" class="text-xs font-semibold text-amber-900 group-hover:underline inline-flex items-center gap-1">
                            Leer artículo completo <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 2 -->
            <article class="flex flex-col bg-white rounded-3xl border border-stone-200/40 overflow-hidden shadow-sm hover:shadow-md hover:border-amber-900/10 transition-all duration-300 group">
                <div class="h-48 overflow-hidden bg-stone-100 relative">
                    <img src="https://images.unsplash.com/photo-1507434965515-61970f2bd7c6?w=800&auto=format&fit=crop&q=60" alt="Gracia Inmerecida" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-x-3 text-xs text-stone-400 mb-4">
                            <span>Junio 15, 2026</span>
                            <span>&bull;</span>
                            <span class="font-medium text-amber-800">Por Hna. María Clara</span>
                        </div>
                        <h3 class="text-xl font-serif text-stone-950 font-semibold leading-snug group-hover:text-amber-800 transition-colors">
                            <a href="/posts/gracia-y-redencion">
                                Gracia Inmerecida: El Milagro del Calvario
                            </a>
                        </h3>
                        <p class="mt-4 text-sm/relaxed text-stone-600 line-clamp-3">
                            Reflexión devocional acerca de la crucifixión y cómo el sacrificio supremo abrió las puertas a una redención completa y eterna.
                        </p>
                    </div>
                    <div class="mt-8 pt-6 border-t border-stone-100">
                        <a href="/posts/gracia-y-redencion" class="text-xs font-semibold text-amber-900 group-hover:underline inline-flex items-center gap-1">
                            Leer artículo completo <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Card 3 -->
            <article class="flex flex-col bg-white rounded-3xl border border-stone-200/40 overflow-hidden shadow-sm hover:shadow-md hover:border-amber-900/10 transition-all duration-300 group">
                <div class="h-48 overflow-hidden bg-stone-100 relative">
                    <img src="https://images.unsplash.com/photo-1518156677180-95a2893f3e9f?w=800&auto=format&fit=crop&q=60" alt="Hallando Esperanza" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-8 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-x-3 text-xs text-stone-400 mb-4">
                            <span>Junio 10, 2026</span>
                            <span>&bull;</span>
                            <span class="font-medium text-amber-800">Por Ev. David Soto</span>
                        </div>
                        <h3 class="text-xl font-serif text-stone-950 font-semibold leading-snug group-hover:text-amber-800 transition-colors">
                            <a href="/posts/esperanza-en-la-tormenta">
                                Hallando Esperanza en Medio de la Tormenta
                            </a>
                        </h3>
                        <p class="mt-4 text-sm/relaxed text-stone-600 line-clamp-3">
                            Cómo aferrarse a las promesas divinas cuando las circunstancias familiares o de salud nublan nuestro horizonte. Dios sigue en el control.
                        </p>
                    </div>
                    <div class="mt-8 pt-6 border-t border-stone-100">
                        <a href="/posts/esperanza-en-la-tormenta" class="text-xs font-semibold text-amber-900 group-hover:underline inline-flex items-center gap-1">
                            Leer artículo completo <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </div>
            </article>
    @endif

    @if(isset($hasMorePosts) && $hasMorePosts)
        <div class="mt-16 text-center reveal">
            <a href="/articulos" class="inline-flex items-center gap-2 px-8 py-3.5 text-xs font-semibold uppercase tracking-wider text-amber-900 bg-amber-50 hover:bg-amber-100/80 rounded-full border border-amber-900/10 transition-all shadow-sm hover:-translate-y-0.5 duration-200">
                Ver más artículos <span class="text-sm">&rarr;</span>
            </a>
        </div>
    @endif
</section>

<!-- Events Section (Agenda de Actividades) -->
<section id="eventos" class="max-w-6xl mx-auto px-6 py-20 scroll-mt-24">
    <div class="text-center md:text-left mb-16">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50/80 border border-amber-900/10 px-3 py-1.5 text-xs font-semibold tracking-wider uppercase text-amber-900 mb-4">
            📅 Agenda & Reuniones
        </span>
        <h2 class="text-3xl sm:text-4xl font-serif text-stone-950 font-bold tracking-tight">Agenda de la Iglesia</h2>
        <p class="text-stone-500 mt-3 text-sm max-w-xl">
            Te invitamos a ser parte activa de nuestra congregación. Aquí tienes los horarios de nuestros cultos semanales recurrentes y las actividades especiales programadas.
        </p>
    </div>

    <div class="grid gap-12 lg:grid-cols-12 items-start">
        <!-- Columna 1: Cultos Semanales (Fijo) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="border-b border-stone-200/60 pb-4">
                <h3 class="text-lg font-serif font-bold text-stone-900 flex items-center gap-2">
                    <span class="text-xl">⛪</span> Cultos Semanales
                </h3>
                <p class="text-xs text-stone-400 mt-1">Nuestras reuniones regulares semanales en el templo central.</p>
            </div>

            <div class="space-y-4">
                <!-- Martes -->
                <div class="p-5 bg-white rounded-2xl border border-stone-200/40 hover:border-amber-900/10 transition-all flex items-start gap-4 shadow-xs">
                    <div class="h-10 w-10 rounded-xl bg-amber-50 flex flex-col items-center justify-center font-bold text-amber-900 text-xs shrink-0">
                        <span>MA</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-stone-900">Culto General</h4>
                        <p class="text-[11px] text-stone-400 mt-0.5">Reunión general de oración y predicación.</p>
                        <div class="mt-2.5 flex items-center gap-4 text-xs font-medium">
                            <span class="text-amber-900 flex items-center gap-1">⏰ 7:30 PM</span>
                            <span class="text-stone-400 flex items-center gap-1">📍 Templo Central</span>
                        </div>
                    </div>
                </div>

                <!-- Jueves -->
                <div class="p-5 bg-white rounded-2xl border border-stone-200/40 hover:border-amber-900/10 transition-all flex items-start gap-4 shadow-xs">
                    <div class="h-10 w-10 rounded-xl bg-amber-50 flex flex-col items-center justify-center font-bold text-amber-900 text-xs shrink-0">
                        <span>JU</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-stone-900">Culto y Discipulado</h4>
                        <p class="text-[11px] text-stone-400 mt-0.5">Estudio bíblico sistemático para el crecimiento de la iglesia.</p>
                        <div class="mt-2.5 flex items-center gap-4 text-xs font-medium">
                            <span class="text-amber-900 flex items-center gap-1">⏰ 7:30 PM</span>
                            <span class="text-stone-400 flex items-center gap-1">📍 Templo Central</span>
                        </div>
                    </div>
                </div>

                <!-- Sábado -->
                <div class="p-5 bg-white rounded-2xl border border-stone-200/40 hover:border-amber-900/10 transition-all flex items-start gap-4 shadow-xs">
                    <div class="h-10 w-10 rounded-xl bg-amber-50 flex flex-col items-center justify-center font-bold text-amber-900 text-xs shrink-0">
                        <span>SÁ</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-stone-900">Culto de Jóvenes</h4>
                        <p class="text-[11px] text-stone-400 mt-0.5">Confraternidad y enseñanza enfocada en la juventud.</p>
                        <div class="mt-2.5 flex items-center gap-4 text-xs font-medium">
                            <span class="text-amber-900 flex items-center gap-1">⏰ 7:30 PM</span>
                            <span class="text-stone-400 flex items-center gap-1">📍 Salón Juvenil</span>
                        </div>
                    </div>
                </div>

                <!-- Domingo (Doble) -->
                <div class="p-5 bg-gradient-to-br from-white to-stone-50/20 rounded-2xl border border-stone-200/40 hover:border-amber-900/10 transition-all flex items-start gap-4 shadow-xs">
                    <div class="h-10 w-10 rounded-xl bg-amber-900 text-white flex flex-col items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                        <span>DO</span>
                    </div>
                    <div class="flex-1 space-y-4">
                        <div>
                            <h4 class="text-sm font-semibold text-stone-900">Escuela Dominical</h4>
                            <p class="text-[11px] text-stone-400 mt-0.5">Enseñanza bíblica por clases para todas las edades.</p>
                            <div class="mt-2.5 flex items-center gap-4 text-xs font-medium">
                                <span class="text-amber-900 flex items-center gap-1">⏰ 9:00 AM</span>
                                <span class="text-stone-400 flex items-center gap-1">📍 Salón de Clases</span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-stone-100">
                            <h4 class="text-sm font-semibold text-stone-900">Culto General de Predicación</h4>
                            <p class="text-[11px] text-stone-400 mt-0.5">Reunión de alabanza y proclamación de la Palabra.</p>
                            <div class="mt-2.5 flex items-center gap-4 text-xs font-medium">
                                <span class="text-amber-900 flex items-center gap-1">⏰ 7:00 PM</span>
                                <span class="text-stone-400 flex items-center gap-1">📍 Templo Central</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Último domingo de mes -->
                <div class="p-5 bg-amber-50/15 rounded-2xl border border-amber-900/5 hover:border-amber-900/10 transition-all flex items-start gap-4 shadow-xs">
                    <div class="h-10 w-10 rounded-xl bg-amber-100/50 flex flex-col items-center justify-center font-bold text-amber-900 text-xs shrink-0">
                        <span>✨</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-amber-950">Ayuno Congregacional</h4>
                        <p class="text-[11px] text-stone-400 mt-0.5">Cada último domingo del mes nos unimos en ayuno y clamor por la mañana.</p>
                        <div class="mt-2.5 flex items-center gap-4 text-xs font-medium">
                            <span class="text-amber-900 flex items-center gap-1">📅 Fin de Mes</span>
                            <span class="text-stone-400 flex items-center gap-1">📍 Templo Central</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna 2: Eventos Especiales (Dinámico) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="border-b border-stone-200/60 pb-4">
                <h3 class="text-lg font-serif font-bold text-stone-900 flex items-center gap-2">
                    <span class="text-xl">🌟</span> Eventos Especiales
                </h3>
                <p class="text-xs text-stone-400 mt-1">Campañas, talleres, vigilias y confraternidades extraordinarias.</p>
            </div>

            @if(isset($events) && $events->count() > 0)
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach($events as $event)
                        <div class="bg-white rounded-3xl border border-stone-200/40 overflow-hidden shadow-xs hover:shadow-md hover:border-amber-900/10 transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                <!-- Portada Imagen -->
                                <div class="h-36 bg-stone-100 overflow-hidden relative">
                                    <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    
                                    <!-- Fecha Flotante -->
                                    <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs px-2.5 py-1 rounded-xl border border-stone-200/20 text-center shadow-xs">
                                        <p class="text-[9px] uppercase font-extrabold tracking-wider text-amber-900 leading-none">
                                            {{ \Carbon\Carbon::parse($event->date)->isoFormat('MMM') }}
                                        </p>
                                        <p class="text-sm font-bold text-stone-900 leading-none mt-1">
                                            {{ \Carbon\Carbon::parse($event->date)->format('d') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="p-5">
                                    <h4 class="text-base font-serif font-bold text-stone-950 leading-snug group-hover:text-amber-800 transition-colors line-clamp-2">
                                        {{ $event->title }}
                                    </h4>
                                    
                                    <div class="mt-3.5 space-y-1.5 text-xs text-stone-500">
                                        <p class="flex items-center gap-1.5">
                                            <span>⏰</span> <span class="text-stone-700">{{ $event->time }}</span>
                                        </p>
                                        <p class="flex items-center gap-1.5">
                                            <span>📍</span> <span class="text-stone-700">{{ $event->location }}</span>
                                        </p>
                                    </div>

                                    @if($event->description)
                                        <p class="mt-3 text-xs/relaxed text-stone-600 line-clamp-3 font-light">
                                            {{ $event->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Placehoder Premium cuando no hay eventos especiales -->
                <div class="p-8 text-center bg-white rounded-3xl border border-stone-200/40 shadow-xs flex flex-col items-center justify-center space-y-4 py-16">
                    <span class="text-4xl">✨</span>
                    <h4 class="text-base font-serif font-semibold text-stone-900">No hay eventos especiales programados</h4>
                    <p class="text-stone-400 text-xs max-w-sm leading-relaxed">
                        Actualmente no tenemos campañas o talleres programados. Te invitamos a integrarte en nuestros cultos semanales fijos indicados en la columna izquierda.
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- About Section (Nosotros) -->
<section id="nosotros" class="bg-amber-50/15 border-y border-stone-200/50 py-24 scroll-mt-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid gap-12 lg:grid-cols-12 items-center">
            <!-- Columna Izquierda: Mensaje y Cita -->
            <div class="lg:col-span-7 space-y-6">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50/80 border border-amber-900/10 px-3 py-1.5 text-xs font-semibold tracking-wider uppercase text-amber-900">
                    🕊️ Nuestra Identidad
                </span>
                <h2 class="text-3xl sm:text-4xl font-serif text-stone-950 font-bold tracking-tight leading-tight">
                    Guiados por la Palabra, Unidos en el Amor de Dios
                </h2>
                <p class="text-stone-600 leading-relaxed text-sm/relaxed font-light">
                    Somos una comunidad de autores y ministros comprometidos con la propagación del Evangelio. A través de este espacio, buscamos proveer recursos de edificación teológica y espiritual, manteniendo la sana doctrina y el amor fraternal como bases fundamentales de cada palabra escrita para glorificar el nombre de Jesús.
                </p>

                <!-- Cita Bíblica Pull-quote -->
                <div class="border-l-2 border-amber-900/40 pl-5 py-2 mt-8 italic text-stone-750 font-serif">
                    <p class="text-sm/relaxed">
                        "Un Señor, una fe, un bautismo; un Dios y Padre de todos, el cual es sobre todos, y por todos, y en todos."
                    </p>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-amber-950 mt-2 block">— Efesios 4:5-6</span>
                </div>
            </div>

            <!-- Columna Derecha: Imagen Estética -->
            <div class="lg:col-span-5 relative group">
                <!-- Marco/Efecto de sombra decorativo posterior -->
                <div class="absolute inset-0 bg-amber-900/5 rounded-3xl translate-x-3 translate-y-3 transition-transform group-hover:translate-x-1.5 group-hover:translate-y-1.5 duration-300"></div>
                
                <!-- Contenedor de la Imagen -->
                <div class="relative overflow-hidden rounded-3xl border border-stone-200/55 shadow-sm bg-white">
                    <img 
                        src="{{ asset('images/mission_bible.png') }}" 
                        alt="Escrituras Sagradas IPUC" 
                        class="w-full h-72 sm:h-80 object-cover group-hover:scale-[1.02] transition-transform duration-500"
                    >
                    
                    <!-- Etiqueta Flotante Glassmorphic -->
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-xs px-3.5 py-2 rounded-xl border border-stone-200/20 shadow-xs">
                        <p class="text-[9px] font-bold uppercase tracking-widest text-amber-900 leading-none">Voces de Gracia</p>
                        <p class="text-[8px] text-stone-500 mt-1 font-light leading-none">Templo Central IPUC</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Prayer Request Section -->
<section id="oracion" class="py-20 bg-stone-50 scroll-mt-24">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50/80 border border-amber-900/10 px-3 py-1.5 text-xs font-semibold tracking-wider uppercase text-amber-900 mb-4">
                🙏 Intercesión y Apoyo
            </span>
            <h2 class="text-3xl font-serif text-stone-950 font-bold">¿Podemos Orar por Ti?</h2>
            <p class="text-stone-500 mt-2 text-sm">Comparte tu petición y nuestro equipo de pastores y líderes estará intercediendo ante Dios por tu vida.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200/30 rounded-2xl text-emerald-800 text-sm font-medium flex items-center gap-3">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-stone-200/60 p-8 shadow-sm">
            <form action="{{ route('prayer-requests.store') }}" method="POST" class="space-y-6">
                @csrf
                @auth
                    <!-- Mostrar información de quién publica -->
                    <div class="bg-stone-50/80 border border-stone-200/50 rounded-2xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center text-xs font-bold text-white uppercase shadow-xs">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-stone-900">Publicando como <span class="text-amber-900">{{ auth()->user()->name }}</span></p>
                                <p class="text-[10px] text-stone-400">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-semibold text-stone-400 bg-stone-200/40 px-2 py-1 rounded-lg">Cuenta Activa</span>
                    </div>
                @else
                    <div class="grid gap-6 sm:grid-cols-2">
                        <!-- Nombre -->
                        <div class="space-y-1.5">
                            <label for="name" class="text-xs font-semibold tracking-wider uppercase text-stone-500">Nombre (Opcional)</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                value="{{ old('name') }}"
                                placeholder="Ej. Juan Pérez"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-900"
                            >
                            @error('name')
                                <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Correo -->
                        <div class="space-y-1.5">
                            <label for="email" class="text-xs font-semibold tracking-wider uppercase text-stone-500">Correo Electrónico (Opcional)</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="tu-correo@ejemplo.com"
                                class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-900"
                            >
                            @error('email')
                                <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endauth

                <!-- Mensaje / Petición -->
                <div class="space-y-1.5">
                    <label for="message" class="text-xs font-semibold tracking-wider uppercase text-stone-500">Tu Petición de Oración</label>
                    <textarea 
                        name="message" 
                        id="message" 
                        rows="4" 
                        placeholder="Describe brevemente por qué causa deseas que oremos..."
                        required
                        class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-900"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-xs text-red-650 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Privacidad -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            id="is_private" 
                            name="is_private" 
                            type="checkbox" 
                            value="1" 
                            {{ old('is_private') ? 'checked' : '' }}
                            class="focus:ring-amber-500 h-4 w-4 text-amber-905 border-stone-300 rounded"
                        >
                    </div>
                    <div class="ml-3 text-xs leading-5">
                        <label for="is_private" class="font-medium text-stone-700">Mantener esta petición como privada</label>
                        <p class="text-stone-400">Si se marca, solo los pastores tendrán acceso a ver y orar por esta petición.</p>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="pt-2 text-right">
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-6 py-3 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 rounded-xl shadow-md shadow-amber-900/10 transition-all"
                    >
                        Enviar Petición de Oración
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Divider with Bible Verse -->
<section class="py-24 bg-stone-950 text-stone-100 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#d97706_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-6">
        <span class="text-xs uppercase tracking-widest text-amber-500 font-bold">La Palabra de Dios</span>
        <blockquote class="text-2xl sm:text-3xl font-serif italic text-stone-200 leading-relaxed max-w-3xl mx-auto">
            "Vete a tu casa, a los tuyos, y cuéntales cuán grandes cosas el Señor ha hecho contigo, y cómo ha tenido misericordia de ti."
        </blockquote>
        <cite class="block text-xs font-semibold uppercase tracking-wider text-amber-400 not-italic">— Marcos 5:19</cite>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonios" class="py-20 bg-stone-50 scroll-mt-24">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50/80 border border-amber-900/10 px-3 py-1.5 text-xs font-semibold tracking-wider uppercase text-amber-900 mb-4">
                    ✨ Testimonios de Fe
                </span>
                <h2 class="text-3xl font-serif text-stone-950 font-bold">Maravillas de Su Gracia</h2>
                <p class="text-stone-500 mt-2 text-sm">Testimonios de hermanos y amigos que testifican del amor y poder del Altísimo.</p>
            </div>
            <div class="flex items-center gap-4">
                <a 
                    href="{{ route('testimonials.index') }}"
                    class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-amber-900 hover:bg-amber-100/50 rounded-xl transition-all border border-amber-900/20"
                >
                    Ver Todos
                </a>
                <a 
                    href="{{ route('testimonials.create') }}"
                    class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 rounded-xl shadow-md shadow-amber-900/10 transition-all inline-flex items-center gap-2"
                >
                    <span>+</span> Compartir mi Testimonio
                </a>
            </div>
        </div>

        <!-- Testimonials Grid/List -->
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($testimonials as $testimonial)
                <div class="bg-white rounded-3xl border border-stone-200/40 p-8 shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 relative group">
                    <div class="text-amber-900/10 text-6xl font-serif absolute top-4 left-6 pointer-events-none">“</div>
                    <div class="relative z-10">
                        <p class="text-stone-650 leading-relaxed text-sm font-light italic mb-6 line-clamp-4">
                            "{{ $testimonial->content }}"
                        </p>
                    </div>
                    <div class="pt-4 border-t border-stone-100 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <div class="h-6 w-6 rounded-full bg-gradient-to-tr from-stone-400 to-stone-500 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                                {{ substr($testimonial->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-[10px] font-semibold text-stone-900">{{ $testimonial->name }}</h4>
                            </div>
                        </div>
                        <a 
                            href="{{ route('testimonials.show', $testimonial->id) }}"
                            class="text-[10px] font-semibold text-amber-900 hover:underline"
                        >
                            Leer más &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <!-- Fallback / Demo Testimonials -->
                <div class="bg-white rounded-3xl border border-stone-200/40 p-8 shadow-sm flex flex-col justify-between relative group">
                    <div class="text-amber-900/10 text-6xl font-serif absolute top-4 left-6 pointer-events-none">“</div>
                    <div class="relative z-10">
                        <p class="text-stone-650 leading-relaxed text-sm font-light italic mb-6">
                            Había estado buscando empleo durante 6 meses. La iglesia se unió en oración y, contra todo pronóstico, me llamaron de una empresa para un puesto mejor del que esperaba. ¡Dios es fiel y escucha el clamor de su pueblo!
                        </p>
                    </div>
                    <div class="pt-4 border-t border-stone-100 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center text-xs font-bold text-white uppercase">
                            M
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-stone-900">María Delgado</h4>
                            <p class="text-[10px] text-stone-400">Junio 20, 2026</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-stone-200/40 p-8 shadow-sm flex flex-col justify-between relative group">
                    <div class="text-amber-900/10 text-6xl font-serif absolute top-4 left-6 pointer-events-none">“</div>
                    <div class="relative z-10">
                        <p class="text-stone-650 leading-relaxed text-sm font-light italic mb-6">
                            Mi hijo estuvo gravemente enfermo en el hospital con fiebre alta. Pedí oración al cuerpo de pastores y esa misma noche la fiebre desapareció por completo. Los médicos se sorprendieron de su rápida recuperación. ¡Toda la gloria sea para Dios!
                        </p>
                    </div>
                    <div class="pt-4 border-t border-stone-100 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center text-xs font-bold text-white uppercase">
                            J
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-stone-900">José Rivas</h4>
                            <p class="text-[10px] text-stone-400">Junio 18, 2026</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-stone-200/40 p-8 shadow-sm flex flex-col justify-between relative group">
                    <div class="text-amber-900/10 text-6xl font-serif absolute top-4 left-6 pointer-events-none">“</div>
                    <div class="relative z-10">
                        <p class="text-stone-650 leading-relaxed text-sm font-light italic mb-6">
                            Durante años luché con una gran ansiedad que no me dejaba dormir. Al comenzar a leer los devocionales de esta página y buscar la presencia del Señor en las noches, su paz inundó mi corazón. Hoy duermo en perfecta paz.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-stone-100 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center text-xs font-bold text-white uppercase">
                            E
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-stone-900">Elena Castro</h4>
                            <p class="text-[10px] text-stone-400">Junio 15, 2026</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
