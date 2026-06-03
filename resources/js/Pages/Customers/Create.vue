<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PageHeader from '@/Components/ui/PageHeader.vue';
import Card from '@/Components/ui/Card.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
});

const submit = () => {
    form.post('/customers');
};
</script>

<template>
    <Head title="Add Customer" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="Customers"
                title="Add Customer"
                description="Create a new customer profile to track proposals and invoices."
                backHref="/customers"
                backLabel="Back to directory"
            />
        </template>

        <div class="mx-auto max-w-3xl px-4 pb-12 sm:px-6 lg:px-8">
            <Card variant="surface">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <FormInput
                                id="name"
                                label="Customer Name"
                                v-model="form.name"
                                :error="form.errors.name"
                                placeholder="e.g. Acme Corporation"
                                autofocus
                            />
                        </div>

                        <div>
                            <FormInput
                                id="email"
                                type="email"
                                label="Email Address"
                                v-model="form.email"
                                :error="form.errors.email"
                                placeholder="contact@acme.com"
                            />
                        </div>

                        <div>
                            <FormInput
                                id="phone"
                                label="Phone Number"
                                v-model="form.phone"
                                :error="form.errors.phone"
                                placeholder="(555) 123-4567"
                            />
                        </div>

                        <div class="sm:col-span-2">
                            <div class="w-full">
                                <label for="address" class="form-label">Billing Address</label>
                                <textarea
                                    id="address"
                                    v-model="form.address"
                                    rows="3"
                                    class="form-input"
                                    :class="{ 'border-rose-300 ring-rose-500/20 focus:border-rose-500': form.errors.address }"
                                    placeholder="123 Business Rd&#10;Suite 100&#10;City, State, ZIP"
                                ></textarea>
                                <p v-if="form.errors.address" class="input-error animate-fade-in">{{ form.errors.address }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                        <Link href="/customers" class="btn-secondary">
                            Cancel
                        </Link>
                        <button type="submit" class="btn-primary" :disabled="form.processing">
                            <svg v-if="form.processing" class="-ml-1 mr-2 h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Save Customer
                        </button>
                    </div>
                </form>
            </Card>
        </div>
    </DashboardLayout>
</template>
