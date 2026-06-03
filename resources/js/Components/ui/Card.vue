<script setup>
defineProps({
    variant: {
        type: String,
        default: 'surface', // 'surface', 'glass', or 'solid'
    },
    padding: {
        type: String,
        default: 'p-6', // standard padding
    },
    hover: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <div 
        :class="[
            variant === 'surface' ? 'surface-card' : '',
            variant === 'glass' ? 'glass-card' : '',
            variant === 'solid' ? 'rounded-3xl bg-white shadow-sm ring-1 ring-slate-200' : '',
            hover ? 'hover-lift' : '',
            padding
        ]"
    >
        <slot />
    </div>
</template>
