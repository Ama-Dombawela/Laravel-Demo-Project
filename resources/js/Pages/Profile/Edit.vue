<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PageHeader from '@/Components/ui/PageHeader.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="Settings"
                title="Profile Details"
                description="Manage your personal profile and security settings."
            />
        </template>

        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8 space-y-10 mt-6">
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-1 pt-2">
                    <h3 class="text-lg font-bold text-slate-900">Profile Information</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Update your account's profile information and email address. Ensure your email is active.
                    </p>
                </div>
                <div class="lg:col-span-2">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                </div>
            </div>

            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-2">
                    <div class="border-t border-slate-200/60"></div>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-1 pt-2">
                    <h3 class="text-lg font-bold text-slate-900">Update Password</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Ensure your account is using a long, random password to stay secure.
                    </p>
                </div>
                <div class="lg:col-span-2">
                    <UpdatePasswordForm />
                </div>
            </div>

            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-2">
                    <div class="border-t border-slate-200/60"></div>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-1 pt-2">
                    <h3 class="text-lg font-bold text-rose-600">Delete Account</h3>
                    <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                        Permanently delete your account. This action cannot be undone.
                    </p>
                </div>
                <div class="lg:col-span-2">
                    <DeleteUserForm />
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
