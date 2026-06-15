import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import { useState } from 'react';
import Modal from '@/Components/Modal';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import SecondaryButton from '@/Components/SecondaryButton';

export default function Index({ categories }) {
    const [showingModal, setShowingModal] = useState(false);
    const [editMode, setEditMode] = useState(false);

    const { data, setData, post, put, delete: destroy, processing, errors, reset, clearErrors } = useForm({
        id: null,
        name: '',
    });

    const openModal = (category = null) => {
        if (category) {
            setEditMode(true);
            setData({
                id: category.id,
                name: category.name,
            });
        } else {
            setEditMode(false);
            reset();
        }
        setShowingModal(true);
    };

    const closeModal = () => {
        setShowingModal(false);
        reset();
        clearErrors();
    };

    const submit = (e) => {
        e.preventDefault();
        if (editMode) {
            put(route('categories.update', data.id), {
                onSuccess: () => closeModal(),
            });
        } else {
            post(route('categories.store'), {
                onSuccess: () => closeModal(),
            });
        }
    };

    const deleteCategory = (id) => {
        if (confirm('¿Estás seguro de eliminar esta categoría?')) {
            destroy(route('categories.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">Administración de Categorías</h2>
                    <PrimaryButton onClick={() => openModal()}>Nueva Categoría</PrimaryButton>
                </div>
            }
        >
            <Head title="Categorías" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th className="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                        <th className="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {categories.map((category) => (
                                        <tr key={category.id}>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{category.name}</td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{category.slug}</td>
                                            <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button onClick={() => openModal(category)} className="text-indigo-600 hover:text-indigo-900 mr-4">Editar</button>
                                                <button onClick={() => deleteCategory(category.id)} className="text-red-600 hover:text-red-900">Eliminar</button>
                                            </td>
                                        </tr>
                                    ))}
                                    {categories.length === 0 && (
                                        <tr>
                                            <td colSpan="3" className="px-6 py-4 text-center text-gray-500">No hay categorías registradas.</td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <Modal show={showingModal} onClose={closeModal}>
                <div className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        {editMode ? 'Editar Categoría' : 'Nueva Categoría'}
                    </h2>

                    <form onSubmit={submit} className="mt-6 space-y-6">
                        <div>
                            <InputLabel htmlFor="name" value="Nombre de la Categoría" />
                            <TextInput
                                id="name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                type="text"
                                className="mt-1 block w-full"
                                placeholder="Ej: Noticias, Devocionales..."
                                required
                                autoFocus
                            />
                            <InputError message={errors.name} className="mt-2" />
                        </div>

                        <div className="flex items-center justify-end gap-4">
                            <SecondaryButton onClick={closeModal}>Cancelar</SecondaryButton>
                            <PrimaryButton disabled={processing}>
                                {editMode ? 'Guardar Cambios' : 'Crear Categoría'}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>
        </AuthenticatedLayout>
    );
}
