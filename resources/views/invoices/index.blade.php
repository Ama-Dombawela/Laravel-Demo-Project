<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invoices
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

                {{-- Add Invoice Button --}}
                <a href="{{ route('invoices.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                    Add Invoice
                </a>

                {{-- Invoices Table --}}
                <table class="w-full mt-4 border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">#</th>
                            <th class="p-3 text-left">Customer Id</th>
                            <th class="p-3 text-left">Invoice No</th>
                            <th class="p-3 text-left">Amount</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Due Date</th>
                            <th class="p-3 text-left">Created At</th>
                            <th class="p-3 text-left">Updated At</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr class="border-t">
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3">{{ $invoice->customer_id }}</td>
                            <td class="p-3">{{ $invoice->invoice_no }}</td>
                            <td class="p-3">${{ number_format($invoice->amount, 2) }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-white text-sm
                                    {{ $invoice->status === 'paid' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ ucfirst($invoice ->status) }}
                                </span>
                            </td>
                            <td class="p-3">{{ $invoice->due_date }}</td>
                            <td class="p-3">{{ $invoice->created_at }}</td>
                            <td class="p-3">{{ $invoice->updated_at }}</td>
                            <td class="p-3">
                                <div class="flex gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('invoices.edit', $invoice->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>

                                    {{-- Status Change --}}
                                    <form action="{{ route('invoices.changeStatus', $invoice->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
                                            {{ $invoice->status === 'paid' ? 'Mark as Unpaid' : 'Mark as Paid' }}
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this invoice?')">
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
                                No invoices found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Send Invoice button (admin) --}}
                <form action="{{ route('invoices.send', $invoice) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Send Invoice</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>