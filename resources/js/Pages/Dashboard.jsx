import React from 'react';
import { Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout';

export default function Dashboard({ auth, posts = [] }) {
    const isSystemAdmin = auth?.user?.role === 'admin';
    
    const handleDelete = (id) => {
        if (confirm('¿Estás seguro de que deseas eliminar este artículo?')) {
            router.delete(`/admin/posts/${id}`, {
                onSuccess: () => alert('Artículo eliminado con éxito')
            });
        }
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            {/* Header section inside main content */}
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h3 className="text-2xl font-serif text-stone-900 font-bold">
                        {isSystemAdmin ? 'Todos los Artículos' : 'Mis Artículos'}
                    </h3>
                    <p className="text-sm text-stone-500 mt-1">
                        {isSystemAdmin ? 'Gestiona todos los escritos de la plataforma.' : 'Gestiona tus escritos publicados y borradores.'}
                    </p>
                </div>
                <Link 
                    href="/admin/posts/create" 
                    className="w-full sm:w-auto px-5 py-2.5 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 rounded-xl shadow-md shadow-amber-900/10 transition-all flex items-center justify-center gap-2"
                >
                    <span>+</span> Redactar Artículo
                </Link>
            </div>

            {/* Posts Table */}
            <div className="bg-white rounded-3xl border border-stone-200/60 overflow-hidden shadow-sm">
                {posts.length > 0 ? (
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="bg-stone-50 border-b border-stone-100 text-stone-500 uppercase tracking-widest text-[10px] font-semibold">
                                    <th className="py-4 px-6">Título</th>
                                    {isSystemAdmin && <th className="py-4 px-6">Autor</th>}
                                    <th className="py-4 px-6">Fecha</th>
                                    <th className="py-4 px-6 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-stone-100 text-sm">
                                {posts.map((post) => (
                                    <tr key={post.id} className="hover:bg-stone-50/40 transition-colors">
                                        <td className="py-4 px-6 font-medium text-stone-900">
                                            <div className="max-w-md">
                                                <Link href={`/posts/${post.slug}`} className="hover:text-amber-800 hover:underline">
                                                    {post.title}
                                                </Link>
                                                <p className="text-xs text-stone-400 mt-1 truncate">
                                                    {post.excerpt || 'Sin extracto'}
                                                </p>
                                            </div>
                                        </td>
                                        {isSystemAdmin && (
                                            <td className="py-4 px-6 text-stone-600 font-medium">
                                                {post.author?.name || 'Autor Desconocido'}
                                            </td>
                                        )}
                                        <td className="py-4 px-6 text-stone-500">
                                            {new Date(post.created_at).toLocaleDateString('es-ES', {
                                                year: 'numeric',
                                                month: 'short',
                                                day: 'numeric'
                                            })}
                                        </td>
                                        <td className="py-4 px-6 text-right space-x-2">
                                            <Link 
                                                href={`/admin/posts/${post.id}/edit`} 
                                                className="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-stone-600 hover:text-stone-900 hover:bg-stone-100 rounded-lg border border-stone-200 transition-all"
                                            >
                                                Editar
                                            </Link>
                                            <button 
                                                onClick={() => handleDelete(post.id)}
                                                className="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-600 hover:text-red-750 hover:bg-red-50/40 rounded-lg border border-transparent hover:border-red-100 transition-all"
                                            >
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="py-16 text-center text-stone-450 flex flex-col items-center justify-center p-6">
                        <span className="text-4xl mb-4">✍️</span>
                        <h4 className="text-base font-semibold text-stone-800">Aún no has escrito ningún artículo</h4>
                        <p className="text-xs text-stone-500 mt-1 max-w-xs leading-relaxed">
                            Tus reflexiones inspirarán a otros. Haz clic en "Redactar Artículo" para empezar a compartir.
                        </p>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
