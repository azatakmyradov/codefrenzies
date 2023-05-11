<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import AdminInput from '@/Components/AdminInput.vue';
import {ref} from 'vue';
import Loading from '@/Components/Loading.vue';

const props = defineProps({
    categories: Array
});

let form = useForm({
    name: ''
});

const isLoading = ref(false);
const addCategory = () => {
    form.post('/dashboard/categories', {
        preserveScroll: true,
        onStart: () => isLoading.value = true,
        onFinish: () => {
            isLoading.value = false;
        }
    });
}

const deleteCategory = id => {
    router.delete(`/dashboard/categories/${id}`);
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-6">

                        <form action="#" @submit.prevent="addCategory">
                            <AdminInput
                                class="w-full"
                                name="category"
                                v-model="form.name"
                                :errors="form.errors.name" />
                            <button class="primary-button mb-6 rounded">
                                <Loading v-show="isLoading" />
                                <span v-show="!isLoading">Add</span>
                            </button>
                        </form>

                        <table id="categories" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                            <tbody>
                                <tr v-for="(category, key) in categories" :key="key" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ category.name }}
                                    </th>
                                    <td class="px-6 py-4 space-x-3">
                                        <a href="#" @click.prevent="deleteCategory(category.id)" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
