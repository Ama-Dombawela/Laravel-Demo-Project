<script setup>

defineProps({
    type: {
        type: String,
        default: 'text', // 'text', 'card', 'avatar', 'title'
    },
    lines: {
        type: Number,
        default: 3,
    }
});
</script>

<template>
    <div v-if="type === 'card'" class="surface-card flex flex-col gap-4 p-6">
        <div class="skeleton h-12 w-12 rounded-full"></div>
        <div class="skeleton h-6 w-3/4"></div>
        <div class="space-y-2">
            <div class="skeleton h-4 w-full"></div>
            <div class="skeleton h-4 w-5/6"></div>
        </div>
    </div>

    <div v-else-if="type === 'text'" class="space-y-3">
        <div v-for="i in lines" :key="i" class="skeleton h-4" :class="i === lines ? 'w-4/5' : 'w-full'"></div>
    </div>

    <div v-else-if="type === 'title'" class="space-y-4">
        <div class="skeleton h-8 w-1/3"></div>
        <div class="skeleton h-4 w-1/2"></div>
    </div>

    <div v-else-if="type === 'avatar'" class="skeleton h-10 w-10 rounded-full"></div>
</template>
