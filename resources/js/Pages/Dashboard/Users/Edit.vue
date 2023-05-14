<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import AdminInput from '@/Components/AdminInput.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import {ref} from 'vue';
import Loading from '@/Components/Loading.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

const form = useForm({
    ...props.user
});

const isLoading = ref(false);

const update = () => {
    form.put(route('dashboard.users.update'), {
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
                        <form action="#" @submit.prevent="update">
                            <AdminInput
                                name="name"
                                :errors="form.errors.name"
                                :default-value="form.name"
                                v-model="form.name" />
                            <AdminInput
                                name="email"
                                :errors="form.errors.email"
                                :default-value="form.email"
                                v-model="form.email" />

                            <button type="submit" class="primary-button">
                                <Loading v-show="isLoading" />
                                <span v-show="!isLoading">Update</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
