<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <h3 class="text-2xl font-semibold text-gray-900">Welcome back</h3>
                    <p class="mt-2 text-gray-600">Use the shortcuts below to manage the CRM.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <a href="{{ route('customers.index') }}" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300">
                        <p class="text-sm text-gray-500">Manage</p>
                        <h4 class="mt-1 text-lg font-semibold text-gray-900">Customers</h4>
                    </a>

                    <a href="{{ route('proposals.index') }}" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300">
                        <p class="text-sm text-gray-500">Track</p>
                        <h4 class="mt-1 text-lg font-semibold text-gray-900">Proposals</h4>
                    </a>

                    <a href="{{ route('invoices.index') }}" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300">
                        <p class="text-sm text-gray-500">Review</p>
                        <h4 class="mt-1 text-lg font-semibold text-gray-900">Invoices</h4>
                    </a>

                    <a href="{{ route('transactions.index') }}" class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200 hover:ring-gray-300">
                        <p class="text-sm text-gray-500">View</p>
                        <h4 class="mt-1 text-lg font-semibold text-gray-900">Transactions</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
