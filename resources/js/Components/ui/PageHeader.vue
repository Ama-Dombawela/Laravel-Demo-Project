<script setup>


import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
    eyebrow: {
        type: String,
        default: '',
    },
    tone: {
        type: String,
        default: '',
    }
});

const containerClasses = computed(() => {
    if (!props.tone) return 'soft-panel';
    
    const tones = {
        sky: 'bg-gradient-to-br from-sky-50 to-sky-100 border border-sky-200/60 shadow-sky-200/40',
        violet: 'bg-gradient-to-br from-violet-50 to-violet-100 border border-violet-200/60 shadow-violet-200/40',
        emerald: 'bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200/60 shadow-emerald-200/40',
        amber: 'bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200/60 shadow-amber-200/40',
    };
    
    return `rounded-3xl p-6 shadow-xl backdrop-blur-xl transition-all duration-300 ${tones[props.tone]}`;
});
</script>

<template>
    <section :class="['mb-8 animate-fade-up', containerClasses]">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">

                <div class="mt-3 flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">{{ title }}</h1>
                </div>

                <p v-if="description" class="section-subtitle max-w-2xl">{{ description }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <slot name="actions" />
            </div>
        </div>
    </section>
</template>