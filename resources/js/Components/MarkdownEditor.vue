<script setup>

import {ref} from 'vue';
import VueMarkdown from './VueMarkdown.vue';

const props = defineProps({
    name: {
        type: String,
        required: false
    },
    errors: {
        type: String,
        required: false
    },
    defaultValue: {
        type: String,
        required: false
    }
});

const markdownValue = ref(props.defaultValue);
const isPreview = ref(false);

</script>

<template>
    <div class="mb-6 flex justify-between">
        <div class="flex-1 w-1/2 mr-10">
            <div class="space-x-3 mb-6">
                <a
                    href="#"
                    :class="{
                        'p-2 rounded mb-2': true,
                        'bg-gray-200': !isPreview,
                        'bg-gray-100': isPreview
                    }" @click.prevent="isPreview = false">Markdown</a>
                <a
                    href="#"
                    :class="{
                        'p-2 rounded mb-2': true,
                        'bg-gray-200': isPreview,
                        'bg-gray-100': !isPreview
                    }" @click.prevent="isPreview = true">Preview</a>
            </div>
            <span v-if="errors" class="text-red-500">
                {{ errors }}
            </span>
            <textarea
                v-if="!isPreview" id="message" class="h-[300px] block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Write your thoughts here..."
                v-model="markdownValue"
                :name="name"
                @change="$emit('update:modelValue', markdownValue)"
            ></textarea>

            <VueMarkdown
                class="prose prose-cyan"
                v-if="isPreview"
                :markdown="markdownValue" />
        </div>
    </div>
</template>
