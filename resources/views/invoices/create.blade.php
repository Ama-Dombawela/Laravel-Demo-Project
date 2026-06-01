<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Invoice
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('invoices.store') }}" method="POST">
                    @csrf

                    {{-- Customer --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Customer</label>
                        <select name="customer_id" class="w-full border rounded px-3 py-2">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Amount</label>
                        <input type="number" name="amount" value="{{ old('amount') }}" step="0.01"
                               class="w-full border rounded px-3 py-2">
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('due_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">
                            Save Invoice
                        </button>
                        <a href="{{ route('invoices.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>