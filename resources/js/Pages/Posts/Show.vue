<script setup>
import { Head, Link } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { formatDistance } from "date-fns";
import VueMarkdown from "@/Components/VueMarkdown.vue";
import { computed } from "vue";

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const publishedAt = computed(() => {
    return formatDistance(new Date(props.post.published_at), new Date(), {
        addSuffix: true,
    });
});
</script>

<template>
    <Head>
        <!-- Standard metadata tags -->
        <title>{{ post.title }}</title>
        <meta name="description" :content="post.seo_description" />
        <!-- End standard metadata tags -->
        <!-- Facebook tags -->
        <meta property="og:type" content="article" />
        <meta property="og:title" :content="post.title" />
        <meta property="og:description" :content="post.seo_description" />
        <!-- End Facebook tags -->
        <!-- Twitter tags -->
        <meta name="twitter:creator" content="CodeFrenzies" />
        <meta name="twitter:card" content="article" />
        <meta name="twitter:title" :content="post.title" />
        <meta name="twitter:description" :content="post.seo_description" />
        <!-- End Twitter tags -->
    </Head>

    <GuestLayout>
        <div class="bg-white">
            <div class="mx-auto w-full lg:max-w-2xl post-content py-10 px-6">
                <h1
                    class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"
                >
                    {{ post.title }}
                </h1>
                <p class="text-base leading-7 text-gray-600 mt-2">
                    Published by
                    <span class="font-bold">{{ post.author.name }}</span> -
                    {{ publishedAt }} in
                    <strong>{{ post.category.name }}</strong>
                </p>
                <VueMarkdown
                    :markdown="post.body"
                    class="mt-6 prose text-black"
                />
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.post-content {
    animation: fadeIn 0.3s ease-in-out;
}
</style>
