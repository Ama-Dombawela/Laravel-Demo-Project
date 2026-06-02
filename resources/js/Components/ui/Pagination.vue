<script setup>
import { Link } from '@inertiajs/vue3';

//  Pagination component
defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <!-- Only render pagination if there are more than just the Prev/Next links -->
    <div v-if="links.length > 3" class="flex flex-wrap items-center justify-center gap-1 mt-2">
        <template v-for="(link, key) in links" :key="key">
            
            <!-- Render disabled state for null URLs (e.g. Prev on page 1) -->
            <div
                v-if="link.url === null"
                class="px-4 py-2 text-sm text-slate-400 border border-slate-200/60 rounded-lg bg-slate-50 cursor-not-allowed"
                v-html="link.label"
            />

            <!-- Render active link using Inertia to preserve SPA state -->
            <Link
                v-else
                :href="link.url"
                class="px-4 py-2 text-sm border rounded-lg transition-colors duration-200"
                :class="[
                    link.active
                        ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm shadow-indigo-200'
                        : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50 hover:text-indigo-600 hover:border-indigo-200'
                ]"
                v-html="link.label"
            />
        </template>
    </div>
</template>
