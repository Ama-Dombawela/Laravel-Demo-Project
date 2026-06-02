<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PageHeader from '@/Components/ui/PageHeader.vue';
import StatCard from '@/Components/ui/StatCard.vue';
import ProgressBar from '@/Components/ui/ProgressBar.vue';
import Card from '@/Components/ui/Card.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const shortcuts = [
    {
        href: '/customers',
        label: 'Customers',
        tone: 'sky',
        description: 'Manage accounts and contacts',
    },
    {
        href: '/proposals',
        label: 'Proposals',
        tone: 'violet',
        description: 'Track bids and approvals',
    },
    {
        href: '/invoices',
        label: 'Invoices',
        tone: 'emerald',
        description: 'Send and review billing',
    },
    {
        href: '/transactions',
        label: 'Transactions',
        tone: 'amber',
        description: 'Review payments and receipts',
    },
];

const statTone = {
    customers: 'indigo',
    proposals: 'amber',
    invoices: 'emerald',
    transactions: 'rose',
};
</script>

<template>
    <Head title="Dashboard" />

    <DashboardLayout>
        <template #header>
            <PageHeader
                eyebrow="Overview"
                title="Dashboard"
                description="A colorful at-a-glance view of your CRM workspace, with quick access to the most important sections."
            />
        </template>

        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-[1.5fr_0.85fr]">
                <!-- Welcome Card -->
                <Card variant="surface" padding="p-8" class="overflow-hidden bg-gradient-to-br from-indigo-600 via-violet-600 to-cyan-600 !border-0 text-white shadow-xl shadow-indigo-200/70">
                    <div class="absolute right-0 top-0 h-52 w-52 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="relative z-10 max-w-2xl">
                        <p class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-white/90 ring-1 ring-inset ring-white/20">Welcome back</p>
                        <h2 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">Keep the whole client workflow in one polished place.</h2>
                        <p class="mt-3 max-w-xl text-sm leading-7 text-white/85 sm:text-base">
                            Use the shortcuts below to manage customers, proposals, invoices, and payments without leaving the dashboard.
                        </p>
                        
                        <div class="mt-8 flex gap-4">
                            <Link href="/customers/create" class="inline-flex items-center rounded-xl bg-white/10 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                                Add Customer
                            </Link>
                            <Link href="/proposals/create" class="inline-flex items-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50">
                                Create Proposal
                            </Link>
                        </div>
                    </div>
                </Card>

                <div class="flex flex-col gap-6">
                    <!-- Status Panel -->
                    <Card variant="surface" class="flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="section-heading text-lg">Today’s focus</h3>
                            <p class="section-subtitle">A compact summary of the most important modules in your workspace.</p>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <ProgressBar :progress="78" tone="primary" label="Monthly Revenue Target" showValue />
                            </div>
                            <div>
                                <ProgressBar :progress="42" tone="success" label="Proposal Win Rate" showValue />
                            </div>
                        </div>
                    </Card>

                    <!-- Profile Details Card -->
                    <Card variant="surface" class="flex flex-col justify-between">
                        <div>
                            <h3 class="section-heading text-lg">Your Profile</h3>
                        </div>
                        <div class="mt-4 flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-indigo-100 to-cyan-100 font-bold text-2xl text-indigo-700 ring-2 ring-white shadow-sm">
                                {{ page.props.auth.user?.name?.charAt(0) }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-slate-900">{{ page.props.auth.user?.name }}</p>
                                <p class="text-sm font-medium text-slate-500">{{ page.props.auth.user?.email }}</p>
                            </div>
                        </div>
                    </Card>
                </div>
            </div>

            <!-- Stats Grid -->
            <section class="mt-6 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <StatCard label="Customers" :value="page.props.stats.customers" hint="Total customer records" tone="indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </StatCard>

                <StatCard label="Proposals" :value="page.props.stats.proposals" hint="Items awaiting review or approval" tone="amber">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </StatCard>

                <StatCard label="Invoices" :value="page.props.stats.invoices" hint="Billing records in the system" tone="emerald">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </StatCard>

                <StatCard label="Transactions" :value="page.props.stats.transactions" hint="Captured payment events" tone="rose">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </StatCard>
            </section>

            <!-- Quick Actions -->
            <section class="mt-8">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <h3 class="section-heading text-lg">Quick actions</h3>
                        <p class="section-subtitle">Jump straight into the most common CRM tasks.</p>
                    </div>
                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <Link
                        v-for="item in shortcuts"
                        :key="item.href"
                        :href="item.href"
                        class="group surface-card flex h-full flex-col justify-between p-5 transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div>
                            <div :class="`inline-flex rounded-2xl px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] ${item.tone === 'sky' ? 'bg-sky-50 text-sky-700 ring-sky-100' : item.tone === 'violet' ? 'bg-violet-50 text-violet-700 ring-violet-100' : item.tone === 'emerald' ? 'bg-emerald-50 text-emerald-700 ring-emerald-100' : 'bg-amber-50 text-amber-700 ring-amber-100'}`" class="ring-1 ring-inset">
                                {{ item.label }}
                            </div>
                            <h4 class="mt-4 text-xl font-bold text-slate-900 transition-colors group-hover:text-indigo-700">{{ item.label }}</h4>
                            <p class="mt-2 text-sm leading-6 text-slate-500">{{ item.description }}</p>
                        </div>

                        <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition-transform group-hover:translate-x-1">
                            Open section
                            <span aria-hidden="true">→</span>
                        </span>
                    </Link>
                </div>
            </section>
        </div>
    </DashboardLayout>
</template>