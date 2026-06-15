<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
    categories: Array
});

const showingModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id: null,
    name: '',
});

const openModal = (category = null) => {
    console.log('Opening modal', category);
    if (category) {
        editMode.value = true;
        form.id = category.id;
        form.name = category.name;
    } else {
        editMode.value = false;
        form.id = null;
        form.name = '';
    }
    showingModal.value = true;
};

const closeModal = () => {
    console.log('Closing modal');
    showingModal.value = false;
    form.reset();
    form.clearErrors();
};

const submit = () => {
    if (editMode.value) {
        form.put(route('categories.update', form.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('categories.store'), {
            onSuccess: () => closeModal(),
        });
    }
};

const deleteCategory = (id) => {
    if (confirm('¿Estás seguro de eliminar esta categoría?')) {
        form.delete(route('categories.destroy', id));
    }
};
</script>

<template>
    <Head title="Categorías" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Administración de Categorías</h2>
                <PrimaryButton @click.stop="openModal()">Nueva Categoría</PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                    <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="category in categories" :key="category.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ category.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ category.slug }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="openModal(category)" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</button>
                                        <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </td>
                                </tr>
                                <tr v-if="categories.length === 0">
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay categorías registradas.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Crear/Editar -->
        <Modal :show="showingModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ editMode ? 'Editar Categoría' : 'Nueva Categoría' }}
                </h2>

                <form @submit.prevent="submit" class="mt-6 space-y-6">
                    <div>
                        <InputLabel for="name" value="Nombre de la Categoría" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Ej: Noticias, Devocionales..."
                            required
                            autofocus
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
                        <PrimaryButton :disabled="form.processing">
                            {{ editMode ? 'Guardar Cambios' : 'Crear Categoría' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
