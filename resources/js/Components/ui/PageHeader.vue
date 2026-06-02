<script setup>


import { Link } from '@inertiajs/vue3';

defineProps({
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
    backHref: {
        type: String,
        default: '',
    },
    backLabel: {
        type: String,
        default: 'Back',
    },
});
</script>

<template>
    <section class="soft-panel mb-8 animate-fade-up">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div v-if="eyebrow" class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-700 ring-1 ring-inset ring-indigo-100">
                    {{ eyebrow }}
                </div>

                <div class="mt-3 flex flex-wrap items-center gap-3">
                    <Link v-if="backHref" :href="backHref" class="nav-pill bg-slate-100 text-slate-700 hover:bg-indigo-50 hover:text-indigo-700">
                        <span aria-hidden="true">←</span>
                        <span>{{ backLabel }}</span>
                    </Link>
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