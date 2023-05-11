<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    posts: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <Head>
        <title>A Personal Look into the World of Programming</title>
        <meta name="description" content="Discover the world of programming through a personal lens. Join us for insightful articles, personal anecdotes, and expert tips on all things coding. Our blog offers a fresh perspective on programming, written by experienced professionals. From beginner-friendly tutorials to advanced coding techniques, we cover it all. Stay up-to-date with the latest trends and insights in the industry, while gaining valuable insights from our personal experiences. Start your programming journey with us today!" />
    </Head>

    <GuestLayout>
        <main class="posts">
            <Link :href="`/posts/${post.slug}`" v-for="(post, key) in posts">
                <div class="post-item bg-slate-700">
                    <img class="object-cover w-full max-h-[200px]" :src="post.thumbnail" :alt="post.title" loading="lazy">
                    <h1 class="text-white font-bold p-2 hover:underline">{{ post.title }}</h1>
                </div>
            </Link>
        </main>
    </GuestLayout>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
