<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
    actionLabel: {
        type: String,
        default: '',
    },
    actionHref: {
        type: String,
        default: '',
    },
    tone: {
        type: String,
        default: 'indigo',
    },
});

const toneClasses = computed(() => {
    const tones = {
        indigo: { iconWrapper: 'bg-gradient-to-br from-indigo-50 to-cyan-50 text-indigo-600 ring-indigo-100', button: 'btn-primary' },
        sky: { iconWrapper: 'bg-gradient-to-br from-sky-50 to-blue-50 text-sky-600 ring-sky-100', button: 'btn-sky' },
        violet: { iconWrapper: 'bg-gradient-to-br from-violet-50 to-purple-50 text-violet-600 ring-violet-100', button: 'btn-violet' },
        emerald: { iconWrapper: 'bg-gradient-to-br from-emerald-50 to-teal-50 text-emerald-600 ring-emerald-100', button: 'btn-emerald' },
        amber: { iconWrapper: 'bg-gradient-to-br from-amber-50 to-orange-50 text-amber-600 ring-amber-100', button: 'btn-amber' }
    };
    return tones[props.tone] || tones.indigo;
});
</script>

<template>
    <div class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-200 bg-white/80 px-8 py-14 text-center shadow-sm">
        <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl ring-1 ring-inset" :class="toneClasses.iconWrapper">
            <slot name="icon" />
        </div>
        <h3 class="text-xl font-bold text-slate-900">{{ title }}</h3>
        <p class="mt-2 max-w-md text-sm leading-6 text-slate-500">{{ description }}</p>
        <Link v-if="actionHref && actionLabel" :href="actionHref" class="mt-6" :class="toneClasses.button">
            {{ actionLabel }}
        </Link>
    </div>
</template>