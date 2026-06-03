<script setup>
import { computed } from 'vue';

//for rendering responsive, sortable tables with empty states
const props = defineProps({
    headers: {
        type: Array,
        required: true,
        // Array of objects: { key: 'name', label: 'Name', align: 'left', sortable: false }
    },
    items: {
        type: Array,
        required: true,
    },
    emptyTitle: {
        type: String,
        default: 'No records found',
    },
    emptyDescription: {
        type: String,
        default: 'Get started by creating a new record.',
    },
});

defineEmits(['row-click', 'sort']);
</script>

<template>
    <div class="surface-card overflow-hidden">
        <div class="overflow-x-auto">
            <table v-if="items.length > 0" class="table-container">
                <thead class="table-header">
                    <tr>
                        <th 
                            v-for="header in headers" 
                            :key="header.key"
                            class="px-6 py-4"
                            :class="[
                                header.align === 'right' ? 'text-right' : header.align === 'center' ? 'text-center' : 'text-left',
                                header.sortable ? 'cursor-pointer hover:text-indigo-600 transition-colors' : ''
                            ]"
                            @click="header.sortable ? $emit('sort', header.key) : null"
                        >
                            <div class="flex items-center gap-1" :class="header.align === 'right' ? 'justify-end' : header.align === 'center' ? 'justify-center' : 'justify-start'">
                                {{ header.label }}
                                <svg v-if="header.sortable" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr 
                        v-for="(item, index) in items" 
                        :key="item.id || index" 
                        class="table-row group cursor-pointer"
                        @click="$emit('row-click', item)"
                    >
                        <slot name="row" :item="item" :index="index"></slot>
                    </tr>
                </tbody>
            </table>

            <div v-else class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <div class="rounded-full bg-slate-100 p-4 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900">{{ emptyTitle }}</h3>
                <p class="mt-1 text-sm text-slate-500 max-w-sm">{{ emptyDescription }}</p>
                <div class="mt-6" v-if="$slots.emptyAction">
                    <slot name="emptyAction"></slot>
                </div>
            </div>
        </div>
        <div v-if="$slots.footer" class="border-t border-slate-100/80 bg-slate-50/50 px-6 py-4">
            <slot name="footer"></slot>
        </div>
    </div>
</template>
