<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div class="page-shell min-h-screen bg-slate-50 text-slate-900 selection:bg-indigo-600 selection:text-white">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-[20%] -left-[10%] h-[70%] w-[50%] rounded-full bg-indigo-500/10 blur-[120px] animate-blob"></div>
            <div class="absolute top-[10%] -right-[10%] h-[60%] w-[40%] rounded-full bg-cyan-500/10 blur-[120px] animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-[20%] left-[20%] h-[50%] w-[60%] rounded-full bg-emerald-500/10 blur-[120px] animate-blob animation-delay-4000"></div>
        </div>

        <nav class="relative z-10 mx-auto max-w-7xl px-6 py-6 lg:px-8">
            <div class="flex items-center justify-between">
                <Link href="/" class="group flex items-center gap-3">
                    <img src="/images/logo.png" alt="CRM Logo" class="h-20 w-auto transition-transform duration-300 group-hover:scale-105" />
                </Link>

                <div class="flex items-center gap-4">
                    <template v-if="$page.props.auth.user">
                        <Link href="/dashboard" class="btn-primary">Dashboard</Link>
                    </template>
                    <template v-else>
                        <Link v-if="canLogin" href="/login" class="text-sm font-semibold text-slate-700 transition hover:text-indigo-600">Log in</Link>
                        <Link v-if="canRegister" href="/register" class="btn-primary">Get Started</Link>
                    </template>
                </div>
            </div>
        </nav>

        <main class="relative z-10 mx-auto flex max-w-7xl flex-col items-center justify-center px-6 pt-20 pb-32 text-center lg:px-8 lg:pt-32">
            <div class="animate-fade-up">
                <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-indigo-50/80 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-700 ring-1 ring-inset ring-indigo-500/20 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-indigo-500"></span>
                    </span>
                    The Modern CRM
                </div>
                
                <h1 class="mx-auto max-w-4xl text-5xl font-extrabold tracking-tight text-slate-900 sm:text-7xl">
                    Manage customers, proposals and invoices <span class="bg-gradient-to-r from-indigo-600 via-violet-500 to-cyan-500 bg-clip-text text-transparent">beautifully</span>
                </h1>
                
                <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-600 sm:text-xl">
                    Keep your day-to-day work in one place with a clean dashboard, easy navigation, and powerful features designed for modern teams.
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <template v-if="$page.props.auth.user">
                        <Link href="/dashboard" class="btn-primary text-base px-8 py-3.5">
                            Enter Workspace
                        </Link>
                    </template>
                    <template v-else>
                        <Link v-if="canRegister" href="/register" class="btn-primary text-base px-8 py-3.5">
                            Start for free
                        </Link>
                        <Link v-if="canLogin" href="/login" class="btn-secondary text-base px-8 py-3.5 border-slate-200">
                            Sign in to account
                        </Link>
                    </template>
                </div>
            </div>


        </main>
    </div>
</template>
