<script setup>
import {ref} from 'vue';

const props = defineProps({
    loaderStyle: {
        type: String,
        default: 'base'
    }
});

const spinnerClasses = ref('');

if (props.loaderStyle === 'base') {
    spinnerClasses.value = 'w-[25px] h-[25px]';
} else {
    spinnerClasses.value = 'w-[50px] h-[50px]';
}
</script>

<template>
    <div :class="`loader ${spinnerClasses}`"></div>
</template>

<style scoped>
.loader {
    border: 4px solid #F3F4F6;
    border-top: 4px solid #3C82F6;
    border-radius: 100%;
    animation: spin .8s ease-in-out infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
