<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Proposal
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('proposals.store') }}" method="POST">
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

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                        @error('description')
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

                    {{-- Buttons --}}
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">
                            Save Proposal
                        </button>
                        <a href="{{ route('proposals.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>