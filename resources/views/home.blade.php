@extends('layouts.public')

@section('title', 'Bienvenido')

@section('content')
<div class="relative py-20 overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-5xl md:text-7xl font-serif text-slate-900 mb-6 tracking-tight">
            Un espacio de <span class="text-blue-600italics">Luz y Paz</span>
        </h1>
        <p class="text-xl text-slate-600 max-w-2xl mx-auto mb-10">
            Diferentes artículos, testimonios y reflexiones inspiradas en la Palabra de Dios para tu crecimiento espiritual.
        </p>
        <div class="flex justify-center gap-4">
            <a href="#recientes" class="bg-slate-900 text-white px-8 py-3 rounded-full font-medium hover:bg-slate-800 transition shadow-lg">
                Leer últimos artículos
            </a>
        </div>
    </div>
</div>

<section id="recientes" class="max-w-7xl mx-auto px-4 py-20">
    <h2 class="text-3xl font-serif mb-12 text-center text-slate-800">Recientemente publicado</h2>
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Placeholder para artículos -->
        <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="h-48 bg-slate-100 rounded-xl mb-4"></div>
            <h3 class="text-xl font-bold mb-2">Iniciando nuestro camino</h3>
            <p class="text-slate-600 text-sm mb-4">Un breve mensaje de bienvenida a este nuevo portal...</p>
            <a href="#" class="text-blue-600 font-semibold text-sm">Leer más &rarr;</a>
        </div>
    </div>
</section>
@endsection
