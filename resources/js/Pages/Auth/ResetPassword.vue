<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/reset-password', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-slate-900">Reset Password</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">Choose a new password to regain access to your account.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    class="form-input"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="input-error">
                    {{ form.errors.email }}
                </div>
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-input"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="input-error">
                    {{ form.errors.password }}
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    class="form-input"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password_confirmation" class="input-error">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button
                    type="submit"
                    class="btn-primary"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reset Password
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
