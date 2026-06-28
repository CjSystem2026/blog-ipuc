@extends('layouts.app')

@section('title', 'Artículos - IPUC Voces de Gracia')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12 sm:py-20">
    <!-- Header -->
    <header class="text-center mb-16 reveal">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50/80 border border-amber-900/10 px-3 py-1.5 text-xs font-semibold tracking-wider uppercase text-amber-900 mb-4">
            📚 Colección Completa
        </span>
        <h1 class="text-4xl sm:text-5xl font-serif tracking-tight text-stone-900 font-bold leading-tight">
            Artículos y Devocionales
        </h1>
        <p class="mt-4 text-stone-500 max-w-xl mx-auto text-sm leading-relaxed">
            Explora todas las reflexiones, enseñanzas de la doctrina de la Unicidad de Dios y estudios teológicos compartidos por nuestros pastores y líderes.
        </p>
    </header>

    @if(isset($posts) && $posts->count() > 0)
        <!-- Grid -->
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

        <!-- Custom Pagination -->
        <div class="mt-16 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-stone-200/60 pt-6 reveal">
            <div>
                <p class="text-xs text-stone-500">
                    Mostrando <span class="font-medium">{{ $posts->firstItem() ?? 0 }}</span> a <span class="font-medium">{{ $posts->lastItem() ?? 0 }}</span> de <span class="font-medium">{{ $posts->total() }}</span> artículos
                </p>
            </div>
            <div class="flex gap-2">
                @if ($posts->onFirstPage())
                    <span class="px-4 py-2 text-xs font-semibold text-stone-400 bg-stone-100 rounded-xl border border-stone-200/40 cursor-not-allowed">Anterior</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="px-4 py-2 text-xs font-semibold text-stone-750 bg-white hover:bg-stone-50 rounded-xl border border-stone-200/60 transition-colors shadow-sm">Anterior</a>
                @endif

                @if ($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="px-4 py-2 text-xs font-semibold text-stone-750 bg-white hover:bg-stone-50 rounded-xl border border-stone-200/60 transition-colors shadow-sm">Siguiente</a>
                @else
                    <span class="px-4 py-2 text-xs font-semibold text-stone-400 bg-stone-100 rounded-xl border border-stone-200/40 cursor-not-allowed">Siguiente</span>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white border border-stone-200/40 rounded-3xl max-w-md mx-auto reveal">
            <span class="text-4xl">📖</span>
            <h3 class="text-base font-semibold text-stone-900 mt-4">No hay artículos publicados</h3>
            <p class="text-xs text-stone-500 mt-2 max-w-xs mx-auto">Regresa pronto para leer las reflexiones de nuestros pastores.</p>
            <a href="/" class="mt-6 inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-stone-700 bg-stone-150 hover:bg-stone-200 rounded-xl transition-all">
                Volver al inicio
            </a>
        </div>
    @endif
</div>
@endsection
