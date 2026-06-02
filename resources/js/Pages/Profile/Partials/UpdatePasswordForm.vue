<script setup>
import FormInput from '@/Components/ui/FormInput.vue';
import Card from '@/Components/ui/Card.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put('/password', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
            }
            if (form.errors.current_password) {
                form.reset('current_password');
            }
        },
    });
};
</script>

<template>
    <Card variant="surface" padding="p-6 sm:p-8">
        <form @submit.prevent="updatePassword" class="space-y-6">
            <div class="max-w-xl space-y-6">
                <FormInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    label="Current Password"
                    autocomplete="current-password"
                    :error="form.errors.current_password"
                />

                <FormInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    label="New Password"
                    autocomplete="new-password"
                    :error="form.errors.password"
                />

                <FormInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    label="Confirm Password"
                    autocomplete="new-password"
                    :error="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center gap-4 pt-6 border-t border-slate-100/50 mt-6">
                <button :disabled="form.processing" type="submit" class="btn-primary py-2.5 px-6">
                    Save Password
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
