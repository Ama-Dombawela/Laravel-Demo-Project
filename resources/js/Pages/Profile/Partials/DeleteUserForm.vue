<script setup>
import Card from '@/Components/ui/Card.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import ConfirmModal from '@/Components/ui/ConfirmModal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete('/profile', {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            // Because we don't have direct ref focusing, we can just let it display the error.
        },
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <Card variant="surface" padding="p-6 sm:p-8" class="ring-1 ring-rose-100 bg-rose-50/20">
        <div class="max-w-xl text-sm text-slate-600 leading-relaxed">
            <p>
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
                your account, please download any data or information that you wish to retain.
            </p>
        </div>

        <div class="mt-6">
            <button class="btn-danger py-2.5 px-6 shadow-sm shadow-rose-200" @click="confirmUserDeletion">Delete Account</button>
        </div>

        <ConfirmModal
            :show="confirmingUserDeletion"
            title="Are you sure you want to delete your account?"
            description="Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account."
            confirmLabel="Delete Account"
            cancelLabel="Cancel"
            confirmTone="danger"
            @confirm="deleteUser"
            @close="closeModal"
        >
            <div class="mt-6">
                <FormInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    label="Password"
                    placeholder="Enter your current password"
                    @keyup.enter="deleteUser"
                    :error="form.errors.password"
                />
            </div>
        </ConfirmModal>
    </Card>
</template>
