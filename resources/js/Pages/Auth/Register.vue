<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Create an account</h1>
            <p class="mt-2 text-sm text-slate-500">Sign up to get started with your CRM.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Full name</label>
                <div class="mt-1 relative">
                    <input
                        id="name"
                        type="text"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-3 text-sm shadow-sm transition-colors focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                        placeholder="John Doe"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                </div>
                <div v-if="form.errors.name" class="mt-2 text-xs text-rose-600">
                    {{ form.errors.name }}
                </div>
            </div>

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
                        autocomplete="username"
                    />
                </div>
                <div v-if="form.errors.email" class="mt-2 text-xs text-rose-600">
                    {{ form.errors.email }}
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <div class="mt-1 relative">
                    <input
                        id="password"
                        type="password"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-3 text-sm shadow-sm transition-colors focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                        placeholder="••••••••"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />
                </div>
                <div v-if="form.errors.password" class="mt-2 text-xs text-rose-600">
                    {{ form.errors.password }}
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm password</label>
                <div class="mt-1 relative">
                    <input
                        id="password_confirmation"
                        type="password"
                        class="block w-full rounded-xl border-slate-200 bg-slate-50/50 px-4 py-3 text-sm shadow-sm transition-colors focus:border-indigo-500 focus:bg-white focus:ring-indigo-500"
                        placeholder="••••••••"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                </div>
                <div v-if="form.errors.password_confirmation" class="mt-2 text-xs text-rose-600">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="btn-primary w-full justify-center py-3 text-sm"
                    :class="{ 'opacity-70 cursor-not-allowed': form.processing }"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Creating account...</span>
                    <span v-else>Create account</span>
                </button>
            </div>
            
            <div class="mt-6 text-center text-sm text-slate-500">
                Already registered?
                <Link
                    href="/login"
                    class="font-medium text-indigo-600 transition-colors hover:text-indigo-500"
                >
                    Log in here
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
