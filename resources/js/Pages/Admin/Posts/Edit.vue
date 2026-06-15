<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    post: Object,
    categories: Array
});

const form = useForm({
    title: props.post.title,
    category_id: props.post.category_id,
    excerpt: props.post.excerpt,
    body: props.post.body,
    is_published: !!props.post.is_published,
});

const submit = () => {
    form.put(route('posts.update', props.post.id));
};
</script>

<template>
    <Head title="Editar Artículo" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Artículo</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <InputLabel for="title" value="Título" />
                            <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" required autofocus />
                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="category_id" value="Categoría" />
                            <select id="category_id" v-model="form.category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled>Selecciona una categoría</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.category_id" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="excerpt" value="Resumen (opcional)" />
                            <textarea id="excerpt" v-model="form.excerpt" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                            <InputError :message="form.errors.excerpt" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="body" value="Contenido" />
                            <textarea id="body" v-model="form.body" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-mono" rows="15" required placeholder="Escribe aquí tu artículo..."></textarea>
                            <InputError :message="form.errors.body" class="mt-2" />
                        </div>

                        <div class="block">
                            <label class="flex items-center">
                                <Checkbox name="is_published" v-model:checked="form.is_published" />
                                <span class="ms-2 text-sm text-gray-600">Publicado</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-4 border-t pt-6">
                            <Link :href="route('posts.index')">
                                <SecondaryButton>Cancelar</SecondaryButton>
                            </Link>
                            <PrimaryButton :disabled="form.processing">Guardar Cambios</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
