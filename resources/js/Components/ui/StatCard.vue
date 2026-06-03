<script setup>

import { computed } from 'vue';

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    hint: {
        type: String,
        default: '',
    },
    tone: {
        type: String,
        default: 'indigo',
    },
});

const toneClasses = computed(() => {
    const palette = {
        indigo: 'from-indigo-500 to-violet-600 text-black bg-indigo-50 ring-indigo-100',
        emerald: 'from-emerald-500 to-teal-600 text-black bg-emerald-50 ring-emerald-100',
        amber: 'from-amber-500 to-orange-600 text-black bg-amber-50 ring-amber-100',
        rose: 'from-rose-500 to-pink-600 text-black bg-rose-50 ring-rose-100',
        sky: 'from-sky-500 to-cyan-600 text-black bg-sky-50 ring-sky-100',
    };

    return palette[props.tone] ?? palette.indigo;
});
</script>

<template>
    <div class="soft-panel h-full animate-fade-up">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-slate-500">{{ label }}</p>
                <p class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">{{ value }}</p>
                <p v-if="hint" class="input-hint">{{ hint }}</p>
            </div>

            <div :class="`flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br ${toneClasses}`" class="ring-1">
                <slot />
            </div>
        </div>
    </div>
</template>