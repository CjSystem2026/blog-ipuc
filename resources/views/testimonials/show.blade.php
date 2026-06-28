@extends('layouts.app')

@section('title', 'Testimonio de ' . $testimonial->name . ' - Voces de Gracia')

@section('content')
<article class="max-w-3xl mx-auto px-6 py-12 sm:py-20">
    <div class="mb-10">
        <a href="{{ route('testimonials.index') }}" class="text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-stone-750 inline-flex items-center gap-1.5 transition-colors">
            &larr; Volver a Testimonios
        </a>
    </div>

    <!-- Testimony content card -->
    <div class="bg-white rounded-3xl border border-stone-200/40 p-8 sm:p-12 shadow-sm relative group mb-12">
        <div class="text-amber-900/10 text-8xl font-serif absolute top-4 left-6 pointer-events-none">“</div>
        <div class="relative z-10 space-y-6">
            <p class="text-stone-750 leading-relaxed text-lg font-light italic whitespace-pre-line">
                "{{ $testimonial->content }}"
            </p>
            
            <div class="pt-8 border-t border-stone-100 flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center text-sm font-bold text-white uppercase">
                    {{ substr($testimonial->name, 0, 1) }}
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-stone-900">{{ $testimonial->name }}</h4>
                    <p class="text-xs text-stone-400">
                        Compartido el {{ $testimonial->created_at->format('d \d\e F, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Comentarios -->
    <div class="mt-16 pt-10 border-t border-stone-200/60">
        @include('partials.comments', ['model' => $testimonial, 'type' => 'testimonial'])
    </div>
</article>
@endsection
