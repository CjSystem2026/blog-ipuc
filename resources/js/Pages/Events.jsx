import React, { useState } from 'react';
import { useForm, router } from '@inertiajs/react';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout';

export default function Events({ auth, events = [] }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingEvent, setEditingEvent] = useState(null);

    const { data, setData, post, processing, errors, reset, clearErrors } = useForm({
        title: '',
        date: '',
        time: '',
        location: '',
        description: '',
        image: null,
        _method: 'POST',
    });

    const openCreateModal = () => {
        clearErrors();
        reset();
        setData('_method', 'POST');
        setEditingEvent(null);
        setIsModalOpen(true);
    };

    const openEditModal = (event) => {
        clearErrors();
        setEditingEvent(event);
        setData({
            title: event.title || '',
            date: event.date || '',
            time: event.time || '',
            location: event.location || '',
            description: event.description || '',
            image: null,
            _method: 'PUT',
        });
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
        reset();
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (editingEvent) {
            // Inertia file upload workaround for PUT: submit via POST with _method = PUT
            post(`/admin/events/${editingEvent.id}`, {
                onSuccess: () => closeModal(),
            });
        } else {
            post('/admin/events', {
                onSuccess: () => closeModal(),
            });
        }
    };

    const handleDelete = (id) => {
        if (confirm('¿Estás seguro de que deseas eliminar este evento?')) {
            router.delete(`/admin/events/${id}`);
        }
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            {/* Header */}
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h3 className="text-2xl font-serif text-stone-900 font-bold">Calendario de Actividades</h3>
                    <p className="text-sm text-stone-500 mt-1">
                        Programa, edita y gestiona las próximas actividades y cultos de la iglesia.
                    </p>
                </div>
                <button
                    onClick={openCreateModal}
                    className="px-5 py-2.5 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 rounded-xl shadow-md shadow-amber-900/10 transition-all inline-flex items-center gap-2"
                >
                    <span>+</span> Programar Evento
                </button>
            </div>

            {/* Event List */}
            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                {events.length > 0 ? (
                    events.map((event) => (
                        <div 
                            key={event.id}
                            className="bg-white rounded-3xl border border-stone-200/60 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between group"
                        >
                            <div>
                                {/* Image Portada */}
                                <div className="h-40 bg-stone-100 overflow-hidden relative">
                                    <img 
                                        src={event.image_url} 
                                        alt={event.title} 
                                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                    />
                                    <div className="absolute top-3 left-3 bg-white/90 backdrop-blur-xs px-2.5 py-1 rounded-lg border border-stone-200/40 text-center">
                                        <p className="text-[10px] uppercase font-bold tracking-wider text-amber-900">
                                            {new Date(event.date + 'T00:00:00').toLocaleDateString('es-ES', { month: 'short' })}
                                        </p>
                                        <p className="text-sm font-bold text-stone-900">
                                            {new Date(event.date + 'T00:00:00').toLocaleDateString('es-ES', { day: 'numeric' })}
                                        </p>
                                    </div>
                                </div>

                                {/* Content */}
                                <div className="p-6">
                                    <h4 className="font-serif font-bold text-stone-900 text-lg leading-snug group-hover:text-amber-800 transition-colors">
                                        {event.title}
                                    </h4>
                                    <div className="mt-4 space-y-2 text-xs text-stone-500">
                                        <p className="flex items-center gap-2">
                                            <span>⏰</span> {event.time}
                                        </p>
                                        <p className="flex items-center gap-2">
                                            <span>📍</span> {event.location}
                                        </p>
                                    </div>
                                    {event.description && (
                                        <p className="mt-4 text-xs/relaxed text-stone-600 line-clamp-3 font-light">
                                            {event.description}
                                        </p>
                                    )}
                                </div>
                            </div>

                            {/* Actions Footer */}
                            <div className="p-6 pt-0 border-t border-stone-50 mt-4 flex items-center justify-end gap-2 bg-stone-50/20">
                                <button
                                    onClick={() => openEditModal(event)}
                                    className="p-2 text-xs font-semibold text-stone-500 hover:text-amber-900 border border-stone-200 rounded-xl hover:bg-stone-50 transition-all inline-flex items-center gap-1.5"
                                >
                                    Editar
                                </button>
                                <button
                                    onClick={() => handleDelete(event.id)}
                                    className="p-2 text-xs font-semibold text-stone-400 hover:text-red-700 border border-transparent hover:border-red-100 rounded-xl hover:bg-red-50/30 transition-all inline-flex items-center gap-1.5"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    ))
                ) : (
                    <div className="col-span-full text-center py-16 bg-white rounded-3xl border border-stone-200/60 shadow-sm">
                        <span className="text-3xl">📅</span>
                        <p className="text-sm text-stone-400 mt-2">No hay eventos programados en este momento.</p>
                        <button
                            onClick={openCreateModal}
                            className="mt-4 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-amber-900 bg-amber-50 hover:bg-amber-100/80 rounded-xl transition-all"
                        >
                            Crear Primer Evento
                        </button>
                    </div>
                )}
            </div>

            {/* Create/Edit Modal */}
            {isModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-stone-900/40 backdrop-blur-xs">
                    <div className="bg-white rounded-3xl border border-stone-200/60 p-8 shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                        <div className="flex justify-between items-center mb-6">
                            <h4 className="text-xl font-serif text-stone-900 font-bold">
                                {editingEvent ? 'Editar Evento' : 'Programar Nuevo Evento'}
                            </h4>
                            <button
                                onClick={closeModal}
                                className="text-stone-400 hover:text-stone-800 text-2xl"
                            >
                                &times;
                            </button>
                        </div>

                        <form onSubmit={handleSubmit} className="space-y-4">
                            {/* Title */}
                            <div className="space-y-1">
                                <label className="text-[10px] font-semibold uppercase tracking-wider text-stone-500">Título del Evento</label>
                                <input
                                    type="text"
                                    required
                                    value={data.title}
                                    onChange={e => setData('title', e.target.value)}
                                    placeholder="Ej. Culto General de Adoración"
                                    className="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-amber-800/45 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none text-sm text-stone-900"
                                />
                                {errors.title && <p className="text-xs text-red-650 font-semibold">{errors.title}</p>}
                            </div>

                            {/* Date & Time */}
                            <div className="grid grid-cols-2 gap-4">
                                <div className="space-y-1">
                                    <label className="text-[10px] font-semibold uppercase tracking-wider text-stone-500">Fecha</label>
                                    <input
                                        type="date"
                                        required
                                        value={data.date}
                                        onChange={e => setData('date', e.target.value)}
                                        className="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-amber-800/45 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none text-sm text-stone-900"
                                    />
                                    {errors.date && <p className="text-xs text-red-650 font-semibold">{errors.date}</p>}
                                </div>
                                <div className="space-y-1">
                                    <label className="text-[10px] font-semibold uppercase tracking-wider text-stone-500">Hora</label>
                                    <input
                                        type="text"
                                        required
                                        value={data.time}
                                        onChange={e => setData('time', e.target.value)}
                                        placeholder="Ej. 18:00 o 7:00 PM"
                                        className="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-amber-800/45 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none text-sm text-stone-900"
                                    />
                                    {errors.time && <p className="text-xs text-red-650 font-semibold">{errors.time}</p>}
                                </div>
                            </div>

                            {/* Location */}
                            <div className="space-y-1">
                                <label className="text-[10px] font-semibold uppercase tracking-wider text-stone-500">Ubicación o Lugar</label>
                                <input
                                    type="text"
                                    required
                                    value={data.location}
                                    onChange={e => setData('location', e.target.value)}
                                    placeholder="Ej. Templo Principal o Zoom / YouTube"
                                    className="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-amber-800/45 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none text-sm text-stone-900"
                                />
                                {errors.location && <p className="text-xs text-red-650 font-semibold">{errors.location}</p>}
                            </div>

                            {/* Description */}
                            <div className="space-y-1">
                                <label className="text-[10px] font-semibold uppercase tracking-wider text-stone-500">Descripción (Opcional)</label>
                                <textarea
                                    rows="3"
                                    value={data.description}
                                    onChange={e => setData('description', e.target.value)}
                                    placeholder="Detalles sobre el evento, predicador invitado, etc..."
                                    className="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-amber-800/45 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none text-sm text-stone-850"
                                />
                                {errors.description && <p className="text-xs text-red-650 font-semibold">{errors.description}</p>}
                            </div>

                            {/* Image Upload */}
                            <div className="space-y-1">
                                <label className="text-[10px] font-semibold uppercase tracking-wider text-stone-500 block">Imagen de Portada (Opcional)</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setData('image', e.target.files[0])}
                                    className="w-full text-xs text-stone-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-semibold file:uppercase file:bg-amber-50 file:text-amber-900 hover:file:bg-amber-100 transition-colors cursor-pointer"
                                />
                                {errors.image && <p className="text-xs text-red-650 font-semibold">{errors.image}</p>}
                            </div>

                            {/* Actions */}
                            <div className="pt-4 border-t border-stone-100 flex items-center justify-end gap-3">
                                <button
                                    type="button"
                                    onClick={closeModal}
                                    className="px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-stone-500 hover:text-stone-800 transition-colors"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="px-5 py-2.5 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 disabled:bg-stone-300 rounded-xl shadow-md transition-all"
                                >
                                    {processing ? 'Guardando...' : (editingEvent ? 'Actualizar Evento' : 'Programar Evento')}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
