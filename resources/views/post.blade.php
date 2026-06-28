@extends('layouts.app')

@section('title', ($post->title ?? 'Artículo') . ' - Voces de Gracia')

@section('content')
<!-- Reading Progress Bar -->
<div id="reading-progress"></div>

<article class="max-w-2xl mx-auto px-6 py-12 sm:py-20">
    <!-- Post Header -->
    <header class="text-center mb-16">
        <div class="flex items-center justify-center gap-x-3 text-xs tracking-wider uppercase text-amber-900 font-semibold mb-6">
            <span>📖 Lectura Devocional</span>
            <span>&bull;</span>
            <time datetime="{{ isset($post) ? $post->created_at->toDateString() : '2026-06-18' }}">
                {{ isset($post) ? $post->created_at->format('F d, Y') : 'Junio 18, 2026' }}
            </time>
            @php $readTime = max(1, ceil(str_word_count(strip_tags($post->content ?? '')) / 200)); @endphp
            <span>&bull;</span>
            <span>⏱ {{ $readTime }} min de lectura</span>
        </div>
        
        <h1 class="text-4xl sm:text-5xl font-serif tracking-tight text-stone-900 font-bold leading-tight text-balance">
            {{ $post->title ?? 'La Gracia de Dios es Suficiente' }}
        </h1>
        
        <div class="mt-8 flex items-center justify-center gap-x-3 text-sm text-stone-500">
            <span>Por <span class="font-semibold text-stone-850">{{ $post->author->name ?? 'Autor Devocional' }}</span></span>
        </div>
    </header>

    <!-- Post Featured Image -->
    @if(isset($post) && $post->image_url)
        <div class="mb-12 rounded-3xl overflow-hidden shadow-sm aspect-video bg-stone-100">
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <!-- Post Content -->
    <div class="prose prose-stone max-w-none text-stone-700 leading-relaxed text-lg font-light text-pretty space-y-6">
        @if(isset($post))
            {!! nl2br(e($post->content)) !!}
        @else
            <!-- Contenido de prueba por defecto -->
            <p>
                La vida cristiana nos presenta constantes desafíos, tormentas inesperadas y vientos de duda. En medio de esas tempestades, la tentación de confiar en nuestras propias fuerzas es enorme. Sin embargo, la Escritura nos revela una maravillosa verdad en la cual descansar: su gracia es suficiente para nosotros.
            </p>
            <p class="font-serif italic text-xl text-amber-900 pl-4 border-l-2 border-amber-800/40 my-8 py-1">
                "Y me ha dicho: Bástate mi gracia; porque mi poder se perfecciona en la debilidad." — 2 Corintios 12:9
            </p>
            <p>
                Pablo, al escribir a los Corintios, compartía sobre su "aguijón en la carne". Rogó tres veces para que le fuera quitado, pero la respuesta divina no fue remover el dolor, sino darle una revelación de suficiencia. La gracia no es solo el favor inmerecido que nos salva; es el poder capacitador que nos sostiene cuando ya no podemos dar un paso más.
            </p>
            <p>
                Cuando reconozcas tu debilidad, no te desanimes. Ese es precisamente el escenario donde el poder de Dios encuentra su máximo esplendor. La debilidad humana permite que la gracia brille con toda su pureza, sin mezclas de gloria propia ni méritos personales. Hoy, descansa en que no depende de tus fuerzas, sino del poder de Aquel que te llamó.
            </p>
        @endif
    </div>

    <!-- Share Buttons -->
    <div class="mt-12 pt-8 border-t border-stone-200/60">
        <p class="text-xs font-semibold uppercase tracking-widest text-stone-400 text-center mb-4">¿Te bendijo? Compártelo</p>
        <div class="flex items-center justify-center gap-3">
            <!-- WhatsApp -->
            <a href="https://wa.me/?text={{ urlencode($post->title ?? 'Artículo') }}%20{{ urlencode(url()->current()) }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100/60 text-emerald-850 rounded-xl border border-emerald-200/40 text-xs font-semibold transition-colors">
                🟢 WhatsApp
            </a>
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2.5 bg-blue-50 hover:bg-blue-100/60 text-blue-750 rounded-xl border border-blue-200/40 text-xs font-semibold transition-colors">
                📘 Facebook
            </a>
            <!-- Copy Link -->
            <button id="btn-copy-link" onclick="copyArticleLink()"
               class="flex items-center gap-2 px-4 py-2.5 bg-stone-100 hover:bg-stone-200/60 text-stone-700 rounded-xl border border-stone-200/40 text-xs font-semibold transition-colors">
                🔗 <span id="copy-label">Copiar enlace</span>
            </button>
        </div>
    </div>

    <!-- Post Footer / Author Bio -->
    <footer class="mt-12 pt-10 border-t border-stone-200/60">
        <div class="bg-amber-50/20 border border-amber-900/5 rounded-3xl p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="h-14 w-14 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center font-bold text-lg text-white shadow-sm flex-shrink-0">
                {{ substr($post->author->name ?? 'A', 0, 1) }}
            </div>
            <div class="text-center sm:text-left space-y-2">
                <p class="text-xs font-semibold tracking-widest uppercase text-amber-900">Sobre el Autor</p>
                <h4 class="text-base font-semibold text-stone-900">{{ $post->author->name ?? 'Pastor Autor' }}</h4>
                <p class="text-xs text-stone-500 leading-relaxed">
                    Escritor colaborador de Voces de Gracia. Apasionado por la doctrina bíblica, la enseñanza pastoral y el discipulado.
                </p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="/" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-stone-500 hover:text-amber-900 transition-colors">
                &larr; Volver a los artículos
            </a>
        </div>
    </footer>

    <!-- Sección de Comentarios -->
    <div class="mt-16 pt-10 border-t border-stone-200/60">
        @include('partials.comments', ['model' => $post, 'type' => 'post'])
    </div>
</article>

<script>
    // Reading progress bar
    const progressBar = document.getElementById('reading-progress');
    const article = document.querySelector('article');
    window.addEventListener('scroll', () => {
        if (!article || !progressBar) return;
        const articleTop = article.offsetTop;
        const articleHeight = article.offsetHeight;
        const scrolled = window.scrollY - articleTop;
        const progress = Math.min(Math.max(scrolled / articleHeight, 0), 1) * 100;
        progressBar.style.width = progress + '%';
    });

    // Copy link
    function copyArticleLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const label = document.getElementById('copy-label');
            label.textContent = '¡Copiado!';
            setTimeout(() => label.textContent = 'Copiar enlace', 2000);
        });
    }
</script>
@endsection
