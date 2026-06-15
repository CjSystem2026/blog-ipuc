@extends('layouts.public')

@section('title', 'Todos los Artículos')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16">

    {{-- Encabezado --}}
    <div class="text-center mb-10">
        <h1 class="text-5xl font-serif font-bold text-slate-900 mb-4">Todos los Mensajes</h1>
        <p class="text-slate-500 text-lg max-w-xl mx-auto">Reflexiones, testimonios y estudios bíblicos para tu crecimiento espiritual.</p>
    </div>

    {{-- Filtro por Categoría --}}
    @if(isset($categories) && $categories->isNotEmpty())
    <div class="flex flex-wrap justify-center gap-3 mb-12">
        <a href="{{ route('blog') }}"
           class="px-5 py-2 rounded-full text-sm font-semibold border transition-all duration-200 {{ !$activeCategoryId ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-200 text-slate-600 hover:bg-blue-600 hover:text-white hover:border-blue-600' }}">
            Todos
        </a>
        @foreach($categories as $category)
        <a href="{{ route('blog', ['category' => $category->id]) }}"
           class="px-5 py-2 rounded-full text-sm font-semibold border transition-all duration-200 {{ $activeCategoryId == $category->id ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-200 text-slate-600 hover:bg-blue-600 hover:text-white hover:border-blue-600' }}">
            {{ $category->name }}
            <span class="ml-1 text-xs opacity-70">({{ $category->posts_count }})</span>
        </a>
        @endforeach
    </div>
    @endif

    {{-- Grid de Posts --}}
    <div class="grid md:grid-cols-3 gap-10">
        @foreach($posts as $post)
        <article class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="aspect-video bg-slate-100 relative overflow-hidden">
                @if($post->image)
                    <img src="{{ $post->image }}" alt="{{ $post->title }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="bg-white/90 backdrop-blur-sm text-blue-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">
                        {{ $post->category->name }}
                    </span>
                </div>
            </div>
            <div class="p-8">
                <h2 class="text-2xl font-serif font-bold mb-3 text-slate-900 group-hover:text-blue-600 transition-colors">
                    {{ $post->title }}
                </h2>
                <p class="text-slate-600 text-sm mb-6 line-clamp-3 leading-relaxed">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
                </p>
                <div class="flex items-center justify-between mt-auto pt-6 border-t border-slate-50">
                    <span class="text-xs text-slate-400 font-medium">
                        {{ $post->published_at->format('d M, Y') }}
                    </span>
                    <a href="{{ route('post.show', $post->slug) }}" class="text-blue-600 font-bold text-sm flex items-center gap-1 group/link">
                        Leer más
                        <span class="group-hover/link:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>
        </article>
        @endforeach

        @if($posts->isEmpty())
        <div class="col-span-full py-20 text-center">
            <p class="text-slate-500 font-serif italic text-lg">Próximamente más reflexiones de Luz y Paz...</p>
        </div>
        @endif
    </div>

    {{-- Paginación --}}
    @if($posts->hasPages())
    <div class="mt-16 flex justify-center gap-2">
        @if($posts->onFirstPage())
            <span class="px-4 py-2 rounded-full text-slate-300 border border-slate-200 text-sm cursor-not-allowed">&larr; Anterior</span>
        @else
            <a href="{{ $posts->previousPageUrl() }}" class="px-4 py-2 rounded-full text-slate-600 border border-slate-200 hover:border-blue-400 hover:text-blue-600 transition text-sm">&larr; Anterior</a>
        @endif

        <span class="px-4 py-2 text-slate-500 text-sm">
            Página {{ $posts->currentPage() }} de {{ $posts->lastPage() }}
        </span>

        @if($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}" class="px-4 py-2 rounded-full text-slate-600 border border-slate-200 hover:border-blue-400 hover:text-blue-600 transition text-sm">Siguiente &rarr;</a>
        @else
            <span class="px-4 py-2 rounded-full text-slate-300 border border-slate-200 text-sm cursor-not-allowed">Siguiente &rarr;</span>
        @endif
    </div>
    @endif

    {{-- Vuelta al inicio --}}
    <div class="mt-12 text-center">
        <a href="/" class="text-slate-400 hover:text-blue-600 transition text-sm">← Volver al inicio</a>
    </div>

</div>
@endsection
