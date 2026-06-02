<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
});

const submit = () => {
    form.post('/customers');
};
</script>

<template>
    <Head title="Add Customer" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Customer</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Name</label>
                            <input type="text" v-model="form.name" class="w-full border rounded px-3 py-2">
                            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Email</label>
                            <input type="email" v-model="form.email" class="w-full border rounded px-3 py-2">
                            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Phone</label>
                            <input type="text" v-model="form.phone" class="w-full border rounded px-3 py-2">
                            <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Address</label>
                            <textarea v-model="form.address" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                            <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}</div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" :disabled="form.processing">
                                Save Customer
                            </button>
                            <Link href="/customers" class="bg-gray-500 text-white px-4 py-2 rounded inline-block text-center">
                                Cancel
                            </Link>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
