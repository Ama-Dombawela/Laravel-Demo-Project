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
    proposals: Object,
    filters: Object,
});

const page = usePage();

const search = ref(props.filters?.search || '');
const statusForm = useForm({ status: '' });
const deleteForm = useForm({});
const deletingProposal = ref(null);

// Perform a partial reload to fetch filtered results while preserving pagination state and scroll position
const handleSearch = () => {
    router.get('/proposals', { search: search.value }, { preserveState: true, preserveScroll: true, replace: true });
};

const approvedProposals = computed(() => props.proposals.data.filter((proposal) => proposal.status === 'approved').length);
const pendingProposals = computed(() => props.proposals.data.filter((proposal) => proposal.status === 'pending').length);

const updateStatus = (proposal) => {
    const newStatus = proposal.status === 'pending' ? 'approved' : 'pending';
    statusForm.status = newStatus;
    
    statusForm.patch(`/proposals/${proposal.id}/status`, {
        preserveScroll: true,
    });
};

const confirmProposalDeletion = (proposal) => {
    deletingProposal.value = proposal;
};

const closeDeleteModal = () => {
    deletingProposal.value = null;
    deleteForm.reset();
};

const deleteProposal = () => {
    if (!deletingProposal.value) {
        return;
    }

    deleteForm.delete(`/proposals/${deletingProposal.value.id}`, {
        onSuccess: closeDeleteModal,
        onFinish: closeDeleteModal,
    });
};
</script>

<template>
    <Head title="Proposals" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="Sales"
                title="Proposals"
                description="Keep the proposal pipeline visible with approvals, pending work, and quick status updates."
            >
                <template #actions>
                    <Link href="/proposals/create" class="btn-primary">New Proposal</Link>
                </template>
            </PageHeader>
        </template>

        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div v-if="page.props.flash?.success" class="mb-6">
                <AlertBanner variant="success" title="Success" :message="page.props.flash.success" />
            </div>

            <div v-if="page.props.errors && Object.keys(page.props.errors).length > 0" class="mb-6">
                <AlertBanner variant="error" title="Error" :message="Object.values(page.props.errors)[0]" />
            </div>

            <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                <StatCard label="Total proposals" :value="proposals.total" hint="All proposals in play" tone="indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </StatCard>

                <StatCard label="Approved" :value="approvedProposals" hint="Won or accepted" tone="emerald">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </StatCard>

                <StatCard label="Pending" :value="pendingProposals" hint="Awaiting review" tone="amber">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </StatCard>
            </section>

            <section class="mt-8 surface-card overflow-hidden">
                <div class="border-b border-slate-100 px-6 py-5 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h2 class="section-heading">Proposal pipeline</h2>
                        <p class="section-subtitle">Update statuses inline and keep every proposal card easy to scan.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-4">
                        <input
                            type="text"
                            v-model="search"
                            @keyup.enter="handleSearch"
                            placeholder="Search proposals..."
                            class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                </div>

                <div v-if="proposals.data.length === 0" class="p-6">
                    <EmptyState
                        title="No proposals yet"
                        description="Create a proposal to start tracking sales opportunities."
                        action-label="New Proposal"
                        action-href="/proposals/create"
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
                                <th class="px-6 py-4 text-left">Customer</th>
                                <th class="px-6 py-4 text-left">Details</th>
                                <th class="px-6 py-4 text-left">Amount</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-left">Date</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(proposal, index) in proposals.data" :key="proposal.id" class="table-row group">
                                <td class="table-cell font-medium text-slate-500">{{ index + 1 }}</td>
                                <td class="table-cell font-semibold text-slate-900">{{ proposal.customer?.name }}</td>
                                <td class="table-cell">
                                    <div class="font-medium text-slate-800">{{ proposal.title }}</div>
                                    <div class="max-w-[240px] truncate text-xs text-slate-500" :title="proposal.description">{{ proposal.description }}</div>
                                </td>
                                <td class="table-cell font-semibold text-emerald-600">${{ parseFloat(proposal.amount).toFixed(2) }}</td>
                                <td class="table-cell">
                                    <span :class="proposal.status === 'approved' ? 'badge-success' : proposal.status === 'pending' ? 'badge-warning' : 'badge-danger'">
                                        {{ proposal.status }}
                                    </span>
                                </td>
                                <td class="table-cell text-slate-500 text-sm">
                                    <Tooltip :text="'Last updated: ' + new Date(proposal.updated_at).toLocaleDateString()" position="top">
                                        <div class="cursor-help border-b border-dashed border-slate-300 hover:border-slate-400">
                                            {{ new Date(proposal.created_at).toLocaleDateString() }}
                                        </div>
                                    </Tooltip>
                                </td>
                                <td class="table-cell text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-80 sm:group-hover:opacity-100 transition-opacity">
                                        <Link :href="`/proposals/${proposal.id}/edit`" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-amber-600 transition-colors hover:bg-amber-50" title="Edit" aria-label="Edit proposal">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </Link>

                                        <select
                                            :value="proposal.status"
                                            @change="changeStatus(proposal.id, $event.target.value)"
                                            class="rounded-xl border-slate-200 bg-white px-3 pr-8 py-2 text-xs font-medium text-slate-600 shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                                            title="Change status"
                                            aria-label="Change proposal status"
                                        >
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>

                                        <button
                                            @click="openDeleteModal(proposal)"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-rose-600 transition-colors hover:bg-rose-50"
                                            title="Delete"
                                            aria-label="Delete proposal"
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
                
                <div v-if="proposals.links && proposals.links.length > 3" class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    <Pagination :links="proposals.links" />
                </div>
            </section>

            <ConfirmModal
                :show="Boolean(deletingProposal)"
                title="Delete proposal"
                :description="deletingProposal ? `Delete ${deletingProposal.title}? This proposal will be removed permanently.` : ''"
                confirm-label="Delete proposal"
                cancel-label="Keep proposal"
                confirm-tone="danger"
                :loading="deleteForm.processing"
                @close="closeDeleteModal"
                @confirm="deleteProposal"
            />
        </div>
    </DashboardLayout>
</template>