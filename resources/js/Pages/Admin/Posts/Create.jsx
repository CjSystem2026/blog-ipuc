import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import SecondaryButton from '@/Components/SecondaryButton';
import Checkbox from '@/Components/Checkbox';

export default function Create({ categories }) {
    const { data, setData, post, processing, errors } = useForm({
        title: '',
        type: 'article',
        category_id: '',
        excerpt: '',
        body: '',
        is_published: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('admin.posts.store'));
    };

    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Crear Nuevo Artículo</h2>}
        >
            <Head title="Nuevo Artículo" />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                        <form onSubmit={submit} className="space-y-6">
                            <div>
                                <InputLabel htmlFor="title" value="Título" />
                                <TextInput id="title" value={data.title} onChange={(e) => setData('title', e.target.value)} type="text" className="mt-1 block w-full" required autoFocus />
                                <InputError message={errors.title} className="mt-2" />
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel htmlFor="type" value="Tipo de Contenido" />
                                    <select id="type" value={data.type} onChange={(e) => setData('type', e.target.value)} className="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="article">Artículo</option>
                                        <option value="testimonial">Testimonio</option>
                                    </select>
                                    <InputError message={errors.type} className="mt-2" />
                                </div>

                                <div>
                                    <InputLabel htmlFor="category_id" value="Categoría" />
                                    <select id="category_id" value={data.category_id} onChange={(e) => setData('category_id', e.target.value)} className="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="" disabled>Selecciona una categoría</option>
                                        {categories.map((category) => (
                                            <option key={category.id} value={category.id}>
                                                {category.name}
                                            </option>
                                        ))}
                                    </select>
                                    <InputError message={errors.category_id} className="mt-2" />
                                </div>
                            </div>

                            <div>
                                <InputLabel htmlFor="excerpt" value="Resumen (opcional)" />
                                <textarea id="excerpt" value={data.excerpt} onChange={(e) => setData('excerpt', e.target.value)} className="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                                <InputError message={errors.excerpt} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="body" value="Contenido" />
                                <textarea id="body" value={data.body} onChange={(e) => setData('body', e.target.value)} className="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-mono" rows="15" required placeholder="Escribe aquí tu artículo..."></textarea>
                                <InputError message={errors.body} className="mt-2" />
                            </div>

                            <div className="block">
                                <label className="flex items-center">
                                    <Checkbox name="is_published" checked={data.is_published} onChange={(e) => setData('is_published', e.target.checked)} />
                                    <span className="ms-2 text-sm text-gray-600">Publicar inmediatamente</span>
                                </label>
                            </div>

                            <div className="flex items-center justify-end gap-4 border-t pt-6">
                                <Link href={route('admin.posts.index')}>
                                    <SecondaryButton>Cancelar</SecondaryButton>
                                </Link>
                                <PrimaryButton disabled={processing}>Crear Contenido</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
