<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    transactions: Array,
});
</script>

<template>
    <Head title="Transactions" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transactions</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <div v-if="$page.props.flash?.success" class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ $page.props.flash.success }}
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full mt-4 border whitespace-nowrap min-w-max">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 text-left">#</th>
                                    <th class="p-3 text-left">Customer</th>
                                    <th class="p-3 text-left">Invoice No</th>
                                    <th class="p-3 text-left">Stripe Payment Id</th>
                                    <th class="p-3 text-left">Amount</th>
                                    <th class="p-3 text-left">Status</th>
                                    <th class="p-3 text-left">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(transaction, index) in transactions" :key="transaction.id" class="border-t">
                                    <td class="p-3">{{ index + 1 }}</td>
                                    <td class="p-3">{{ transaction.customer?.name }}</td>
                                    <td class="p-3">{{ transaction.invoice?.invoice_number }}</td>
                                    <td class="p-3">{{ transaction.stripe_payment_id }}</td>
                                    <td class="p-3">${{ parseFloat(transaction.amount).toFixed(2) }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 rounded text-white text-sm capitalize"
                                            :class="transaction.status === 'success' ? 'bg-green-500' : 'bg-red-500'">
                                            {{ transaction.status }}
                                        </span>
                                    </td>
                                    <td class="p-3">{{ new Date(transaction.created_at).toLocaleString() }}</td>
                                </tr>
                                <tr v-if="transactions.length === 0">
                                    <td colspan="7" class="p-3 text-center text-gray-500">
                                        No transactions found.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
