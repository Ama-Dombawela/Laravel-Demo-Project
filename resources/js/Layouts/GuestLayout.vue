<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 via-white to-gray-200 px-4 py-6">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200">
            <slot />
        </div>
    </div>
</template>
