@extends('layouts.public')

@section('title', 'Compartir Testimonio')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-serif font-bold text-slate-900 mb-4">Compartir mi Testimonio</h1>
        <p class="text-slate-600">Tu historia de fe puede ser la luz que alguien más necesita hoy. Cuéntanos lo que Dios ha hecho en tu vida.</p>
    </div>

    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-8">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 p-8 md:p-12">
        <form action="{{ route('testimonials.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Tu Nombre</label>
                    <input type="text" name="name" id="name" required 
                           class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all"
                           placeholder="Ej: Juan Pérez">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Título de tu historia</label>
                    <input type="text" name="title" id="title" required 
                           class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all"
                           placeholder="Ej: Un milagro de sanidad">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="body" class="block text-sm font-bold text-slate-700 mb-2">Tu Testimonio</label>
                <textarea name="body" id="body" rows="10" required 
                          class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all"
                          placeholder="Escribe aquí lo que Dios ha hecho..."></textarea>
                @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 flex items-start gap-4">
                <div class="text-blue-600 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-sm text-blue-800 leading-relaxed">
                    <strong>Nota:</strong> Para mantener la armonía del blog, tu testimonio será revisado por un administrador antes de ser publicado. ¡Gracias por edificar a la iglesia!
                </p>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg hover:shadow-xl active:scale-95">
                    Enviar mi Testimonio
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 text-center">
        <a href="/" class="text-slate-400 hover:text-blue-600 transition text-sm">← Volver al inicio</a>
    </div>
</div>
@endsection
