import React, { useState } from 'react';
import { Link } from '@inertiajs/react';

export default function AuthenticatedLayout({ children, user }) {
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);
    const currentPath = typeof window !== 'undefined' ? window.location.pathname : '';
    const isDashboard = currentPath === '/admin';
    const isCreate = currentPath === '/admin/posts/create';
    const isPrayer = currentPath === '/admin/prayer-requests';
    const isTestimonial = currentPath === '/admin/testimonials';
    const isEvent = currentPath === '/admin/events';
    const isSupport = currentPath === '/admin/support-chats';

    const getLinkClass = (isActive) => {
        return isActive 
            ? "flex items-center px-4 py-3 text-sm font-medium rounded-xl text-amber-900 bg-amber-50/60 border border-amber-900/5 transition-all"
            : "flex items-center px-4 py-3 text-sm font-medium rounded-xl text-stone-600 hover:text-stone-900 hover:bg-stone-50 border border-transparent hover:border-stone-100 transition-all";
    };

    return (
        <div className="min-h-screen bg-stone-50/50 text-stone-850 flex relative">
            {/* Mobile Sidebar Overlay */}
            {isSidebarOpen && (
                <div 
                    className="fixed inset-0 bg-stone-900/20 backdrop-blur-xs z-40 md:hidden"
                    onClick={() => setIsSidebarOpen(false)}
                />
            )}

            {/* Sidebar */}
            <aside className={`fixed md:sticky top-0 left-0 h-screen w-64 bg-white border-r border-stone-200/80 flex flex-col justify-between z-50 transform transition-transform duration-300 md:translate-x-0 ${isSidebarOpen ? 'translate-x-0' : '-translate-x-full'}`}>
                <div className="p-6">
                    <div className="flex items-center justify-between mb-10">
                        <div className="flex items-center space-x-3">
                            <span className="text-xl">🕊️</span>
                            <span className="font-semibold text-stone-900 tracking-wide">Voces de Gracia</span>
                        </div>
                        {/* Close button on mobile */}
                        <button 
                            onClick={() => setIsSidebarOpen(false)}
                            className="md:hidden p-1.5 rounded-lg text-stone-400 hover:text-stone-750 hover:bg-stone-50"
                        >
                            &times;
                        </button>
                    </div>

                    <nav className="space-y-1">
                        <Link 
                            href="/admin" 
                            className={getLinkClass(isDashboard)}
                            onClick={() => setIsSidebarOpen(false)}
                        >
                            <span className="mr-3">📊</span>
                            Dashboard
                        </Link>
                        <Link 
                            href="/admin/posts/create" 
                            className={getLinkClass(isCreate)}
                            onClick={() => setIsSidebarOpen(false)}
                        >
                            <span className="mr-3">✍️</span>
                            Redactar
                        </Link>
                        <Link 
                            href="/admin/prayer-requests" 
                            className={getLinkClass(isPrayer)}
                            onClick={() => setIsSidebarOpen(false)}
                        >
                            <span className="mr-3">🙏</span>
                            Oraciones
                        </Link>
                        <Link 
                            href="/admin/testimonials" 
                            className={getLinkClass(isTestimonial)}
                            onClick={() => setIsSidebarOpen(false)}
                        >
                            <span className="mr-3">✨</span>
                            Testimonios
                        </Link>
                        <Link 
                            href="/admin/events" 
                            className={getLinkClass(isEvent)}
                            onClick={() => setIsSidebarOpen(false)}
                        >
                            <span className="mr-3">📅</span>
                            Eventos
                        </Link>
                        <Link 
                            href="/admin/support-chats" 
                            className={getLinkClass(isSupport)}
                            onClick={() => setIsSidebarOpen(false)}
                        >
                            <span className="mr-3">💬</span>
                            Consejería
                        </Link>
                        <a 
                            href="/" 
                            className={getLinkClass(false)}
                        >
                            <span className="mr-3">🏠</span>
                            Ver Blog público
                        </a>
                    </nav>
                </div>

                {/* User Area & Logout */}
                <div className="p-6 border-t border-stone-100 bg-stone-50/30">
                    <div className="flex items-center space-x-3 mb-4">
                        <div className="h-9 w-9 rounded-full bg-amber-800 text-white flex items-center justify-center font-bold text-sm">
                            {user ? user.name.charAt(0) : 'A'}
                        </div>
                        <div className="overflow-hidden">
                            <h4 className="text-xs font-semibold text-stone-900 truncate">
                                {user ? user.name : 'Autor Invitado'}
                            </h4>
                            <p className="text-[10px] text-stone-500 truncate">
                                {user ? user.email : 'autor@vocesdegracia.com'}
                            </p>
                        </div>
                    </div>
                    
                    <Link 
                        href="/logout" 
                        method="post" 
                        as="button" 
                        className="w-full flex items-center justify-center px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-stone-500 hover:text-red-700 bg-white hover:bg-red-50/40 rounded-xl border border-stone-200 transition-all"
                    >
                        Salir
                    </Link>
                </div>
            </aside>

            {/* Main Content Area */}
            <div className="flex-1 flex flex-col min-w-0 overflow-y-auto">
                {/* Header */}
                <header className="bg-white border-b border-stone-200/60 h-20 px-8 flex items-center justify-between sticky top-0 z-30">
                    <div className="flex items-center gap-3">
                        {/* Hamburger Button for Mobile */}
                        <button 
                            onClick={() => setIsSidebarOpen(true)}
                            className="md:hidden p-2 rounded-xl text-stone-500 hover:text-stone-950 hover:bg-stone-50 border border-stone-200/60 focus:outline-none"
                        >
                            <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h2 className="text-lg font-semibold text-stone-900">
                            Panel de Administración
                        </h2>
                    </div>
                    <div className="flex items-center space-x-4">
                        <span className="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 border border-emerald-600/10">
                            <span className="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Conectado
                        </span>
                    </div>
                </header>

                {/* Page Content */}
                <main className="p-8 max-w-5xl w-full mx-auto">
                    {children}
                </main>
            </div>
        </div>
    );
}
