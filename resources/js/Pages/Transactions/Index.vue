<script setup>
import { computed, ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PageHeader from '@/Components/ui/PageHeader.vue';
import StatCard from '@/Components/ui/StatCard.vue';
import AlertBanner from '@/Components/ui/AlertBanner.vue';
import EmptyState from '@/Components/ui/EmptyState.vue';
import Tooltip from '@/Components/ui/Tooltip.vue';
import Pagination from '@/Components/ui/Pagination.vue';
import { Head, usePage, router } from '@inertiajs/vue3';

const props = defineProps({
    transactions: Object,
    filters: Object,
});

const page = usePage();
const search = ref(props.filters?.search || '');

// Perform a partial reload to fetch filtered results while preserving pagination state and scroll position
const handleSearch = () => {
    router.get('/transactions', { search: search.value }, { preserveState: true, preserveScroll: true, replace: true });
};

// Stat cards were removed, so we don't strictly need these computed properties, but if they were to be used:
// const successfulTransactions = computed(() => props.transactions.data.filter((transaction) => transaction.status === 'success').length);
// const failedTransactions = computed(() => props.transactions.data.filter((transaction) => transaction.status !== 'success').length);
</script>

<template>
    <Head title="Transactions" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="Payments"
                title="Transactions"
                description="Track captured payments in a streamlined history table with status summaries."
                tone="amber"
            />
        </template>

        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-6">
                <AlertBanner variant="success" title="Success" :message="page.props.flash.success" />
            </div>

            <!-- Stat cards removed per user request -->

            <section class="mt-8 surface-card overflow-hidden">
                <div class="border-b border-slate-100 px-6 py-5 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h2 class="section-heading">Payment history</h2>
                        <p class="section-subtitle">A concise record of all transactions processed through the CRM.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-4">
                        <input
                            type="text"
                            v-model="search"
                            @keyup.enter="handleSearch"
                            placeholder="Search transactions..."
                            class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-amber-500 focus:ring-amber-500"
                        />
                    </div>
                </div>

                <div v-if="transactions.data.length === 0" class="p-6">
                    <EmptyState
                        title="No transactions yet"
                        description="Payments will appear here once invoices are processed."
                    >
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </template>
                    </EmptyState>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="table-container">
                        <thead class="table-header">
                            <tr>
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">Customer</th>
                                <th class="px-6 py-4 text-left">Invoice no</th>
                                <th class="px-6 py-4 text-left">Payment ID</th>
                                <th class="px-6 py-4 text-left">Amount</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-left">Date &amp; time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(transaction, index) in transactions.data" :key="transaction.id" class="table-row group">
                                <td class="table-cell font-medium text-slate-500">{{ index + 1 }}</td>
                                <td class="table-cell font-semibold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-xs font-bold text-amber-600">
                                            {{ transaction.customer?.name?.charAt(0) }}
                                        </div>
                                        {{ transaction.customer?.name }}
                                    </div>
                                </td>
                                <td class="table-cell font-mono text-sm font-semibold text-slate-600">{{ transaction.invoice?.invoice_number }}</td>
                                <td class="table-cell font-mono text-xs text-slate-500">{{ transaction.stripe_payment_id }}</td>
                                <td class="table-cell font-semibold text-emerald-600">${{ parseFloat(transaction.amount).toFixed(2) }}</td>
                                <td class="table-cell">
                                    <span :class="transaction.status === 'success' ? 'badge-success' : 'badge-danger'">
                                        {{ transaction.status }}
                                    </span>
                                </td>
                                <td class="table-cell text-slate-500 text-sm">
                                    <Tooltip :text="'Last updated: ' + new Date(transaction.updated_at).toLocaleString()" position="top">
                                        <div class="cursor-help border-b border-dashed border-slate-300 hover:border-slate-400">
                                            {{ new Date(transaction.created_at).toLocaleString() }}
                                        </div>
                                    </Tooltip>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="transactions.links && transactions.links.length > 3" class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    <Pagination :links="transactions.links" />
                </div>
            </section>
        </div>
    </DashboardLayout>
</template>