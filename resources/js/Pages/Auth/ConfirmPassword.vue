<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post('/confirm-password', {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-slate-900">Confirm Password</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-input"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <div v-if="form.errors.password" class="input-error">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="btn-primary"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Confirm
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
