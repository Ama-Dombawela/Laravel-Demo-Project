<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    proposals: Array,
});

const statusForm = useForm({
    status: '',
});

const deleteForm = useForm({});

const changeStatus = (id, newStatus) => {
    statusForm.status = newStatus;
    statusForm.patch(`/proposals/${id}/status`, {
        preserveScroll: true,
    });
};

const deleteProposal = (id) => {
    if (confirm('Are you sure you want to delete this proposal?')) {
        deleteForm.delete(`/proposals/${id}`);
    }
};
</script>

<template>
    <Head title="Proposals" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Proposals</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <div v-if="$page.props.flash?.success" class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ $page.props.flash.success }}
                    </div>

                    <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="bg-red-100 text-red-800 p-3 rounded mb-4">
                        {{ Object.values($page.props.errors)[0] }}
                    </div>

                    <Link href="/proposals/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                        Add Proposal
                    </Link>

                    <div class="overflow-x-auto">
                        <table class="w-full mt-4 border whitespace-nowrap min-w-max">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 text-left">#</th>
                                    <th class="p-3 text-left">Customer</th>
                                    <th class="p-3 text-left">Title</th>
                                    <th class="p-3 text-left">Description</th>
                                    <th class="p-3 text-left">Amount</th>
                                    <th class="p-3 text-left">Status</th>
                                    <th class="p-3 text-left">Created At</th>
                                    <th class="p-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(proposal, index) in proposals" :key="proposal.id" class="border-t">
                                    <td class="p-3">{{ index + 1 }}</td>
                                    <td class="p-3">{{ proposal.customer?.name }}</td>
                                    <td class="p-3">{{ proposal.title }}</td>
                                    <td class="p-3 truncate max-w-xs">{{ proposal.description }}</td>
                                    <td class="p-3">${{ parseFloat(proposal.amount).toFixed(2) }}</td>
                                    <td class="p-3">
                                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold ring-1 ring-inset capitalize"
                                            :class="
                                                proposal.status === 'approved'
                                                    ? 'bg-green-100 text-green-700 ring-green-600/20'
                                                    : (proposal.status === 'pending'
                                                        ? 'bg-yellow-100 text-yellow-800 ring-yellow-600/20'
                                                        : 'bg-red-100 text-red-700 ring-red-600/20')
                                            ">
                                            {{ proposal.status }}
                                        </span>
                                    </td>
                                    <td class="p-3">{{ new Date(proposal.created_at).toLocaleDateString() }}</td>
                                    <td class="p-3">
                                        <div class="flex gap-2 items-center">
                                            <Link :href="`/proposals/${proposal.id}/edit`" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs inline-block text-center hover:bg-yellow-600 transition">
                                                Edit
                                            </Link>

                                            <select :value="proposal.status" @change="changeStatus(proposal.id, $event.target.value)"
                                                    class="rounded border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500 py-1">
                                                <option value="pending">Pending</option>
                                                <option value="approved">Approved</option>
                                                <option value="rejected">Rejected</option>
                                            </select>

                                            <button @click="deleteProposal(proposal.id)" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="proposals.length === 0">
                                    <td colspan="8" class="p-3 text-center text-gray-500">
                                        No proposals found.
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
