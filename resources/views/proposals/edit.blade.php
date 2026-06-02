<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Edit Proposal
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
				<form action="{{ route('proposals.update', $proposal->id) }}" method="POST" class="space-y-4">
					@csrf
					@method('PATCH')

					<div>
						<label class="block text-gray-700 mb-1">Customer</label>
						<select name="customer_id" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
							<option value="">Select Customer</option>
							@foreach($customers as $customer)
								<option value="{{ $customer->id }}" @selected(old('customer_id', $proposal->customer_id) == $customer->id)>
									{{ $customer->name }}
								</option>
							@endforeach
						</select>
						@error('customer_id')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Title</label>
						<input type="text" name="title" value="{{ old('title', $proposal->title) }}" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
						@error('title')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Description</label>
						<textarea name="description" rows="4" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $proposal->description) }}</textarea>
						@error('description')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Amount</label>
						<input type="number" name="amount" step="0.01" value="{{ old('amount', $proposal->amount) }}" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
						@error('amount')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex gap-2">
						<button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Update Proposal</button>
						<a href="{{ route('proposals.index') }}" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>
