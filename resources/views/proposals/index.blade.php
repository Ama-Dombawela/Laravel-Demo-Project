<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Proposals
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

                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Add Proposal Button --}}
                <a href="{{ route('proposals.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                    Add Proposal
                </a>

                {{-- Proposals Table --}}
                <table class="w-full mt-4 border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">#</th>
                            <th class="p-3 text-left">Customer</th>
                            <th class="p-3 text-left">Title</th>
                            <th class="p-3 text-left">Description</th>
                            <th class="p-3 text-left">Amount</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Created At</th>
                            <th class="p-3 text-left">Updated At</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proposals as $proposal)
                        <tr class="border-t">
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3">{{ $proposal->customer->name }}</td>
                            <td class="p-3">{{ $proposal->title }}</td>
                            <td class="p-3">{{ $proposal->description }}</td>
                            <td class="p-3">${{ number_format($proposal->amount, 2) }}</td>
                            <td class="p-3">
                                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold ring-1 ring-inset
                                    {{
                                        $proposal->status === 'approved'
                                            ? 'bg-green-100 text-green-700 ring-green-600/20'
                                            : ($proposal->status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800 ring-yellow-600/20'
                                                : 'bg-red-100 text-red-700 ring-red-600/20')
                                    }}">
                                    {{ ucfirst($proposal->status) }}
                                </span>
                            </td>
                            <td class="p-3">{{ $proposal->created_at }}</td>
                            <td class="p-3">{{ $proposal->updated_at }}</td>
                            <td class="p-3">
                                <div class="flex gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('proposals.edit', $proposal->id) }}"
                                       class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                                        Edit
                                    </a>

                                    {{-- Status Change --}}
                                    <form action="{{ route('proposals.changeStatus', $proposal->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status"
                                                class="rounded border-gray-300 text-xs focus:border-indigo-500 focus:ring-indigo-500">

                                                <option value="pending" @selected($proposal->status === 'pending')>Pending</option>
                                                <option value="approved" @selected($proposal->status === 'approved')>Approved</option>
                                                <option value="rejected" @selected($proposal->status === 'rejected')>Rejected</option>
                                        </select>

                                        <button type="submit"
                                                class="bg-slate-700 text-white px-2 py-1 rounded text-xs hover:bg-slate-800 transition">
                                            Save
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form action="{{ route('proposals.destroy', $proposal->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this proposal?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500">
                                    No proposals found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>