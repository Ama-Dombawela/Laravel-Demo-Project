<script setup>
import FormInput from '@/Components/ui/FormInput.vue';
import Card from '@/Components/ui/Card.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <Card variant="surface" padding="p-6 sm:p-8">
        <form @submit.prevent="form.patch('/profile')" class="space-y-6">
            <div class="max-w-xl space-y-6">
                <FormInput
                    id="name"
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    required
                    autocomplete="name"
                />

                <FormInput
                    id="email"
                    type="email"
                    label="Email"
                    v-model="form.email"
                    :error="form.errors.email"
                    required
                    autocomplete="username"
                />

                <div v-if="mustVerifyEmail && user.email_verified_at === null" class="mt-4 rounded-xl bg-amber-50 p-4 ring-1 ring-inset ring-amber-100">
                    <p class="text-sm text-amber-800">
                        Your email address is unverified.
                        <Link
                            href="/email/verification-notification"
                            method="post"
                            as="button"
                            class="font-medium text-amber-900 underline hover:text-amber-700 ml-1"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-emerald-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-6 border-t border-slate-100/50 mt-6">
                <button :disabled="form.processing" type="submit" class="btn-primary py-2.5 px-6">
                    Save Changes
                </button>

                <Transition
                    enter-active-class="transition ease-in-out duration-300 transform"
                    enter-from-class="opacity-0 translate-x-2"
                    leave-active-class="transition ease-in-out duration-300 transform"
                    leave-to-class="opacity-0 translate-x-2"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-emerald-600 font-medium">Saved successfully.</p>
                </Transition>
            </div>
        </form>
    </Card>
</template>
