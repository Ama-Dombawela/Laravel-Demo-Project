<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                        <h3 class="text-2xl font-semibold text-gray-900">Welcome back</h3>
                        <p class="mt-2 text-gray-600">Use the shortcuts below to manage the CRM.</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <Link href="/customers" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300 block">
                            <p class="text-sm text-gray-500">Manage</p>
                            <h4 class="mt-1 text-lg font-semibold text-gray-900">Customers</h4>
                        </Link>

                        <Link href="/proposals" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300 block">
                            <p class="text-sm text-gray-500">Track</p>
                            <h4 class="mt-1 text-lg font-semibold text-gray-900">Proposals</h4>
                        </Link>

                        <Link href="/invoices" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300 block">
                            <p class="text-sm text-gray-500">Review</p>
                            <h4 class="mt-1 text-lg font-semibold text-gray-900">Invoices</h4>
                        </Link>

                        <Link href="/transactions" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300 block">
                            <p class="text-sm text-gray-500">View</p>
                            <h4 class="mt-1 text-lg font-semibold text-gray-900">Transactions</h4>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
