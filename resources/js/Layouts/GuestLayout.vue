<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="page-shell min-h-screen px-4 py-6">
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-[20%] -left-[10%] h-[50%] w-[50%] rounded-full bg-indigo-500/10 blur-[100px]"></div>
            <div class="absolute top-[20%] -right-[10%] h-[60%] w-[40%] rounded-full bg-emerald-500/10 blur-[100px]"></div>
            <div class="absolute -bottom-[20%] left-[20%] h-[50%] w-[60%] rounded-full bg-cyan-500/10 blur-[120px]"></div>
        </div>

        <div class="relative z-10 mx-auto flex min-h-[calc(100vh-3rem)] w-full max-w-6xl items-center justify-center">
            <div class="w-full max-w-md mx-auto">
                    <div class="mb-8 flex justify-center">
                        <Link href="/" class="group flex items-center gap-3">
                            <img src="/images/logo.png" alt="CRM Logo" class="h-24 w-auto transition-transform duration-300 group-hover:scale-105" />
                        </Link>
                    </div>

                    <div class="surface-card p-8 sm:p-10 shadow-xl shadow-slate-200/50">
                        <slot />
                    </div>

                    <div class="mt-6 text-center text-sm text-slate-500">
                        &copy; {{ new Date().getFullYear() }} CRM. All rights reserved.
                    </div>
            </div>
        </div>
    </div>
</template>