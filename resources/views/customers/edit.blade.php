<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Edit Customer
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
				<form action="{{ route('customers.update', $customer->id ?? request()->route('customer')) }}" method="POST" class="space-y-4">
					@csrf
					@method('PATCH')

					<div>
						<label class="block text-gray-700 mb-1">Name</label>
						<input type="text" name="name" value="{{ old('name', $customer->name) }}" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
						@error('name')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Email</label>
						<input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
						@error('email')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Phone</label>
						<input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
						@error('phone')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div>
						<label class="block text-gray-700 mb-1">Address</label>
						<textarea name="address" rows="3" class="w-full rounded border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $customer->address) }}</textarea>
						@error('address')
							<p class="mt-1 text-sm text-red-500">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex gap-2">
						<button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Update Customer</button>
						<a href="{{ route('customers.index') }}" class="rounded bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>
