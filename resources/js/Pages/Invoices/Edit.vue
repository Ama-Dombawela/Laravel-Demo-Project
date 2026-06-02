<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    invoice: Object,
    customers: Array,
});

const form = useForm({
    customer_id: props.invoice.customer_id,
    amount: props.invoice.amount,
    due_date: props.invoice.due_date,
});

const submit = () => {
    form.patch(`/invoices/${props.invoice.id}`);
};
</script>

<template>
    <Head title="Edit Invoice" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Invoice</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Invoice Number</label>
                            <input type="text" :value="invoice.invoice_number" class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" readonly>
                        </div>

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
                            <label class="block text-gray-700 mb-1">Amount</label>
                            <input type="number" step="0.01" v-model="form.amount" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <div v-if="form.errors.amount" class="text-red-500 text-sm mt-1">{{ form.errors.amount }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Due Date</label>
                            <input type="date" v-model="form.due_date" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <div v-if="form.errors.due_date" class="text-red-500 text-sm mt-1">{{ form.errors.due_date }}</div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" :disabled="form.processing">
                                Update Invoice
                            </button>
                            <Link href="/invoices" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300 inline-block text-center flex items-center">
                                Cancel
                            </Link>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
