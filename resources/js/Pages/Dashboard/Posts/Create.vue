<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import AdminInput from '@/Components/AdminInput.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import {ref} from 'vue';
import Loading from '@/Components/Loading.vue';

defineProps({
    categories: {
        type: Object,
        required: true
    }
});

const form = useForm({
    title: '',
    slug: '',
    seo_description: '',
    thumbnail: '',
    category_id: null,
    body: '',
    publishNow: true,
    published_at: ''
});

const isLoading = ref(false);

const createPost = () => {
    form.post('/dashboard/posts', {
        preserveScroll: true,
        onStart: () => isLoading.value = true,
        onFinish: () => isLoading.value = false
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-6">
                        <form action="#" @submit.prevent="createPost">
                            <AdminInput name="title" :errors="form.errors.title" v-model="form.title" />
                            <AdminInput name="slug" :errors="form.errors.slug" v-model="form.slug" />
                            <AdminInput name="seo_description" :errors="form.errors.seo_description" v-model="form.seo_description" />
                            <AdminInput name="thumbnail" :errors="form.errors.thumbnail" v-model="form.thumbnail" />

                            <div class="mb-6">
                                <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose category</label>
                                <select id="categories"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        @change="form.category_id = $event.target.value">
                                    <option value="" :selected="!form.category_id">Choose a category</option>
                                    <option
                                        :key="category.id"
                                        :value="category.id"
                                        v-for="category in categories"
                                        :selected="form.category_id === category.id">
                                            {{ category.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.category_id" class="text-red-500">
                                    {{ form.errors.category_id.replace('id', '') }}
                                </span>
                            </div>

                            <MarkdownEditor :errors="form.errors.body" v-model="form.body" />

                            <div class="flex items-center mb-6">
                                <input v-model="form.publishNow" checked id="checked-checkbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Do you want to publish the post right now?
                                </label>
                            </div>

                            <div class="mb-6" v-if="! form.publishNow">
                                <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Schedule the post
                                </label>
                                <input
                                    type="datetime-local"
                                    class="base-input"
                                    v-model="form.published_at">
                                <span v-if="form.errors.published_at" class="text-red-500">
                                    {{ form.errors.published_at }}
                                </span>
                            </div>

                            <button type="submit" class="primary-button">
                                <Loading v-show="isLoading" />
                                <span v-show="!isLoading">Publish</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
