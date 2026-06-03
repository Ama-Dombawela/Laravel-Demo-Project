<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PageHeader from '@/Components/ui/PageHeader.vue';
import Card from '@/Components/ui/Card.vue';
import FormInput from '@/Components/ui/FormInput.vue';
import FormSelect from '@/Components/ui/FormSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    proposal: Object,
    customers: Array,
});

const customerOptions = computed(() => {
    return [
        { value: '', label: 'Select Customer' },
        ...props.customers.map(c => ({ value: c.id, label: c.name }))
    ];
});

const form = useForm({
    customer_id: props.proposal.customer_id,
    title: props.proposal.title,
    description: props.proposal.description,
    amount: props.proposal.amount,
});

const submit = () => {
    form.patch(`/proposals/${props.proposal.id}`);
};
</script>

<template>
    <Head title="Edit Proposal" />

    <DashboardLayout>
        <template #header>
            <div class="mb-4 flex justify-start">
                <Link href="/proposals" class="nav-pill bg-white text-slate-700 shadow-sm border border-slate-200 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 transition-colors">
                    <span aria-hidden="true">&larr;</span>
                    <span class="ml-1">Back</span>
                </Link>
            </div>
            <PageHeader
                eyebrow="Sales"
                title="Edit Proposal"
                description="Update the proposal details."
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
                                disabled
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
                                ></textarea>
                                <p v-if="form.errors.description" class="input-error animate-fade-in">{{ form.errors.description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                        <Link href="/proposals" class="btn-secondary">
                            Cancel
                        </Link>
                        <button type="submit" class="btn-violet" :disabled="form.processing">
                            <svg v-if="form.processing" class="-ml-1 mr-2 h-4 w-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Update Proposal
                        </button>
                    </div>
                </form>
            </Card>
        </div>
    </DashboardLayout>
</template>
