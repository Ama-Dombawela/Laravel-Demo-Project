<script setup>

import { computed } from 'vue';

const props = defineProps({
    progress: {
        type: Number,
        required: true,
        validator: (value) => value >= 0 && value <= 100
    },
    tone: {
        type: String,
        default: 'primary', // 'primary', 'success', 'warning', 'danger'
    },
    label: {
        type: String,
        default: ''
    },
    showValue: {
        type: Boolean,
        default: false
    }
});

const colorClass = computed(() => {
    switch (props.tone) {
        case 'success': return 'bg-emerald-500';
        case 'warning': return 'bg-amber-500';
        case 'danger': return 'bg-rose-500';
        case 'primary':
        default: return 'bg-indigo-600';
    }
});
</script>

<template>
    <div class="w-full">
        <div v-if="label || showValue" class="mb-1.5 flex justify-between text-xs font-semibold text-slate-600">
            <span v-if="label">{{ label }}</span>
            <span v-if="showValue">{{ progress }}%</span>
        </div>
        <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100 ring-1 ring-inset ring-slate-200/50">
            <div 
                class="h-full rounded-full transition-all duration-500 ease-out"
                :class="colorClass"
                :style="`width: ${progress}%`"
            ></div>
        </div>
    </div>
</template>
