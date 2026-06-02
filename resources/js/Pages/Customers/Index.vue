<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    customers: Array,
});

const statusForm = useForm({});
const deleteForm = useForm({});

const toggleStatus = (customer) => {
    statusForm.patch(`/customers/${customer.id}/status`);
};

const deleteCustomer = (id) => {
    if (confirm('Are you sure you want to delete this customer?')) {
        deleteForm.delete(`/customers/${id}`);
    }
};
</script>

<template>
    <Head title="Customers" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Customers</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <div v-if="$page.props.flash?.success" class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ $page.props.flash.success }}
                    </div>

                    <Link href="/customers/create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                        Add Customer
                    </Link>

                    <table class="w-full mt-4 border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">#</th>
                                <th class="p-3 text-left">Name</th>
                                <th class="p-3 text-left">Email</th>
                                <th class="p-3 text-left">Phone</th>
                                <th class="p-3 text-left">Address</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(customer, index) in customers" :key="customer.id" class="border-t">
                                <td class="p-3">{{ index + 1 }}</td>
                                <td class="p-3">{{ customer.name }}</td>
                                <td class="p-3">{{ customer.email }}</td>
                                <td class="p-3">{{ customer.phone }}</td>
                                <td class="p-3">{{ customer.address || '-' }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-white text-sm capitalize"
                                        :class="customer.status === 'active' ? 'bg-green-500' : 'bg-red-500'">
                                        {{ customer.status }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <div class="flex gap-2">
                                        <Link :href="`/customers/${customer.id}/edit`" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm inline-block text-center">
                                            Edit
                                        </Link>

                                        <button @click="toggleStatus(customer)" class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                                            {{ customer.status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>

                                        <button @click="deleteCustomer(customer.id)" class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="customers.length === 0">
                                <td colspan="7" class="p-3 text-center text-gray-500">
                                    No customers found.
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
