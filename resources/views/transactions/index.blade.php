<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transactions
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

                {{-- Transactions Table --}}
                <table class="w-full mt-4 border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">#</th>
                            <th class="p-3 text-left">Customer Id</th>
                            <th class="p-3 text-left">Invoice Id</th>
                            <th class="p-3 text-left">Stripe Payment Id</th>
                            <th class="p-3 text-left">Amount</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Created At</th>
                            <th class="p-3 text-left">Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr class="border-t">
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3">{{ $transaction->customer_id }}</td>
                            <td class="p-3">{{ $transaction->invoice_id }}</td>
                            <td class="p-3">{{ $transaction->stripe_payment_id }}</td>
                            <td class="p-3">${{ number_format($transaction->amount, 2) }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-white text-sm
                                    {{ $transaction->status === 'completed' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>