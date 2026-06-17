import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';

export default function Index({ posts }) {
    const { delete: destroy } = useForm();

    const deletePost = (id) => {
        if (confirm('¿Estás seguro de eliminar este contenido?')) {
            destroy(route('admin.posts.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">Administración de Contenido</h2>
                    <Link href={route('admin.posts.create')}>
                        <PrimaryButton>Nuevo Contenido</PrimaryButton>
                    </Link>
                </div>
            }
        >
            <Head title="Artículos" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                        <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                        <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                        <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th className="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {posts.data.map((post) => (
                                        <tr key={post.id}>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{post.title}</td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span className={`capitalize ${post.type === 'testimonial' ? 'text-purple-600' : 'text-blue-600'}`}>
                                                    {post.type === 'testimonial' ? 'Testimonio' : 'Artículo'}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{post.category?.name}</td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm">
                                                <span className={`px-2 py-1 rounded-full text-xs font-bold ${post.is_published ? 'text-green-600 bg-green-100' : 'text-yellow-600 bg-yellow-100'}`}>
                                                    {post.is_published ? 'Publicado' : 'Borrador'}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <Link href={route('admin.posts.edit', post.id)} className="text-indigo-600 hover:text-indigo-900 mr-4">Editar</Link>
                                                <button onClick={() => deletePost(post.id)} className="text-red-600 hover:text-red-900">Eliminar</button>
                                            </td>
                                        </tr>
                                    ))}
                                    {posts.data.length === 0 && (
                                        <tr>
                                            <td colSpan="5" className="px-6 py-4 text-center text-gray-500">No hay contenido registrado.</td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>

                            {posts.links.length > 3 && (
                                <div className="mt-6 flex justify-center gap-2">
                                    {posts.links.map((link) => (
                                        <Link
                                            key={link.label}
                                            href={link.url}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                            className={`px-3 py-1 border rounded hover:bg-gray-50 ${link.active ? 'font-bold text-blue-600' : 'text-gray-400'}`}
                                        />
                                    ))}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
