<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PageHeader from '@/Components/ui/PageHeader.vue';
import Card from '@/Components/ui/Card.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    proposal: Object,
});
</script>

<template>
    <Head title="View Proposal" />

    <DashboardLayout>
        <template #header>
            <div class="mb-4 flex justify-start">
                <Link href="/proposals" class="nav-pill bg-white text-slate-700 shadow-sm border border-slate-200 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 transition-colors">
                    <span aria-hidden="true">&larr;</span>
                    <span class="ml-1">Back </span>
                </Link>
            </div>
            <PageHeader
                eyebrow="Sales"
                :title="proposal.title"
                :description="`Proposal ID: #${proposal.id} • Created on: ${new Date(proposal.created_at).toLocaleDateString()}`"
            />
        </template>

        <div class="mx-auto max-w-4xl px-4 pb-12 sm:px-6 lg:px-8">
            <Card variant="surface" padding="p-8">
                <div class="space-y-8">
                    
                    <div class="grid gap-8 sm:grid-cols-2">
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Customer</h3>
                            <p class="mt-2 text-lg font-medium text-slate-900">{{ proposal.customer?.name || 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Status</h3>
                            <div class="mt-2">
                                <span :class="['inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold capitalize tracking-wide shadow-sm backdrop-blur-sm', 
                                    proposal.status === 'approved' ? 'bg-emerald-50/80 text-emerald-700 ring-1 ring-inset ring-emerald-500/20' : 
                                    proposal.status === 'pending' ? 'bg-amber-50/80 text-amber-700 ring-1 ring-inset ring-amber-500/20' : 
                                    'bg-rose-50/80 text-rose-700 ring-1 ring-inset ring-rose-500/20']">
                                    {{ proposal.status }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Estimated Amount</h3>
                            <p class="mt-2 text-2xl font-bold text-emerald-600">${{ parseFloat(proposal.amount).toFixed(2) }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Last Updated</h3>
                            <p class="mt-2 text-base text-slate-700">{{ new Date(proposal.updated_at).toLocaleDateString() }}</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-8">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500 mb-4">Description / Scope of Work</h3>
                        <div class="prose prose-slate max-w-none">
                            <p class="whitespace-pre-wrap text-slate-700">{{ proposal.description }}</p>
                        </div>
                    </div>
                    
                </div>
            </Card>
        </div>
    </DashboardLayout>
</template>
