<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {formatDistance} from 'date-fns';
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    posts: Array
});

const deletePost = id => {
    router.delete(route('dashboard.posts.destroy', { id }));
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-6">
                        <table id="posts" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Author
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                            <tbody>
                                <tr v-for="(post, key) in posts" :key="key" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ post.title }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ post.author.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ post.category.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span v-if="post.published_at && new Date() > new Date(post.published_at)">
                                            {{ formatDistance(new Date(post.published_at), new Date(), { addSuffix: true }) }}
                                        </span>
                                        <span class="text-green-400" v-if="post.published_at && new Date() < new Date(post.published_at)">
                                            Scheduled: {{ formatDistance(new Date(post.published_at), new Date(), { addSuffix: true }) }}
                                        </span>
                                        <span class="text-orange-400" v-if="post.published_at === null">
                                            Drafted: {{ formatDistance(new Date(post.created_at), new Date(), { addSuffix: true }) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 space-x-3">
                                        <Link :href="route('dashboard.posts.edit', { id: post.id })" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</Link>
                                        <a href="#" @click.prevent="deletePost(post.id)" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
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
