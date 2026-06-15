<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    posts: Object
});

const form = useForm({});

const deletePost = (id) => {
    if (confirm('¿Estás seguro de eliminar este artículo?')) {
        form.delete(route('posts.destroy', id));
    }
};
</script>

<template>
    <Head title="Artículos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Administración de Artículos</h2>
                <Link :href="route('posts.create')">
                    <PrimaryButton>Nuevo Artículo</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="post in posts.data" :key="post.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ post.title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ post.category?.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span :class="post.is_published ? 'text-green-600 bg-green-100' : 'text-yellow-600 bg-yellow-100'" class="px-2 py-1 rounded-full text-xs font-bold">
                                            {{ post.is_published ? 'Publicado' : 'Borrador' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('posts.edit', post.id)" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</Link>
                                        <button @click="deletePost(post.id)" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </td>
                                </tr>
                                <tr v-if="posts.data.length === 0">
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay artículos registrados.</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Paginación básica -->
                        <div class="mt-6 flex justify-center gap-2" v-if="posts.links.length > 3">
                            <Link v-for="link in posts.links" :key="link.label" :href="link.url" v-html="link.label" 
                                  :class="{'font-bold text-blue-600': link.active, 'text-gray-400': !link.url}"
                                  class="px-3 py-1 border rounded hover:bg-gray-50" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
