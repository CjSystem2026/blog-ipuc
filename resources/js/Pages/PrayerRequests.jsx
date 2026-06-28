import React, { useState } from 'react';
import { router, Link } from '@inertiajs/react';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout';

export default function PrayerRequests({ auth, prayerRequests = [] }) {
    const [filter, setFilter] = useState('all');

    const handleStatusChange = (id, status) => {
        router.put(`/admin/prayer-requests/${id}`, { status });
    };

    const handleDelete = (id) => {
        if (confirm('¿Estás seguro de que deseas eliminar esta petición de oración?')) {
            router.delete(`/admin/prayer-requests/${id}`);
        }
    };

    const filteredRequests = prayerRequests.filter(req => {
        if (filter === 'all') return true;
        return req.status === filter;
    });

    const isAdmin = auth?.user?.role === 'admin';

    const getStatusBadge = (status) => {
        switch (status) {
            case 'pending':
                return <span className="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-800 rounded-full border border-amber-900/10">Pendiente</span>;
            case 'prayed':
                return <span className="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-800 rounded-full border border-blue-200/20">Orado</span>;
            case 'answered':
                return <span className="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 rounded-full border border-emerald-200/20">Respondido</span>;
            default:
                return null;
        }
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h3 className="text-2xl font-serif text-stone-900 font-bold">Peticiones de Oración</h3>
                    <p className="text-sm text-stone-500 mt-1">
                        Revisa e intercede por las peticiones de oración compartidas por la congregación.
                    </p>
                </div>
            </div>

            {/* Filter Tabs */}
            <div className="flex gap-2 mb-6 border-b border-stone-200/60 pb-3">
                {['all', 'pending', 'prayed', 'answered'].map(tab => (
                    <button
                        key={tab}
                        onClick={() => setFilter(tab)}
                        className={`px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl transition-all ${
                            filter === tab
                                ? 'bg-amber-900 text-white shadow-md shadow-amber-900/10'
                                : 'text-stone-500 hover:text-stone-850 hover:bg-stone-50'
                        }`}
                    >
                        {tab === 'all' && 'Todas'}
                        {tab === 'pending' && 'Pendientes'}
                        {tab === 'prayed' && 'Oradas'}
                        {tab === 'answered' && 'Respondidas'}
                    </button>
                ))}
            </div>

            {/* List */}
            <div className="space-y-4">
                {filteredRequests.length > 0 ? (
                    filteredRequests.map(req => (
                        <div 
                            key={req.id} 
                            className={`p-6 bg-white rounded-3xl border border-stone-200/60 shadow-sm flex flex-col md:flex-row md:items-start justify-between gap-6 transition-all hover:shadow-md ${
                                req.is_private ? 'border-l-4 border-l-red-400' : ''
                            }`}
                        >
                            <div className="space-y-3 max-w-3xl flex-1">
                                <div className="flex flex-wrap items-center gap-2">
                                    <span className="font-semibold text-stone-900 text-sm">
                                        {req.name || 'Anónimo'}
                                    </span>
                                    {req.email && (
                                        <span className="text-xs text-stone-400">({req.email})</span>
                                    )}
                                    <span className="text-stone-300 text-xs">&bull;</span>
                                    <span className="text-xs text-stone-400">
                                        {new Date(req.created_at).toLocaleDateString('es-ES', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric'
                                        })}
                                    </span>
                                    {req.is_private && (
                                        <span className="px-2 py-0.5 text-[9px] font-bold bg-red-50 text-red-700 rounded-md border border-red-200/30">Privado</span>
                                    )}
                                    {getStatusBadge(req.status)}
                                </div>
                                <p className="text-sm text-stone-650 leading-relaxed text-pretty whitespace-pre-line font-light">
                                    {req.message}
                                </p>
                            </div>

                            <div className="flex flex-wrap items-center gap-2 flex-shrink-0 self-end md:self-start">
                                {/* Actions to mark state */}
                                <select 
                                    value={req.status}
                                    onChange={(e) => handleStatusChange(req.id, e.target.value)}
                                    className="text-xs px-3 py-1.5 rounded-lg border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50 outline-none text-stone-700 font-semibold cursor-pointer"
                                >
                                    <option value="pending">Pendiente</option>
                                    <option value="prayed">Orado</option>
                                    <option value="answered">Respondido</option>
                                </select>

                                {isAdmin && (
                                    <button
                                        onClick={() => handleDelete(req.id)}
                                        className="p-1.5 rounded-lg border border-stone-200 text-stone-400 hover:text-red-650 hover:border-red-200 bg-stone-50/50 transition-all"
                                        title="Eliminar petición"
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
                    <div className="text-center py-12 bg-white rounded-3xl border border-stone-200/60 shadow-sm">
                        <span className="text-3xl">🕊️</span>
                        <p className="text-sm text-stone-400 mt-2">No hay peticiones de oración en esta categoría.</p>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
