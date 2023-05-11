<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <header class="header">
        <a href="#">
            <h1 class="text-lg md:text-2xl font-bold">Akmyradov</h1>
        </a>
    </header>

    <nav class="border-slate-700 border-b w-full flex items-center justify-center">
        <ul class="flex space-x-5">
            <li>
                <Link href="/" class="menu-item active">Home</Link>
            </li>
        </ul>
    </nav>

    <slot />
</template>

<style>
* {
    font-family: Inter;
}
</style>
