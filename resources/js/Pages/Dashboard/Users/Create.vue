<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import AdminInput from '@/Components/AdminInput.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import {ref} from 'vue';
import Loading from '@/Components/Loading.vue';

const form = useForm({
    name: '',
    email: '',
    password: ''
});

const isLoading = ref(false);

const create = () => {
    form.post('/dashboard/users', {
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
                        <form action="#" @submit.prevent="create">
                            <AdminInput name="name" :errors="form.errors.name" v-model="form.name" />
                            <AdminInput name="email" :errors="form.errors.email" v-model="form.email" />
                            <AdminInput
                                name="password"
                                input-type="password"
                                :errors="form.errors.password"
                                v-model="form.password" />

                            <button type="submit" class="primary-button">
                                <Loading v-show="isLoading" />
                                <span v-show="!isLoading">Create</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
