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
    customers: Object,
    filters: Object,
});

const page = usePage();

const statusForm = useForm({ status: '' });
const deleteForm = useForm({});
const deletingCustomer = ref(null);
const search = ref(props.filters?.search || '');

// Perform a partial reload to fetch filtered results while preserving pagination state and scroll position
const handleSearch = () => {
    router.get('/customers', { search: search.value }, { preserveState: true, preserveScroll: true, replace: true });
};

const activeCustomers = computed(() => props.customers.data.filter((customer) => customer.status === 'active').length);
const inactiveCustomers = computed(() => props.customers.data.length - activeCustomers.value);

const openDeleteModal = (customer) => {
    deletingCustomer.value = customer;
};

const closeDeleteModal = () => {
    deletingCustomer.value = null;
};

const toggleStatus = (customer) => {
    statusForm.patch(`/customers/${customer.id}/status`);
};

const deleteCustomer = () => {
    if (!deletingCustomer.value) {
        return;
    }

    deleteForm.delete(`/customers/${deletingCustomer.value.id}`, {
        onSuccess: closeDeleteModal,
        onFinish: closeDeleteModal,
    });
};
</script>

<template>
    <Head title="Customers" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="CRM"
                title="Customers"
                description="Track contacts, toggle status, and keep the directory organized with a polished responsive table."
            >
                <template #actions>
                    <Link href="/customers/create" class="btn-primary">Add Customer</Link>
                </template>
            </PageHeader>
        </template>

        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-6">
                <AlertBanner variant="success" title="Success" :message="page.props.flash.success" />
            </div>

            <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                <StatCard label="Total customers" :value="customers.total" hint="All customer records" tone="indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </StatCard>

                <StatCard label="Active" :value="activeCustomers" hint="Currently enabled" tone="emerald">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </StatCard>

                <StatCard label="Inactive" :value="inactiveCustomers" hint="Paused or archived" tone="amber">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </StatCard>
            </section>

            <section class="mt-8 surface-card overflow-hidden">
                <div class="border-b border-slate-100 px-6 py-5 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h2 class="section-heading">Directory</h2>
                        <p class="section-subtitle">Hover rows for actions and use the status button to switch a customer on or off.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-4">
                        <input
                            type="text"
                            v-model="search"
                            @keyup.enter="handleSearch"
                            placeholder="Search customers..."
                            class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>

                <div v-if="customers.data.length === 0" class="p-6">
                    <EmptyState
                        title="No customers yet"
                        description="Create your first customer to start building out the CRM directory."
                        action-label="Add Customer"
                        action-href="/customers/create"
                    >
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
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
                                <th class="px-6 py-4 text-left">Contact info</th>
                                <th class="px-6 py-4 text-left">Address</th>
                                <th class="px-6 py-4 text-left">Date added</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(customer, index) in customers.data" :key="customer.id" class="table-row group">
                                <td class="table-cell font-medium text-slate-500">{{ index + 1 }}</td>
                                <td class="table-cell">
                                    <div class="font-semibold text-slate-900">{{ customer.name }}</div>
                                </td>
                                <td class="table-cell">
                                    <div class="font-medium text-slate-900">{{ customer.email }}</div>
                                    <div class="text-xs text-slate-500">{{ customer.phone }}</div>
                                </td>
                                <td class="table-cell">
                                    <div class="max-w-xs truncate text-slate-600">{{ customer.address || '-' }}</div>
                                </td>
                                <td class="table-cell text-slate-500 text-sm">
                                    <Tooltip :text="'Last updated: ' + new Date(customer.updated_at).toLocaleDateString()" position="top">
                                        <div class="cursor-help border-b border-dashed border-slate-300 hover:border-slate-400">
                                            {{ new Date(customer.created_at).toLocaleDateString() }}
                                        </div>
                                    </Tooltip>
                                </td>
                                <td class="table-cell">
                                    <span :class="customer.status === 'active' ? 'badge-success' : 'badge-danger'">
                                        {{ customer.status }}
                                    </span>
                                </td>
                                <td class="table-cell text-right">
                                    <div class="flex justify-end gap-2 opacity-100 sm:opacity-80 sm:group-hover:opacity-100 transition-opacity">
                                        <Link :href="`/customers/${customer.id}/edit`" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-amber-600 transition-colors hover:bg-amber-50" title="Edit" aria-label="Edit customer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </Link>

                                        <button
                                            @click="toggleStatus(customer)"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl transition-colors"
                                            :class="customer.status === 'active' ? 'text-slate-500 hover:bg-slate-100' : 'text-emerald-600 hover:bg-emerald-50'"
                                            :title="customer.status === 'active' ? 'Deactivate' : 'Activate'"
                                            :aria-label="customer.status === 'active' ? 'Deactivate customer' : 'Activate customer'"
                                        >
                                            <svg v-if="customer.status === 'active'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>

                                        <button
                                            @click="openDeleteModal(customer)"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-rose-600 transition-colors hover:bg-rose-50"
                                            title="Delete"
                                            aria-label="Delete customer"
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
                
                <div v-if="customers.links && customers.links.length > 3" class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    <Pagination :links="customers.links" />
                </div>
            </section>

            <ConfirmModal
                :show="Boolean(deletingCustomer)"
                title="Delete customer"
                :description="deletingCustomer ? `Delete ${deletingCustomer.name}? This cannot be undone.` : ''"
                confirm-label="Delete customer"
                cancel-label="Keep customer"
                confirm-tone="danger"
                :loading="deleteForm.processing"
                @close="closeDeleteModal"
                @confirm="deleteCustomer"
            />
        </div>
    </DashboardLayout>
</template>