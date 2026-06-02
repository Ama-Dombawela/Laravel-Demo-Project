<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post('/email/verification-notification');
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-slate-900">Verify Email</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Thanks for signing up. Please verify your email address so you can start using the application.
            </p>
        </div>

        <div v-if="verificationLinkSent" class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <button
                    type="submit"
                    class="btn-primary"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </button>

                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="text-sm font-medium text-slate-500 transition-colors hover:text-slate-900"
                >
                    Log Out
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
