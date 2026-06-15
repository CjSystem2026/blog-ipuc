@extends('layouts.public')

@section('title', $post->title)

@section('content')
<article class="max-w-4xl mx-auto px-4 py-16">

    {{-- Categoría + Fecha --}}
    <div class="flex items-center gap-3 mb-6">
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
            {{ $post->category->name }}
        </span>
        <span class="text-slate-400 text-sm">
            {{ $post->published_at->format('d \d\e F, Y') }}
        </span>
    </div>

    {{-- Título --}}
    <h1 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 leading-tight mb-8">
        {{ $post->title }}
    </h1>

    {{-- Imagen de Portada --}}
    @if($post->image)
    <div class="rounded-3xl overflow-hidden mb-10 shadow-lg aspect-video">
        <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
    </div>
    @endif

    {{-- Extracto --}}
    @if($post->excerpt)
    <p class="text-xl text-slate-600 font-serif italic border-l-4 border-blue-400 pl-6 mb-10 leading-relaxed">
        {{ $post->excerpt }}
    </p>
    @endif

    {{-- Contenido Principal --}}
    <div class="prose prose-slate prose-lg max-w-none leading-relaxed text-slate-700">
        {!! nl2br(e($post->body)) !!}
    </div>

    {{-- Pie de Artículo --}}
    <div class="mt-16 pt-8 border-t border-slate-200 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <span class="text-blue-700 font-bold text-sm">
                    {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                </span>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-800">{{ $post->user->name ?? 'Administrador' }}</p>
                <p class="text-xs text-slate-400">Autor</p>
            </div>
        </div>
        <a href="/" class="text-blue-600 font-medium text-sm flex items-center gap-2 hover:underline">
            ← Volver al inicio
        </a>
    </div>

</article>
@endsection
