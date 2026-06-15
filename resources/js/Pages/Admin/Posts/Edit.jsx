import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import SecondaryButton from '@/Components/SecondaryButton';
import Checkbox from '@/Components/Checkbox';

export default function Edit({ post, categories }) {
    const { data, setData, put, processing, errors } = useForm({
        title: post.title,
        category_id: post.category_id,
        excerpt: post.excerpt || '',
        body: post.body,
        is_published: !!post.is_published,
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('posts.update', post.id));
    };

    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Editar Artículo</h2>}
        >
            <Head title="Editar Artículo" />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                        <form onSubmit={submit} className="space-y-6">
                            <div>
                                <InputLabel htmlFor="title" value="Título" />
                                <TextInput id="title" value={data.title} onChange={(e) => setData('title', e.target.value)} type="text" className="mt-1 block w-full" required autoFocus />
                                <InputError message={errors.title} className="mt-2" />
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
                                    <span className="ms-2 text-sm text-gray-600">Publicado</span>
                                </label>
                            </div>

                            <div className="flex items-center justify-end gap-4 border-t pt-6">
                                <Link href={route('posts.index')}>
                                    <SecondaryButton>Cancelar</SecondaryButton>
                                </Link>
                                <PrimaryButton disabled={processing}>Guardar Cambios</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
