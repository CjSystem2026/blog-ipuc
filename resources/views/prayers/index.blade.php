@extends('layouts.public')

@section('title', 'Peticiones de Oración')

@section('content')
<div class="bg-slate-50 min-h-screen py-20">
    <div class="max-w-4xl mx-auto px-4">
        <header class="text-center mb-16">
            <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-4 block">✦ Comunidad de Oración ✦</span>
            <h1 class="text-5xl font-serif text-slate-900 mb-6">Muro de Intercesión</h1>
            <p class="text-slate-600 text-lg max-w-2xl mx-auto">
                "Donde están dos o tres congregados en mi nombre, allí estoy yo en medio de ellos." 
                <span class="italic block mt-2">— Mateo 18:20</span>
            </p>
        </header>

        <div class="grid gap-12">
            {{-- Formulario de Envío --}}
            <section class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100">
                <h2 class="text-2xl font-serif text-slate-800 mb-8">Enviar Petición</h2>
                
                @auth
                    <form action="{{ route('prayers.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="body" class="block text-sm font-medium text-slate-700 mb-2">¿Cuál es tu petición?</label>
                                <textarea name="body" id="body" rows="4" 
                                    class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all" 
                                    placeholder="Escribe aquí tu motivo de oración..." required></textarea>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="is_anonymous" id="is_anonymous" 
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <label for="is_anonymous" class="ml-2 text-sm text-slate-600">Publicar de forma anónima</label>
                            </div>

                            <button type="submit" 
                                class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                                Enviar Motivo
                            </button>
                        </div>
                    </form>
                    
                    @if(session('success'))
                        <div class="mt-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-100 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <p class="text-slate-600 mb-4">Debes iniciar sesión para compartir una petición.</p>
                        <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Iniciar Sesión &rarr;</a>
                    </div>
                @endauth
            </section>

            {{-- Listado de Peticiones --}}
            <section class="space-y-8">
                <h2 class="text-2xl font-serif text-slate-800 border-b border-slate-200 pb-4">Peticiones Recientes</h2>
                
                @forelse($prayers as $prayer)
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-tighter">
                                {{ $prayer->is_anonymous ? 'Petición Anónima' : $prayer->user->name }}
                            </span>
                            <span class="text-xs text-slate-400 italic">
                                {{ $prayer->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-slate-700 text-lg leading-relaxed font-serif">
                            "{{ $prayer->body }}"
                        </p>
                        <div class="mt-6 flex items-center gap-4">
                            <button class="flex items-center gap-2 text-slate-400 hover:text-blue-600 transition group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:fill-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="text-sm font-medium">Amén ({{ $prayer->amen_count }})</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 text-slate-400">
                        <p class="italic">No hay peticiones públicas en este momento. ¡Sé el primero en compartir!</p>
                    </div>
                @endforelse

                <div class="mt-10">
                    {{ $prayers->links() }}
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
