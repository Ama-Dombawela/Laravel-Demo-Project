<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post('/forgot-password');
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    id="email"
                    type="email"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    v-model="form.email"
                    required
                    autofocus
                />
                <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
