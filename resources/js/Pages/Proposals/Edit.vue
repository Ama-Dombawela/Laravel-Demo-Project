<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    proposal: Object,
    customers: Array,
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Proposal</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Customer</label>
                            <select v-model="form.customer_id" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled>Select Customer</option>
                                <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                                    {{ customer.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.customer_id" class="text-red-500 text-sm mt-1">{{ form.errors.customer_id }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Title</label>
                            <input type="text" v-model="form.title" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Description</label>
                            <textarea v-model="form.description" rows="4" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Amount</label>
                            <input type="number" step="0.01" v-model="form.amount" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <div v-if="form.errors.amount" class="text-red-500 text-sm mt-1">{{ form.errors.amount }}</div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" :disabled="form.processing">
                                Update Proposal
                            </button>
                            <Link href="/proposals" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300 inline-block text-center flex items-center">
                                Cancel
                            </Link>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
