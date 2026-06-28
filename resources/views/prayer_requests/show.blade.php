@extends('layouts.app')

@section('title', 'Petición de Oración de ' . $prayerRequest->name . ' - Voces de Gracia')

@section('content')
<article class="max-w-3xl mx-auto px-6 py-12 sm:py-20">
    <div class="mb-10">
        <a href="{{ route('prayer-requests.index') }}" class="text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-stone-750 inline-flex items-center gap-1.5 transition-colors">
            &larr; Volver a Peticiones
        </a>
    </div>

    <!-- Prayer Request card -->
    <div class="bg-white rounded-3xl border border-stone-200/40 p-8 sm:p-12 shadow-sm relative group mb-12">
        <div class="relative z-10 space-y-6">
            <div class="flex items-center justify-between gap-3 pb-4 border-b border-stone-100">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-amber-800 to-amber-950 flex items-center justify-center text-sm font-bold text-white uppercase">
                        {{ substr($prayerRequest->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-stone-900">{{ $prayerRequest->name }}</h4>
                        <p class="text-xs text-stone-400">
                            Publicado el {{ $prayerRequest->created_at->format('d \d\e F, Y') }}
                        </p>
                    </div>
                </div>
                
                @if($prayerRequest->status === 'prayed')
                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-800 rounded-full border border-blue-200/20">Orado</span>
                @elseif($prayerRequest->status === 'answered')
                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 rounded-full border border-emerald-250/20">Respondido</span>
                @else
                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-amber-50 text-amber-800 rounded-full border border-amber-900/10">Pendiente</span>
                @endif
            </div>

            <p class="text-stone-700 leading-relaxed text-lg font-light whitespace-pre-line">
                {{ $prayerRequest->message }}
            </p>
        </div>
    </div>

    <!-- Sección de Comentarios -->
    <div class="mt-16 pt-10 border-t border-stone-200/60">
        @include('partials.comments', ['model' => $prayerRequest, 'type' => 'prayer'])
    </div>
</article>
@endsection
