<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    customer: Object,
});

const form = useForm({
    name: props.customer.name,
    email: props.customer.email,
    phone: props.customer.phone,
    address: props.customer.address,
});

const submit = () => {
    form.patch(`/customers/${props.customer.id}`);
};
</script>

<template>
    <Head title="Edit Customer" />

    <DashboardLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Customer</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Name</label>
                            <input type="text" v-model="form.name" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Email</label>
                            <input type="email" v-model="form.email" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Phone</label>
                            <input type="text" v-model="form.phone" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Address</label>
                            <textarea v-model="form.address" rows="3" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}</div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" :disabled="form.processing">
                                Update Customer
                            </button>
                            <Link href="/customers" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300 inline-block text-center flex items-center">
                                Cancel
                            </Link>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
