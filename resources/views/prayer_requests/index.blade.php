@extends('layouts.app')

@section('title', 'Peticiones de Oración - Voces de Gracia')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-12 sm:py-20">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-16 border-b border-stone-200/60 pb-8">
        <div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50/80 border border-amber-900/10 px-3 py-1.5 text-xs font-semibold tracking-wider uppercase text-amber-900 mb-4">
                🙏 Intercesión Mutua
            </span>
            <h1 class="text-4xl font-serif text-stone-950 font-bold tracking-tight">Peticiones de Oración</h1>
            <p class="text-stone-500 mt-2 text-sm max-w-xl">
                Uníos en oración por las necesidades de nuestros hermanos. La oración del justo es poderosa y eficaz (Santiago 5:16).
            </p>
        </div>
        <div>
            <a 
                href="/#oracion"
                class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 rounded-xl shadow-md shadow-amber-900/10 transition-all inline-flex items-center gap-2"
            >
                <span>+</span> Pedir Oración
            </a>
        </div>
    </div>

    <div class="grid gap-8 md:grid-cols-2">
        @forelse($prayerRequests as $request)
            <div class="bg-white rounded-3xl border border-stone-200/40 p-8 shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300 relative group">
                <div>
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-stone-900">{{ $request->name }}</span>
                            <span class="text-stone-300 text-xs">&bull;</span>
                            <span class="text-[10px] text-stone-400">
                                {{ $request->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        
                        <!-- Status badge -->
                        @if($request->status === 'prayed')
                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider bg-blue-50 text-blue-800 rounded-md border border-blue-200/20">Orado</span>
                        @elseif($request->status === 'answered')
                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 rounded-md border border-emerald-250/20">Respondido</span>
                        @else
                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 rounded-md border border-amber-900/10">Pendiente</span>
                        @endif
                    </div>
                    
                    <p class="text-stone-650 leading-relaxed text-sm font-light mb-6 line-clamp-4">
                        {{ $request->message }}
                    </p>
                </div>
                
                <div class="pt-4 border-t border-stone-100 flex items-center justify-end">
                    <a 
                        href="{{ route('prayer-requests.show', $request->id) }}" 
                        class="text-xs font-semibold text-amber-900 hover:underline inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform"
                    >
                        Unirse en oración y comentar &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-stone-200/40 shadow-sm space-y-3">
                <span class="text-4xl">🙏</span>
                <h3 class="text-lg font-serif font-semibold text-stone-900">No hay peticiones públicas activas</h3>
                <p class="text-stone-400 text-sm max-w-md mx-auto">Sé el primero en compartir tu petición pública para que la congregación se una en intercesión.</p>
            </div>
        @endif
    </div>
</section>
@endsection
