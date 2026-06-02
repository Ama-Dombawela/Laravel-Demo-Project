<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Welcome back</h1>
            <p class="mt-2 text-sm text-slate-500">Sign in to your CRM account to continue.</p>
        </div>

        <div v-if="status" class="mb-4 rounded-xl bg-emerald-50 p-4 text-sm font-medium text-emerald-700">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                <div class="mt-1 relative">
                    <input
                        id="email"
                        type="email"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-3 text-sm shadow-sm transition-colors focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                        placeholder="you@example.com"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>
                <div v-if="form.errors.email" class="mt-2 text-xs text-rose-600">
                    {{ form.errors.email }}
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <Link
                        v-if="canResetPassword"
                        href="/forgot-password"
                        class="text-xs font-medium text-indigo-600 transition-colors hover:text-indigo-500"
                    >
                        Forgot password?
                    </Link>
                </div>
                <div class="mt-1 relative">
                    <input
                        id="password"
                        type="password"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-3 text-sm shadow-sm transition-colors focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                        placeholder="••••••••"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                </div>
                <div v-if="form.errors.password" class="mt-2 text-xs text-rose-600">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="flex items-center justify-between pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input
                        type="checkbox"
                        class="h-4 w-4 rounded border-slate-300 text-indigo-600 transition focus:ring-indigo-500"
                        v-model="form.remember"
                    />
                    <span class="text-sm font-medium text-slate-600">Remember me</span>
                </label>
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="btn-primary w-full justify-center py-3 text-sm"
                    :class="{ 'opacity-70 cursor-not-allowed': form.processing }"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Signing in...</span>
                    <span v-else>Sign in</span>
                </button>
            </div>
            
            <div class="mt-6 text-center text-sm text-slate-500">
                Don't have an account? 
                <Link href="/register" class="font-medium text-indigo-600 transition-colors hover:text-indigo-500">
                    Register now
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
