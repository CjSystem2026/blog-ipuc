<!-- Formulario de comentarios y listado -->
<div class="space-y-10">
    <div class="flex items-center justify-between border-b border-stone-200/60 pb-4">
        <h3 class="text-lg font-serif font-bold text-stone-950 flex items-center gap-2">
            <span>💬</span>
            <span>Comentarios ({{ $model->comments->count() }})</span>
        </h3>
    </div>

    @if(session('success') && str_contains(session('success'), 'comentario'))
        <div class="p-4 bg-emerald-50 border border-emerald-250/20 rounded-2xl text-emerald-800 text-sm font-medium flex items-center gap-3">
            <span>✓</span> {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para agregar comentario -->
    <div class="bg-stone-50/50 border border-stone-200/40 rounded-3xl p-6 sm:p-8">
        <h4 class="text-xs font-semibold uppercase tracking-wider text-stone-500 mb-4">Deja tu comentario o mensaje</h4>
        <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="commentable_id" value="{{ $model->id }}">
            <input type="hidden" name="commentable_type" value="{{ $type }}">

            @guest
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label for="guest_name" class="text-[10px] font-semibold uppercase tracking-wider text-stone-400">Tu Nombre (Invitado)</label>
                        <input 
                            type="text" 
                            name="guest_name" 
                            id="guest_name" 
                            placeholder="Ej. Anónimo o tu nombre"
                            class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-white outline-none transition-all text-xs text-stone-900"
                        >
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2 text-xs text-stone-500 font-medium">
                    <span>👤 Comentando como</span>
                    <span class="text-amber-900 font-bold">{{ auth()->user()->name }}</span>
                </div>
            @endguest

            <div class="space-y-1.5">
                <label for="content" class="text-[10px] font-semibold uppercase tracking-wider text-stone-400">Mensaje</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="4" 
                    placeholder="Escribe tu palabra de aliento, fe o comentario aquí..."
                    required
                    class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-white outline-none transition-all text-xs text-stone-900 leading-relaxed"
                ></textarea>
            </div>

            <div class="text-right">
                <button 
                    type="submit" 
                    class="w-full sm:w-auto px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 rounded-xl transition-all shadow-md shadow-amber-900/10"
                >
                    Publicar Comentario
                </button>
            </div>
        </form>
    </div>

    <!-- Listado de comentarios -->
    <div class="space-y-6">
        @forelse($model->comments as $comment)
            <div class="flex gap-4 items-start p-6 bg-white rounded-3xl border border-stone-200/30 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-stone-100 to-stone-200 border border-stone-200/40 flex items-center justify-center text-xs font-bold text-stone-700 uppercase flex-shrink-0">
                    {{ substr($comment->author_name, 0, 1) }}
                </div>
                <div class="space-y-2 flex-1 min-w-0">
                    <div class="flex flex-wrap items-baseline justify-between gap-x-2">
                        <h5 class="text-xs font-semibold text-stone-900">
                            {{ $comment->author_name }}
                            @if($comment->user)
                                <span class="ml-1 px-1.5 py-0.5 text-[9px] font-bold text-amber-800 bg-amber-50 rounded-md border border-amber-900/5">Autor</span>
                            @endif
                        </h5>
                        <span class="text-[10px] text-stone-400">
                            {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-xs text-stone-650 leading-relaxed whitespace-pre-line text-pretty">
                        {{ $comment->content }}
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-stone-50/30 rounded-3xl border border-dashed border-stone-250/50">
                <span class="text-2xl">💬</span>
                <p class="text-xs text-stone-400 mt-2">Aún no hay comentarios. ¡Sé el primero en comentar!</p>
            </div>
        @endif
    </div>
</div>
