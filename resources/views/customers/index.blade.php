<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customers
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Add Customer Button --}}
                <a href="{{ route('customers.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                    Add Customer
                </a>

                {{-- Customers Table --}}
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
                        @forelse($customers as $customer)
                        <tr class="border-t">
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3">{{ $customer->name }}</td>
                            <td class="p-3">{{ $customer->email }}</td>
                            <td class="p-3">{{ $customer->phone }}</td>
                            <td class="p-3">{{ $customer->address ?? '-' }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-white text-sm
                                    {{ $customer->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>

                                    {{-- Status Change --}}
                                    <form action="{{ route('customers.changeStatus', $customer->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                                class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                                            {{ $customer->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this customer?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500">
                                    No customers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>