<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'success',
    },
    title: {
        type: String,
        default: '',
    },
    message: {
        type: String,
        required: true,
    },
});

const variantClasses = computed(() => {
    const palette = {
        success: 'border-emerald-200 bg-emerald-50 text-emerald-800 ring-emerald-100',
        error: 'border-rose-200 bg-rose-50 text-rose-800 ring-rose-100',
        warning: 'border-amber-200 bg-amber-50 text-amber-800 ring-amber-100',
        info: 'border-sky-200 bg-sky-50 text-sky-800 ring-sky-100',
    };

    return palette[props.variant] ?? palette.success;
});
</script>

<template>
    <div :class="variantClasses" class="rounded-2xl border px-4 py-3 shadow-sm ring-1">
        <div class="flex items-start gap-3">
            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/70 font-bold uppercase">
                <slot name="icon">
                    <span>{{ variant.charAt(0) }}</span>
                </slot>
            </div>
            <div class="min-w-0">
                <p v-if="title" class="text-sm font-semibold">{{ title }}</p>
                <p class="text-sm leading-6">{{ message }}</p>
            </div>
        </div>
    </div>
</template>