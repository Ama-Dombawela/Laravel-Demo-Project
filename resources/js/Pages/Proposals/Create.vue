<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    customers: Array,
});

const form = useForm({
    customer_id: '',
    title: '',
    description: '',
    amount: '',
});

const submit = () => {
    form.post('/proposals');
};
</script>

<template>
    <Head title="Add Proposal" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Proposal</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Customer</label>
                            <select v-model="form.customer_id" class="w-full border rounded px-3 py-2">
                                <option value="" disabled>Select Customer</option>
                                <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                                    {{ customer.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.customer_id" class="text-red-500 text-sm mt-1">{{ form.errors.customer_id }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Title</label>
                            <input type="text" v-model="form.title" class="w-full border rounded px-3 py-2">
                            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Description</label>
                            <textarea v-model="form.description" rows="4" class="w-full border rounded px-3 py-2"></textarea>
                            <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Amount</label>
                            <input type="number" step="0.01" v-model="form.amount" class="w-full border rounded px-3 py-2">
                            <div v-if="form.errors.amount" class="text-red-500 text-sm mt-1">{{ form.errors.amount }}</div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" :disabled="form.processing">
                                Save Proposal
                            </button>
                            <Link href="/proposals" class="bg-gray-500 text-white px-4 py-2 rounded inline-block text-center flex items-center">
                                Cancel
                            </Link>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
