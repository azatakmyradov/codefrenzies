<script setup>

import {computed, ref} from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true
    },
    inputType: {
        type: String,
        required: false,
        default: 'text'
    },
    defaultValue: {
        type: String,
        required: ''
    },
    errors: {
        type: String,
        required: false
    }
});

const nameValue = ref(props.defaultValue);

const nameFirstLetterCapital = computed(() => {
    return props.name.split('_').map(word => {
        return word.slice(0, 1).toUpperCase() + word.slice(1, word.length).toLowerCase()
    }).join(' ');
});

</script>

<template>
    <div class="mb-6">
        <label :for="name.toLowerCase()" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ nameFirstLetterCapital }}</label>
        <input
            :type="inputType"
            :name="name.toLowerCase()"
            class="base-input"
            @change="$emit('update:modelValue', nameValue)"
            v-model="nameValue">
        <span v-if="errors" class="text-red-500">
            {{ errors }}
        </span>
    </div>
</template>
