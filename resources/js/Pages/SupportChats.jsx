import React, { useState, useEffect, useRef } from 'react';
import { useForm, router } from '@inertiajs/react';
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout';

export default function SupportChats({ auth, chats = [] }) {
    const [selectedChat, setSelectedChat] = useState(chats[0] || null);
    const messagesEndRef = useRef(null);

    const { data, setData, post, processing, reset, errors } = useForm({
        message: '',
    });

    // Auto-scroll to bottom of chat when selecting or receiving new messages
    useEffect(() => {
        if (messagesEndRef.current) {
            messagesEndRef.current.scrollIntoView({ behavior: 'smooth' });
        }
    }, [selectedChat]);

    // Keep selectedChat updated if chats list updates
    useEffect(() => {
        if (selectedChat) {
            const updated = chats.find(c => c.id === selectedChat.id);
            if (updated) {
                setSelectedChat(updated);
            }
        }
    }, [chats]);

    const handleSelectChat = (chat) => {
        setSelectedChat(chat);
        reset();
    };

    const handleReplySubmit = (e) => {
        e.preventDefault();
        if (!data.message.trim()) return;

        post(`/admin/support-chats/${selectedChat.id}/reply`, {
            onSuccess: () => {
                reset();
            }
        });
    };

    const handleDeleteChat = (id) => {
        if (confirm('¿Estás seguro de que deseas eliminar esta conversación por completo?')) {
            router.delete(`/admin/support-chats/${id}`, {
                onSuccess: () => {
                    if (selectedChat?.id === id) {
                        setSelectedChat(chats.find(c => c.id !== id) || null);
                    }
                }
            });
        }
    };

    return (
        <AuthenticatedLayout user={auth?.user}>
            <div className="mb-6">
                <h3 className="text-2xl font-serif text-stone-900 font-bold">Buzón de Consejería</h3>
                <p className="text-sm text-stone-500 mt-1">
                    Responde de forma confidencial y apoya espiritualmente a las personas que te escriben de manera anónima.
                </p>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 h-[calc(100vh-16rem)] min-h-[500px]">
                {/* Left Side: Conversations List */}
                <div className="lg:col-span-4 bg-white rounded-3xl border border-stone-200/60 flex flex-col overflow-hidden h-full">
                    <div className="p-4 border-b border-stone-100 bg-stone-50/20">
                        <span className="text-[10px] font-semibold uppercase tracking-wider text-stone-400 block">Conversaciones ({chats.length})</span>
                    </div>

                    <div className="flex-1 overflow-y-auto divide-y divide-stone-100">
                        {chats.length > 0 ? (
                            chats.map((chat) => {
                                const lastMessage = chat.messages[chat.messages.length - 1];
                                const isSelected = selectedChat?.id === chat.id;

                                return (
                                    <button
                                        key={chat.id}
                                        onClick={() => handleSelectChat(chat)}
                                        className={`w-full text-left p-4 transition-all flex flex-col gap-2 hover:bg-stone-50/50 ${
                                            isSelected ? 'bg-amber-50/40 border-l-4 border-l-amber-800' : ''
                                        }`}
                                    >
                                        <div className="flex items-center justify-between w-full">
                                            <span className="text-xs font-semibold text-stone-900">
                                                Anónimo #{chat.id}
                                            </span>
                                            <span className="text-[9px] text-stone-400">
                                                {new Date(chat.updated_at).toLocaleDateString('es-ES', {
                                                    month: 'short',
                                                    day: 'numeric'
                                                })}
                                            </span>
                                        </div>
                                        <p className="text-xs text-stone-500 truncate w-full font-light">
                                            {lastMessage ? lastMessage.message : 'Sin mensajes'}
                                        </p>
                                        <div className="flex justify-between items-center mt-1">
                                            {chat.status === 'pending' ? (
                                                <span className="px-2 py-0.5 text-[9px] font-bold bg-amber-50 text-amber-850 rounded-md border border-amber-900/10">Pendiente</span>
                                            ) : (
                                                <span className="px-2 py-0.5 text-[9px] font-bold bg-emerald-50 text-emerald-850 rounded-md border border-emerald-900/10">Respondido</span>
                                            )}
                                        </div>
                                    </button>
                                );
                            })
                        ) : (
                            <div className="p-8 text-center text-stone-400 text-xs">
                                No hay conversaciones activas.
                            </div>
                        )}
                    </div>
                </div>

                {/* Right Side: Chat Panel */}
                <div className="lg:col-span-8 bg-white rounded-3xl border border-stone-200/60 flex flex-col overflow-hidden h-full relative">
                    {selectedChat ? (
                        <>
                            {/* Header */}
                            <div className="p-4 border-b border-stone-100 bg-stone-50/30 flex items-center justify-between">
                                <div>
                                    <h4 className="text-sm font-semibold text-stone-900">Conversación con Anónimo #{selectedChat.id}</h4>
                                    <p className="text-[10px] text-stone-400">Iniciada el {new Date(selectedChat.created_at).toLocaleString('es-ES')}</p>
                                </div>
                                <button
                                    onClick={() => handleDeleteChat(selectedChat.id)}
                                    className="p-1.5 rounded-lg border border-transparent hover:border-red-100 text-stone-400 hover:text-red-750 hover:bg-red-50/20 transition-all"
                                    title="Eliminar conversación"
                                >
                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>

                            {/* Messages List */}
                            <div className="flex-1 overflow-y-auto p-6 space-y-4 bg-stone-50/30">
                                {selectedChat.messages.map((msg) => {
                                    const isAdmin = msg.sender === 'admin';
                                    return (
                                        <div
                                            key={msg.id}
                                            className={`flex ${isAdmin ? 'justify-end' : 'justify-start'}`}
                                        >
                                            <div
                                                className={`max-w-[80%] rounded-2xl p-4 shadow-xs text-xs/relaxed whitespace-pre-line ${
                                                    isAdmin
                                                        ? 'bg-amber-900 text-white rounded-br-none'
                                                        : 'bg-white text-stone-800 border border-stone-200/50 rounded-bl-none'
                                                }`}
                                            >
                                                <p className="font-light">{msg.message}</p>
                                                <span className={`text-[8px] mt-2 block text-right ${isAdmin ? 'text-amber-200' : 'text-stone-400'}`}>
                                                    {new Date(msg.created_at).toLocaleTimeString('es-ES', {
                                                        hour: '2-digit',
                                                        minute: '2-digit'
                                                    })}
                                                </span>
                                            </div>
                                        </div>
                                    );
                                })}
                                <div ref={messagesEndRef} />
                            </div>

                            {/* Reply Input Form */}
                            <form onSubmit={handleReplySubmit} className="p-4 border-t border-stone-100 bg-white">
                                <div className="flex gap-3 items-end">
                                    <textarea
                                        rows="2"
                                        required
                                        value={data.message}
                                        onChange={e => setData('message', e.target.value)}
                                        placeholder="Escribe una respuesta pastoral y de aliento..."
                                        className="flex-1 px-4 py-2.5 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none text-xs text-stone-900 resize-none"
                                    />
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="px-4 py-2.5 bg-amber-900 hover:bg-amber-850 disabled:bg-stone-300 text-white rounded-xl shadow-md transition-all text-xs font-semibold uppercase tracking-wider h-11 flex items-center justify-center"
                                    >
                                        {processing ? 'Enviando...' : 'Responder'}
                                    </button>
                                </div>
                                {errors.message && <p className="text-[10px] text-red-650 mt-1 font-semibold">{errors.message}</p>}
                            </form>
                        </>
                    ) : (
                        <div className="flex-1 flex flex-col items-center justify-center text-center p-8">
                            <span className="text-4xl mb-3">💬</span>
                            <h4 className="text-sm font-serif font-semibold text-stone-900">Buzón Vacío</h4>
                            <p className="text-stone-400 text-xs max-w-sm">Selecciona una conversación del listado izquierdo para leer los mensajes y brindar apoyo.</p>
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
