<script setup>

import { computed } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
    confirmLabel: {
        type: String,
        default: 'Confirm',
    },
    cancelLabel: {
        type: String,
        default: 'Cancel',
    },
    confirmTone: {
        type: String,
        default: 'danger',
    },
    loading: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close', 'confirm']);

const confirmClasses = computed(() => {
    return props.confirmTone === 'danger' ? 'btn-danger' : 'btn-primary';
});
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="modal-backdrop" @click="emit('close')"></div>

        <div class="modal-panel animate-fade-up">
            <div class="border-b border-slate-100 px-6 py-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Please confirm</p>
                <h3 class="mt-2 text-xl font-bold text-slate-900">{{ title }}</h3>
            </div>

            <div class="px-6 py-5">
                <p class="text-sm leading-6 text-slate-600">{{ description }}</p>
                <slot />
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 px-6 py-4 sm:flex-row sm:justify-end">
                <button type="button" class="btn-secondary" @click="emit('close')">
                    {{ cancelLabel }}
                </button>
                <button type="button" :class="confirmClasses" :disabled="loading" @click="emit('confirm')">
                    <svg v-if="loading" class="mr-2 h-4 w-4 animate-spin text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                        <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" class="opacity-75"></path>
                    </svg>
                    {{ confirmLabel }}
                </button>
            </div>
        </div>
    </div>
</template>