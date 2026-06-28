import React, { useState } from 'react';
import { router } from '@inertiajs/react';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout';

export default function Testimonials({ auth, testimonials = [] }) {
    const [filter, setFilter] = useState('all');

    const handleStatusChange = (id, status) => {
        router.put(`/admin/testimonials/${id}`, { status });
    };

    const handleDelete = (id) => {
        if (confirm('¿Estás seguro de que deseas eliminar este testimonio permanentemente?')) {
            router.delete(`/admin/testimonials/${id}`);
        }
    };

    const filteredTestimonials = testimonials.filter(t => {
        if (filter === 'all') return true;
        return t.status === filter;
    });

    const isAdmin = auth?.user?.role === 'admin';

    const getStatusBadge = (status) => {
        switch (status) {
            case 'pending':
                return <span className="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 rounded-full border border-amber-900/10">Pendiente</span>;
            case 'approved':
                return <span className="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 rounded-full border border-emerald-250/20">Aprobado</span>;
            case 'archived':
                return <span className="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-stone-100 text-stone-600 rounded-full border border-stone-200">Archivado</span>;
            default:
                return null;
        }
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h3 className="text-2xl font-serif text-stone-900 font-bold">Testimonios de Fe</h3>
                    <p className="text-sm text-stone-500 mt-1">
                        Modera y administra los testimonios enviados por los hermanos para publicarse en la web.
                    </p>
                </div>
            </div>

            {/* Filter Tabs */}
            <div className="flex gap-2 mb-6 border-b border-stone-200/60 pb-3">
                {['all', 'pending', 'approved', 'archived'].map(tab => (
                    <button
                        key={tab}
                        onClick={() => setFilter(tab)}
                        className={`px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl transition-all ${
                            filter === tab
                                ? 'bg-amber-900 text-white shadow-md shadow-amber-900/10'
                                : 'text-stone-500 hover:text-stone-850 hover:bg-stone-50'
                        }`}
                    >
                        {tab === 'all' && 'Todos'}
                        {tab === 'pending' && 'Pendientes'}
                        {tab === 'approved' && 'Aprobados'}
                        {tab === 'archived' && 'Archivados'}
                    </button>
                ))}
            </div>

            {/* Testimonials List */}
            <div className="space-y-4">
                {filteredTestimonials.length > 0 ? (
                    filteredTestimonials.map(t => (
                        <div 
                            key={t.id} 
                            className="p-6 bg-white rounded-3xl border border-stone-200/40 shadow-sm flex flex-col md:flex-row md:items-start justify-between gap-6 transition-all hover:shadow-md"
                        >
                            <div className="space-y-3 max-w-3xl flex-1">
                                <div className="flex flex-wrap items-center gap-2">
                                    <span className="font-semibold text-stone-900 text-sm">
                                        {t.name || 'Anónimo'}
                                    </span>
                                    <span className="text-stone-300 text-xs">&bull;</span>
                                    <span className="text-xs text-stone-400">
                                        {new Date(t.created_at).toLocaleDateString('es-ES', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric'
                                        })}
                                    </span>
                                    {getStatusBadge(t.status)}
                                </div>
                                <p className="text-sm text-stone-650 leading-relaxed text-pretty whitespace-pre-line font-light italic">
                                    "{t.content}"
                                </p>
                            </div>

                            <div className="flex flex-wrap items-center gap-2 flex-shrink-0 self-end md:self-start">
                                {/* Status select */}
                                <select 
                                    value={t.status}
                                    onChange={(e) => handleStatusChange(t.id, e.target.value)}
                                    className="text-xs px-3 py-1.5 rounded-lg border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50 outline-none text-stone-700 font-semibold cursor-pointer"
                                >
                                    <option value="pending">Pendiente</option>
                                    <option value="approved">Aprobar (Publicar)</option>
                                    <option value="archived">Archivar</option>
                                </select>

                                {isAdmin && (
                                    <button
                                        onClick={() => handleDelete(t.id)}
                                        className="p-1.5 rounded-lg border border-stone-200 text-stone-400 hover:text-red-650 hover:border-red-200 bg-stone-50/50 transition-all"
                                        title="Eliminar testimonio"
                                    >
                                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                )}
                            </div>
                        </div>
                    ))
                ) : (
                    <div className="text-center py-12 bg-white rounded-3xl border border-stone-200/40 shadow-sm">
                        <span className="text-3xl">✨</span>
                        <p className="text-sm text-stone-400 mt-2">No hay testimonios en esta categoría.</p>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
