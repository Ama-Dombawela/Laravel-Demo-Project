<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
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
});
</script>

<template>
    <div class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-200 bg-white/80 px-8 py-14 text-center shadow-sm">
        <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-50 to-cyan-50 text-indigo-600 ring-1 ring-inset ring-indigo-100">
            <slot name="icon" />
        </div>
        <h3 class="text-xl font-bold text-slate-900">{{ title }}</h3>
        <p class="mt-2 max-w-md text-sm leading-6 text-slate-500">{{ description }}</p>
        <Link v-if="actionHref && actionLabel" :href="actionHref" class="btn-primary mt-6">
            {{ actionLabel }}
        </Link>
    </div>
</template>