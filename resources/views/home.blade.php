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

{{-- Versículo del Día --}}
<div class="bg-gradient-to-r from-blue-700 to-indigo-800 py-14">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <p class="text-blue-200 uppercase tracking-widest text-xs font-bold mb-6">✦ Versículo del Día ✦</p>
        <blockquote class="text-white text-2xl md:text-3xl font-serif italic leading-relaxed mb-6">
            "{{ $verse['text'] }}"
        </blockquote>
        <cite class="text-blue-300 font-semibold text-sm tracking-wide not-italic">— {{ $verse['reference'] }}</cite>
    </div>
</div>

<section id="recientes" class="max-w-7xl mx-auto px-4 py-20">
    <h2 class="text-4xl font-serif mb-8 text-center text-slate-800">Mensajes Recientes</h2>

    {{-- Filtro por Categoría --}}
    @if($categories->isNotEmpty())
    <div class="flex flex-wrap justify-center gap-3 mb-12">
        <a href="{{ route('blog') }}"
           class="px-5 py-2 rounded-full text-sm font-semibold border border-slate-200 text-slate-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200">
            Todos
        </a>
        @foreach($categories as $category)
        <a href="{{ route('blog', ['category' => $category->slug ?? $category->id]) }}"
           class="px-5 py-2 rounded-full text-sm font-semibold border border-slate-200 text-slate-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200">
            {{ $category->name }}
            <span class="ml-1 text-xs opacity-60">({{ $category->posts_count }})</span>
        </a>
        @endforeach
    </div>
    @endif

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
                <h3 class="text-2xl font-serif font-bold mb-3 text-slate-900 group-hover:text-blue-600 transition-colors">
                    {{ $post->title }}
                </h3>
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
            <div class="text-slate-300 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14 2v4a1 1 0 001 1h4" />
                </svg>
            </div>
            <p class="text-slate-500 font-serif italic text-lg">Próximamente más reflexiones de Luz y Paz...</p>
        </div>
        @endif
    </div>

    {{-- Botón Ver Todos --}}
    <div class="mt-20 mb-12 text-center">
        <a href="{{ route('blog') }}" class="inline-flex items-center gap-3 bg-slate-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
            Explorar todos los mensajes
            <span class="text-blue-300">&rarr;</span>
        </a>
    </div>

    {{-- Sección de Interacción / Comunidad --}}
    <div class="mt-24 bg-slate-50 rounded-[3rem] p-8 md:p-16 border border-slate-200">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-slate-900 mb-4">Caminemos Juntos</h2>
                <p class="text-slate-600">En Luz y Paz creemos en el poder de la unidad y el testimonio. ¿Cómo podemos acompañarte hoy?</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                {{-- Tarjeta Peticiones --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Peticiones de Oración</h3>
                    <p class="text-slate-500 text-sm mb-6">¿Necesitas oración? No estás solo. Comparte tu motivo y nuestra comunidad intercederá por ti.</p>
                    <a href="{{ route('prayers.index') }}" class="text-blue-600 font-bold flex items-center gap-2 hover:gap-3 transition-all">
                        Enviar mi petición <span>&rarr;</span>
                    </a>
                </div>

                {{-- Tarjeta Testimonios --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Compartir victoria</h3>
                    <p class="text-slate-500 text-sm mb-6">¿Dios ha hecho un milagro en tu vida? Tu historia puede fortalecer la fe de otros hermanos.</p>
                    <a href="{{ route('testimonials.share') }}" class="text-indigo-600 font-bold flex items-center gap-2 hover:gap-3 transition-all">
                        Contar mi testimonio <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
