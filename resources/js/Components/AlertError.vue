<script setup>

import {computed, onMounted, ref, watch} from 'vue';
import {usePage} from '@inertiajs/vue3';

const page = usePage();
const show = ref(false);

const checkAlerts = () => {
    if (page.props.flash.error) {
        show.value = true;
        setTimeout(() => {
            show.value = false;
        }, 1500);
    }
}

const message = computed(() => page.props.flash.error);

onMounted(() => {
    checkAlerts();
})

watch(message, () => {
    checkAlerts();
});

</script>

<template>
    <Teleport to="body">
        <Transition @after-leave="$page.props.flash.error = null">
            <div
                v-show="show"
                :class="{
                    'fixed bg-red-500 text-sm p-4 rounded-xl text-white bottom-[20px] right-[20px] shadow-xl z-50': true,
                    'shake': show
                }">
                {{ message }}
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.shake {
    animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
    transform: translate3d(0, 0, 0);
}

@keyframes shake {
    10%,
    90% {
        transform: translate3d(-1px, 0, 0);
    }

    20%,
    80% {
        transform: translate3d(2px, 0, 0);
    }

    30%,
    50%,
    70% {
        transform: translate3d(-4px, 0, 0);
    }

    40%,
    60% {
        transform: translate3d(4px, 0, 0);
    }
}
</style>
