@extends('layouts.app')

@section('title', 'Compartir Testimonio - Voces de Gracia')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-12 sm:py-20">
    <div class="mb-10 flex flex-col gap-2">
        <a href="{{ route('testimonials.index') }}" class="text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-stone-750 inline-flex items-center gap-1.5 transition-colors">
            &larr; Volver a Testimonios
        </a>
        <h1 class="text-3xl font-serif text-stone-950 font-bold tracking-tight mt-2">Comparte tu Testimonio</h1>
        <p class="text-stone-500 text-sm max-w-xl">
            Cuéntanos cómo Dios ha bendecido, sanado o respondido a tu clamor. Tu testimonio puede ser la luz que otra persona necesita hoy.
        </p>
    </div>

    <div class="bg-white rounded-3xl border border-stone-200/60 p-8 shadow-sm">
        <form action="{{ route('testimonials.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Nombre -->
            <div class="space-y-1.5">
                <label for="name" class="text-xs font-semibold tracking-wider uppercase text-stone-500">Tu Nombre (Opcional)</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    value="{{ old('name') }}"
                    placeholder="Ej. Anónimo o tu nombre"
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-900"
                >
                @error('name')
                    <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Testimonio -->
            <div class="space-y-1.5">
                <label for="content" class="text-xs font-semibold tracking-wider uppercase text-stone-500">Tu Testimonio o Relato</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="8" 
                    placeholder="Describe aquí las maravillas que Dios ha hecho en tu vida..."
                    required
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-900 leading-relaxed font-light"
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-xs text-red-650 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <p class="text-[11px] text-stone-400 italic">
                * Nota: Al enviar tu testimonio, pasará por una revisión de moderación pastoral antes de ser publicado en la sección pública.
            </p>

            <!-- Actions -->
            <div class="pt-4 border-t border-stone-100 flex items-center justify-end gap-4">
                <a 
                    href="{{ route('testimonials.index') }}"
                    class="px-5 py-2.5 text-xs font-semibold uppercase tracking-wider text-stone-500 hover:text-stone-850 transition-colors"
                >
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 rounded-xl shadow-md shadow-amber-900/10 transition-all"
                >
                    Enviar Testimonio
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
