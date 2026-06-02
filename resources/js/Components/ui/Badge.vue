<script setup>
defineProps({
    tone: {
        type: String,
        default: 'secondary', // 'primary', 'secondary', 'success', 'warning', 'danger', 'info'
    },
    size: {
        type: String,
        default: 'sm', // 'sm', 'md'
    }
});
</script>

<template>
    <span 
        :class="[
            `badge-${tone}`,
            size === 'md' ? 'px-3 py-1.5 text-sm' : 'px-2.5 py-0.5 text-xs'
        ]"
        class="inline-flex items-center rounded-full font-semibold capitalize tracking-wide shadow-sm backdrop-blur-sm transition-colors"
    >
        <slot />
    </span>
</template>
