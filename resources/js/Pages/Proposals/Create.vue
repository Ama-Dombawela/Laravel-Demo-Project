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
    title: '',
    description: '',
    amount: '',
});

const submit = () => {
    form.post('/proposals');
};
</script>

<template>
    <Head title="Add Proposal" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="Sales"
                title="Add Proposal"
                description="Draft a new proposal and attach it to an existing customer."
                backHref="/proposals"
                backLabel="Back to pipeline"
            />
        </template>

        <div class="mx-auto max-w-3xl px-4 pb-12 sm:px-6 lg:px-8">
            <Card variant="surface">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <FormInput
                                id="title"
                                label="Proposal Title"
                                v-model="form.title"
                                :error="form.errors.title"
                                placeholder="e.g. Website Redesign Phase 1"
                                autofocus
                            />
                        </div>

                        <div>
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
                                label="Estimated Amount ($)"
                                v-model="form.amount"
                                :error="form.errors.amount"
                                placeholder="0.00"
                            />
                        </div>

                        <div class="sm:col-span-2">
                            <div class="w-full">
                                <label for="description" class="form-label">Description / Scope of Work</label>
                                <textarea
                                    id="description"
                                    v-model="form.description"
                                    rows="4"
                                    class="form-input"
                                    :class="{ 'border-rose-300 ring-rose-500/20 focus:border-rose-500': form.errors.description }"
                                    placeholder="Briefly describe the deliverables..."
                                ></textarea>
                                <p v-if="form.errors.description" class="input-error animate-fade-in">{{ form.errors.description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                        <Link href="/proposals" class="btn-secondary">
                            Cancel
                        </Link>
                        <button type="submit" class="btn-primary" :disabled="form.processing">
                            <svg v-if="form.processing" class="-ml-1 mr-2 h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Save Proposal
                        </button>
                    </div>
                </form>
            </Card>
        </div>
    </DashboardLayout>
</template>
