@extends('layouts.app')

@section('title', 'Testimonios de Fe - Voces de Gracia')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12 sm:py-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-16 border-b border-stone-200/60 pb-8">
        <div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50/80 border border-amber-900/10 px-3 py-1.5 text-xs font-semibold tracking-wider uppercase text-amber-900 mb-4">
                ✨ Voces de Gratitud
            </span>
            <h1 class="text-4xl font-serif text-stone-950 font-bold tracking-tight">Testimonios de Fe</h1>
            <p class="text-stone-500 mt-2 text-sm max-w-xl">
                Lee los testimonios y relatos de fe que testifican de la gloria, el favor y la fidelidad inquebrantable de nuestro Creador.
            </p>
        </div>
        <div>
            <a 
                href="{{ route('testimonials.create') }}"
                class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 rounded-xl shadow-md shadow-amber-900/10 transition-all inline-flex items-center gap-2"
            >
                <span>+</span> Compartir mi Testimonio
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-10 p-4 bg-emerald-50 border border-emerald-200/30 rounded-2xl text-emerald-800 text-sm font-medium flex items-center gap-3">
            <span>✓</span> {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse($testimonials as $testimonial)
            <div class="bg-white rounded-3xl border border-stone-200/40 p-8 shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 relative group">
                <div class="text-amber-900/10 text-6xl font-serif absolute top-4 left-6 pointer-events-none">“</div>
                <div class="relative z-10">
                    <p class="text-stone-650 leading-relaxed text-sm font-light italic mb-8 line-clamp-6">
                        "{{ $testimonial->content }}"
                    </p>
                </div>
                <div class="pt-6 border-t border-stone-100 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-stone-400 to-stone-500 flex items-center justify-center text-xs font-bold text-white uppercase">
                            {{ substr($testimonial->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-stone-900">{{ $testimonial->name }}</h4>
                            <p class="text-[10px] text-stone-400">
                                {{ $testimonial->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <a 
                        href="{{ route('testimonials.show', $testimonial->id) }}" 
                        class="text-xs font-semibold text-amber-900 hover:underline inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform"
                    >
                        Leer y comentar &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-stone-200/40 shadow-sm space-y-3">
                <span class="text-4xl">🕊️</span>
                <h3 class="text-lg font-serif font-semibold text-stone-900">Aún no hay testimonios aprobados</h3>
                <p class="text-stone-400 text-sm max-w-md mx-auto">Sé el primero en compartir las maravillas que Dios ha hecho en tu vida haciendo clic en el botón superior.</p>
            </div>
        @endif
    </div>
</section>
@endsection
