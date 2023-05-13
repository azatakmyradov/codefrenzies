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
            <div class="bg-gray-800 text-white rounded shadow post-item" v-for="(post, key) in posts">
                <img class="bg-cover h-[200px]"
                    :style="`background-image: url('${post.thumbnail}')`">
                <div class="px-4 pt-4 post-content">
                    <h2 class="text-xl font-semibold mb-2">{{ post.title }}</h2>
                </div>
                <div class="px-4 pb-4">
                    <Link :href="`/posts/${post.slug}`" class="text-blue-500 mt-4 inline-block">Read More</Link>
                </div>
            </div>
        </main>
    </GuestLayout>
</template>

<style scoped>
.post-item {
    animation: fadeIn .5s ease-in-out;
    transition: transform 0.2s ease-in-out;
    display: flex;
    flex-direction: column;
}

.post-item:hover {
    transform: scale(1.02);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.post-content {
    flex: 1;
}

h2 {
    line-height: 1.2;
}
</style>
