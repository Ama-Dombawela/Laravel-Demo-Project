<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Status
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">

                    {{-- Success Icon --}}
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="green" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>

                    {{-- Success Message --}}
                    <h2 class="text-2xl font-bold text-green-600">Payment Successful!</h2>
                    <p class="text-gray-500 mt-3">Your invoice has been paid successfully. Thank you!</p>

                    {{-- Back Button --}}
                    <a href="{{ route('invoices.index') }}" class="inline-block mt-6 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Back to Invoices
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>