<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PageHeader from '@/Components/ui/PageHeader.vue';
import Card from '@/Components/ui/Card.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import FormSelect from '@/Components/ui/FormSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    customers: Array,
});

const customerOptions = computed(() => {
    return [
        { value: '', label: 'Select Customer' },
        ...props.customers.map(c => ({ value: c.id, label: c.name }))
    ];
});

const form = useForm({
    customer_id: '',
    amount: '',
    due_date: '',
});

const submit = () => {
    form.post('/invoices');
};
</script>

<template>
    <Head title="Add Invoice" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="Billing"
                title="Create Invoice"
                description="Draft a new invoice for a customer."
                backHref="/invoices"
                backLabel="Back to billing"
            />
        </template>

        <div class="mx-auto max-w-3xl px-4 pb-12 sm:px-6 lg:px-8">
            <Card variant="surface">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <FormSelect
                                id="customer"
                                label="Customer"
                                v-model="form.customer_id"
                                :options="customerOptions"
                                :error="form.errors.customer_id"
                            />
                        </div>

                        <div>
                            <FormInput
                                id="amount"
                                type="number"
                                step="0.01"
                                label="Amount ($)"
                                v-model="form.amount"
                                :error="form.errors.amount"
                                placeholder="0.00"
                            />
                        </div>

                        <div>
                            <FormInput
                                id="due_date"
                                type="date"
                                label="Due Date"
                                v-model="form.due_date"
                                :error="form.errors.due_date"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                        <Link href="/invoices" class="btn-secondary">
                            Cancel
                        </Link>
                        <button type="submit" class="btn-primary" :disabled="form.processing">
                            <svg v-if="form.processing" class="-ml-1 mr-2 h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Save Invoice
                        </button>
                    </div>
                </form>
            </Card>
        </div>
    </DashboardLayout>
</template>
