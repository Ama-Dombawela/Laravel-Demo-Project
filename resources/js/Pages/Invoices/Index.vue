<script setup>
import { computed, ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PageHeader from '@/Components/ui/PageHeader.vue';
import StatCard from '@/Components/ui/StatCard.vue';
import AlertBanner from '@/Components/ui/AlertBanner.vue';
import EmptyState from '@/Components/ui/EmptyState.vue';
import ConfirmModal from '@/Components/ui/ConfirmModal.vue';
import Tooltip from '@/Components/ui/Tooltip.vue';
import Pagination from '@/Components/ui/Pagination.vue';
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';

const props = defineProps({
    invoices: Object,
    filters: Object,
});

const page = usePage();

const deleteForm = useForm({});
const statusForm = useForm({});
const deletingInvoice = ref(null);
const search = ref(props.filters?.search || '');

// Perform a partial reload to fetch filtered results while preserving pagination state and scroll position
const handleSearch = () => {
    router.get('/invoices', { search: search.value }, { preserveState: true, preserveScroll: true, replace: true });
};

const changeStatus = (id) => {
    statusForm.patch(`/invoices/${id}/status`, {
        preserveScroll: true,
    });
};

const paidInvoices = computed(() => props.invoices.data.filter((invoice) => invoice.status === 'paid').length);
const unpaidInvoices = computed(() => props.invoices.data.filter((invoice) => invoice.status === 'unpaid').length);

const openDeleteModal = (invoice) => {
    deletingInvoice.value = invoice;
};

const closeDeleteModal = () => {
    deletingInvoice.value = null;
};

const deleteInvoice = () => {
    if (!deletingInvoice.value) {
        return;
    }

    deleteForm.delete(`/invoices/${deletingInvoice.value.id}`, {
        onSuccess: closeDeleteModal,
        onFinish: closeDeleteModal,
    });
};
</script>

<template>
    <Head title="Invoices" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="Billing"
                title="Invoices"
                description="Review invoice status, due dates, and billing totals in a cleaner table layout."
                tone="emerald"
            >
                <template #actions>
                    <Link href="/invoices/create" class="btn-emerald">New Invoice</Link>
                </template>
            </PageHeader>
        </template>

        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-6">
                <AlertBanner variant="success" title="Success" :message="page.props.flash.success" />
            </div>

            <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                <StatCard label="Total invoices" :value="invoices.total" hint="All billing records" tone="emerald">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </StatCard>

                <StatCard label="Paid" :value="paidInvoices" hint="Completed payments" tone="emerald">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </StatCard>

                <StatCard label="Unpaid" :value="unpaidInvoices" hint="Still awaiting payment" tone="amber">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </StatCard>
            </section>

            <section class="mt-8 surface-card overflow-hidden">
                <div class="border-b border-slate-100 px-6 py-5 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h2 class="section-heading">Invoice register</h2>
                        <p class="section-subtitle">A responsive overview of all issued invoices.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-4">
                        <input
                            type="text"
                            v-model="search"
                            @keyup.enter="handleSearch"
                            placeholder="Search invoices..."
                            class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        />
                    </div>
                </div>

                <div v-if="invoices.data.length === 0" class="p-6">
                    <EmptyState
                        title="No invoices yet"
                        description="Create an invoice to start tracking customer billing and payment status."
                        action-label="New Invoice"
                        action-href="/invoices/create"
                        tone="emerald"
                    >
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </template>
                    </EmptyState>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="table-container">
                        <thead class="table-header">
                            <tr>
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">Invoice no</th>
                                <th class="px-6 py-4 text-left">Customer</th>
                                <th class="px-6 py-4 text-left">Amount</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-left">Due date</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(invoice, index) in invoices.data" :key="invoice.id" class="table-row group">
                                <td class="table-cell font-medium text-slate-500">{{ index + 1 }}</td>
                                <td class="table-cell font-mono text-sm font-bold text-emerald-600">{{ invoice.invoice_number }}</td>
                                <td class="table-cell font-semibold text-slate-900">{{ invoice.customer?.name }}</td>
                                <td class="table-cell font-semibold text-emerald-600">${{ parseFloat(invoice.amount).toFixed(2) }}</td>
                                <td class="table-cell">
                                    <span :class="invoice.status === 'paid' ? 'badge-success' : invoice.status === 'unpaid' ? 'badge-warning' : 'badge-danger'">
                                        {{ invoice.status }}
                                    </span>
                                </td>
                                <td class="table-cell text-slate-500">
                                    <Tooltip :text="'Last updated: ' + new Date(invoice.updated_at).toLocaleDateString()" position="top">
                                        <div class="flex items-center gap-2 cursor-help border-b border-dashed border-slate-300 hover:border-slate-400 w-max">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ invoice.due_date }}
                                        </div>
                                    </Tooltip>
                                </td>
                                <td class="table-cell text-right">
                                    <div class="flex justify-end gap-2 opacity-100 sm:opacity-80 sm:group-hover:opacity-100 transition-opacity">
                                        <button
                                            @click="changeStatus(invoice.id)"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-emerald-600 transition-colors hover:bg-emerald-50"
                                            title="Toggle Status"
                                            aria-label="Toggle invoice status"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                        </button>

                                        <Link :href="`/invoices/${invoice.id}/edit`" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-amber-600 transition-colors hover:bg-amber-50" title="Edit" aria-label="Edit invoice">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </Link>

                                        <button
                                            @click="openDeleteModal(invoice)"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-rose-600 transition-colors hover:bg-rose-50"
                                            title="Delete"
                                            aria-label="Delete invoice"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div v-if="invoices.links && invoices.links.length > 3" class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    <Pagination :links="invoices.links" />
                </div>
            </section>

            <ConfirmModal
                :show="Boolean(deletingInvoice)"
                title="Delete invoice"
                :description="deletingInvoice ? `Delete ${deletingInvoice.invoice_number}? This invoice will be removed permanently.` : ''"
                confirm-label="Delete invoice"
                cancel-label="Keep invoice"
                confirm-tone="danger"
                :loading="deleteForm.processing"
                @close="closeDeleteModal"
                @confirm="deleteInvoice"
            />
        </div>
    </DashboardLayout>
</template>