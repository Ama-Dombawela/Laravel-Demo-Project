<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Edit Invoice
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
				<form action="{{ route('invoices.update', $invoice->id) }}" method="POST" class="space-y-4">
					@csrf
					@method('PATCH')

					<div>
						<label class="block text-gray-700 mb-1">Invoice Number</label>
						<input type="text" value="{{ $invoice->invoice_number }}" class="w-full rounded border-gray-300 bg-gray-100 px-3 py-2" readonly>
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Customer</label>
						<select name="customer_id" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
							<option value="">Select Customer</option>
							@foreach($customers as $customer)
								<option value="{{ $customer->id }}" @selected(old('customer_id', $invoice->customer_id) == $customer->id)>
									{{ $customer->name }}
								</option>
							@endforeach
						</select>
						@error('customer_id')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Amount</label>
						<input type="number" name="amount" step="0.01" value="{{ old('amount', $invoice->amount) }}" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
						@error('amount')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Due Date</label>
						<input type="date" name="due_date" value="{{ old('due_date', $invoice->due_date) }}" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
						@error('due_date')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex gap-2">
						<button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Update Invoice</button>
						<a href="{{ route('invoices.index') }}" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>
