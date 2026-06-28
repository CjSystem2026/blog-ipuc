import React from 'react';
import { useForm, Link } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/register');
    };

    return (
        <div className="min-h-screen bg-[#FAF8F5] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div className="sm:mx-auto sm:w-full sm:max-w-md text-center">
                <span className="text-4xl filter drop-shadow-sm">🕊️</span>
                <h2 className="mt-6 text-3xl font-serif font-bold text-stone-900">
                    Únete como Autor
                </h2>
                <p className="mt-2 text-sm text-stone-500 max-w-xs mx-auto leading-relaxed">
                    Crea tu cuenta para empezar a redactar artículos y compartir reflexiones con la comunidad.
                </p>
            </div>

            <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
                <div className="bg-white py-8 px-6 sm:px-10 shadow-sm border border-stone-200/60 rounded-3xl">
                    <form onSubmit={handleSubmit} className="space-y-5">
                        {/* Name */}
                        <div className="space-y-1.5">
                            <label htmlFor="name" className="text-xs font-semibold tracking-wider uppercase text-stone-500">
                                Nombre Completo
                            </label>
                            <input
                                id="name"
                                type="text"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm font-medium text-stone-900"
                                placeholder="Escribe tu nombre"
                                required
                                autoFocus
                            />
                            {errors.name && (
                                <p className="text-xs text-red-600 mt-1 font-semibold">{errors.name}</p>
                            )}
                        </div>

                        {/* Email Address */}
                        <div className="space-y-1.5">
                            <label htmlFor="email" className="text-xs font-semibold tracking-wider uppercase text-stone-500">
                                Correo Electrónico
                            </label>
                            <input
                                id="email"
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                className="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm font-medium text-stone-900"
                                placeholder="tu-correo@ejemplo.com"
                                required
                            />
                            {errors.email && (
                                <p className="text-xs text-red-600 mt-1 font-semibold">{errors.email}</p>
                            )}
                        </div>

                        {/* Password */}
                        <div className="space-y-1.5">
                            <label htmlFor="password" className="text-xs font-semibold tracking-wider uppercase text-stone-500">
                                Contraseña
                            </label>
                            <input
                                id="password"
                                type="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                className="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-900"
                                placeholder="Mínimo 8 caracteres"
                                required
                            />
                            {errors.password && (
                                <p className="text-xs text-red-600 mt-1 font-semibold">{errors.password}</p>
                            )}
                        </div>

                        {/* Password Confirmation */}
                        <div className="space-y-1.5">
                            <label htmlFor="password_confirmation" className="text-xs font-semibold tracking-wider uppercase text-stone-500">
                                Confirmar Contraseña
                            </label>
                            <input
                                id="password_confirmation"
                                type="password"
                                value={data.password_confirmation}
                                onChange={(e) => setData('password_confirmation', e.target.value)}
                                className="w-full px-4 py-3 rounded-xl border border-stone-200 focus:border-amber-800/40 focus:ring-1 focus:ring-amber-800/20 bg-stone-50/20 outline-none transition-all text-sm text-stone-900"
                                placeholder="Repite la contraseña"
                                required
                            />
                            {errors.password_confirmation && (
                                <p className="text-xs text-red-600 mt-1 font-semibold">{errors.password_confirmation}</p>
                            )}
                        </div>

                        {/* Actions */}
                        <div className="pt-2">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full py-3 px-4 text-xs font-semibold uppercase tracking-wider text-white bg-amber-900 hover:bg-amber-850 disabled:bg-stone-300 rounded-xl shadow-md shadow-amber-900/10 hover:shadow-lg transition-all duration-300"
                            >
                                {processing ? 'Registrando...' : 'Registrarme y Empezar'}
                            </button>
                        </div>
                    </form>

                    <div className="mt-6 pt-4 border-t border-stone-100 flex flex-col items-center gap-3">
                        <Link href="/login" className="text-xs text-amber-900 hover:underline font-medium">
                            ¿Ya tienes cuenta? Iniciar Sesión
                        </Link>
                        <a href="/" className="text-xs text-stone-400 hover:text-amber-900 transition-colors">
                            &larr; Volver al blog público
                        </a>
                    </div>
                </div>
            </div>
        </div>
    );
}
