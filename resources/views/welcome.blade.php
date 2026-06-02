<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'CRM') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-slate-200 text-slate-900">
        <main class="mx-auto flex min-h-screen max-w-5xl items-center px-4 py-10 sm:px-6 lg:px-8">
            <section class="w-full rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200 sm:p-12">
                <div class="max-w-2xl">
                    <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-500">{{ config('app.name', 'CRM') }}</p>
                    <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                        Simple CRM for customers, proposals and invoices.
                    </h1>
                    <p class="mt-4 max-w-xl text-base leading-7 text-slate-600">
                        Keep your day-to-day work in one place with a clean dashboard and easy navigation.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-medium text-white hover:bg-slate-700">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-medium text-white hover:bg-slate-700">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 hover:border-slate-400 hover:text-slate-900">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
