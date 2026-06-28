import React from 'react';
import { useForm, Link } from '@inertiajs/react';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout';

export default function PostForm({ auth, post = null }) {
    const isEditing = !!post;
    
    const { data, setData, post: submitPost, processing, errors } = useForm({
        title: post?.title || '',
        excerpt: post?.excerpt || '',
        content: post?.content || '',
        image: null,
        _method: isEditing ? 'PUT' : 'POST',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        if (isEditing) {
            submitPost(`/admin/posts/${post.id}`);
        } else {
            submitPost('/admin/posts');
        }
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            {/* Header */}
            <div className="mb-8 flex flex-col gap-2">
                <Link href="/admin" className="text-xs font-semibold uppercase tracking-wider text-stone-400 hover:text-stone-750 inline-flex items-center gap-1.5 transition-colors">
                    &larr; Volver al Dashboard
                </Link>
                <h3 className="text-2xl font-serif text-stone-900 font-bold mt-2">
                    {isEditing ? 'Editar Artículo' : 'Redactar Nuevo Artículo'}
                </h3>
                <p className="text-sm text-stone-500">
                    {isEditing ? 'Modifica los campos del artículo ya publicado.' : 'Escribe una nueva enseñanza o devocional para edificación de la iglesia.'}
                </p>
            </div>

            {/* Form Container */}
            <div className="bg-white rounded-3xl border border-stone-200/60 p-8 shadow-sm max-w-3xl">
                <form onSubmit={handleSubmit} className="space-y-6">
                    {/* Title */}
                    <div className="space-y-1.5">
                        <label htmlFor="title" className="text-xs font-semibold tracking-wider uppercase text-stone-500">
                            Título del Artículo
                        </label>
                        <input 
                            type="text" 
                            id="title"
                            value={data.title}
                            onChange={e => setData('title', e.target.value)}
                            className="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm font-medium text-stone-900"
                            placeholder="Ej. El poder de la oración ferviente"
                            required
                        />
                        {errors.title && (
                            <p className="text-xs text-red-600 mt-1 font-semibold">{errors.title}</p>
                        )}
                    </div>

                    {/* Excerpt */}
                    <div className="space-y-1.5">
                        <label htmlFor="excerpt" className="text-xs font-semibold tracking-wider uppercase text-stone-500">
                            Extracto o Resumen Corto
                        </label>
                        <textarea 
                            id="excerpt"
                            rows="2"
                            value={data.excerpt}
                            onChange={e => setData('excerpt', e.target.value)}
                            className="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-850"
                            placeholder="Una breve descripción para captar la atención de los lectores..."
                        />
                        {errors.excerpt && (
                            <p className="text-xs text-red-600 mt-1 font-semibold">{errors.excerpt}</p>
                        )}
                    </div>

                    {/* Content */}
                    <div className="space-y-1.5">
                        <label htmlFor="content" className="text-xs font-semibold tracking-wider uppercase text-stone-500">
                            Mensaje o Contenido Completo
                        </label>
                        <textarea 
                            id="content"
                            rows="12"
                            value={data.content}
                            onChange={e => setData('content', e.target.value)}
                            className="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-850 font-light leading-relaxed"
                            placeholder="Escribe aquí el contenido completo inspirado en la palabra..."
                            required
                        />
                        {errors.content && (
                            <p className="text-xs text-red-600 mt-1 font-semibold">{errors.content}</p>
                        )}
                    </div>

                    {/* Image Upload */}
                    <div className="space-y-1.5">
                        <label htmlFor="image" className="text-xs font-semibold tracking-wider uppercase text-stone-500 block">
                            Imagen de Portada (Opcional)
                        </label>
                        {post?.image_url && (
                            <div className="mb-3 max-w-xs rounded-xl overflow-hidden shadow-sm aspect-video bg-stone-100">
                                <img src={post.image_url} alt="Portada actual" className="w-full h-full object-cover" />
                            </div>
                        )}
                        <input 
                            type="file" 
                            id="image"
                            onChange={e => setData('image', e.target.files[0])}
                            className="w-full text-sm text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:uppercase file:tracking-wider file:bg-amber-50 file:text-amber-900 hover:file:bg-amber-100 file:cursor-pointer transition-colors"
                            accept="image/*"
                        />
                        {errors.image && (
                            <p className="text-xs text-red-600 mt-1 font-semibold">{errors.image}</p>
                        )}
                    </div>

                    {/* Actions */}
                    <div className="pt-4 border-t border-stone-100 flex items-center justify-end gap-4">
                        <Link 
                            href="/admin"
                            className="px-5 py-2.5 text-xs font-semibold uppercase tracking-wider text-stone-500 hover:text-stone-800 transition-colors"
                        >
                            Cancelar
                        </Link>
                        <button 
                            type="submit" 
                            disabled={processing}
                            className="px-6 py-2.5 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 disabled:bg-stone-300 rounded-xl shadow-md shadow-amber-900/10 transition-all"
                        >
                            {processing ? 'Guardando...' : (isEditing ? 'Actualizar Artículo' : 'Publicar Artículo')}
                        </button>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
