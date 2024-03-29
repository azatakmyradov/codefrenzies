<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref } from 'vue';
import { watch } from 'vue';

const props = defineProps({
    posts: {
        type: Object,
        required: true
    }
});

const posts = ref(props.posts.data);

watch(() => props.posts, () => {
    posts.value = [...posts.value, ...props.posts.data];
});

const initialUrl = usePage().url;
let currentPage = ref(0);

const loadMoreItems = () => {
    currentPage.value++;
    router.get(props.posts.next_page_url, {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            window.history.replaceState({}, '', initialUrl);
        }
    });
}

document.addEventListener('scroll', () => {
    let documentHeight = document.body.scrollHeight;
    let currentScroll = window.scrollY + window.innerHeight;

    let modifier = 200;
    if(currentScroll + modifier > documentHeight && props.posts.last_page !== currentPage.value) {
        loadMoreItems();
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
            <div class="bg-gray-700 text-white rounded shadow post-item" v-for="(post, key) in posts">
                <Link :href="`/posts/${post.slug}`">
                    <img class="bg-cover h-[200px] w-full border border-black object-cover"
                        :src="post.thumbnail"
                        :alt="post.title"
                        loading="lazy">
                    <div class="px-4 pt-4 post-content">
                        <h2 class="text-xl font-semibold mb-2 pb-3">{{ post.title }}</h2>
                    </div>
                </Link>
            </div>
        </main>

        <div class="flex justify-center pb-5">
            <Link
                href="#"
                @click="loadMoreItems"
                v-if="props.posts.current_page !== props.posts.last_page">Load more</Link>
        </div>
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
