<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Customer
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full border rounded px-3 py-2">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Address</label>
                        <textarea name="address" rows="3"
                                  class="w-full border rounded px-3 py-2">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">
                            Save Customer
                        </button>
                        <a href="{{ route('customers.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>