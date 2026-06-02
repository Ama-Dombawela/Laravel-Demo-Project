<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    invoices: Array,
});

const deleteForm = useForm({});

const deleteInvoice = (id) => {
    if (confirm('Are you sure you want to delete this invoice?')) {
        deleteForm.delete(`/invoices/${id}`);
    }
};
</script>

<template>
    <Head title="Invoices" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoices</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <div v-if="$page.props.flash?.success" class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ $page.props.flash.success }}
                    </div>

                    <Link href="/invoices/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                        Add Invoice
                    </Link>

                    <table class="w-full mt-4 border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">#</th>
                                <th class="p-3 text-left">Customer</th>
                                <th class="p-3 text-left">Invoice No</th>
                                <th class="p-3 text-left">Amount</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-left">Due Date</th>
                                <th class="p-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(invoice, index) in invoices" :key="invoice.id" class="border-t">
                                <td class="p-3">{{ index + 1 }}</td>
                                <td class="p-3">{{ invoice.customer?.name }}</td>
                                <td class="p-3">{{ invoice.invoice_number }}</td>
                                <td class="p-3">${{ parseFloat(invoice.amount).toFixed(2) }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-white text-sm capitalize"
                                        :class="invoice.status === 'paid' ? 'bg-green-500' : 'bg-red-500'">
                                        {{ invoice.status }}
                                    </span>
                                </td>
                                <td class="p-3">{{ invoice.due_date }}</td>
                                <td class="p-3">
                                    <div class="flex gap-2">
                                        <Link :href="`/invoices/${invoice.id}/edit`" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm inline-block text-center">
                                            Edit
                                        </Link>

                                        <button @click="deleteInvoice(invoice.id)" class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="invoices.length === 0">
                                <td colspan="7" class="p-3 text-center text-gray-500">
                                    No invoices found.
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
