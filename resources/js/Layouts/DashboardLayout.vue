<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const showProfileDropdown = ref(false);
const page = usePage();

const bgClass = computed(() => {
    if (page.url.startsWith('/customers')) return 'bg-sky-50';
    if (page.url.startsWith('/proposals')) return 'bg-violet-50';
    if (page.url.startsWith('/invoices')) return 'bg-emerald-50';
    if (page.url.startsWith('/transactions')) return 'bg-amber-50';
    return 'bg-purple-50';
});
</script>

<template>
    <div :class="['page-shell min-h-screen flex flex-col', bgClass]">
        <nav class="sticky top-0 z-50 border-b border-white/60 bg-white/80 shadow-sm backdrop-blur-xl transition-all duration-300">
            <!-- Primary Navigation Menu -->
            <div class="mx-auto px-4 sm:px-8 lg:px-12">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <Link href="/dashboard" class="group flex items-center gap-2">
                                <img src="/images/logo.png" alt="CRM Logo" class="h-14 w-auto transition-transform duration-300 group-hover:scale-105" />
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex">
                            <Link href="/dashboard" class="nav-pill my-3" :class="[ $page.url === '/dashboard' ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">
                                Dashboard
                            </Link>
                            <Link href="/customers" class="nav-pill my-3" :class="[ $page.url.startsWith('/customers') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">
                                Customers
                            </Link>
                            <Link href="/proposals" class="nav-pill my-3" :class="[ $page.url.startsWith('/proposals') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">
                                Proposals
                            </Link>
                            <Link href="/invoices" class="nav-pill my-3" :class="[ $page.url.startsWith('/invoices') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">
                                Invoices
                            </Link>
                            <Link href="/transactions" class="nav-pill my-3" :class="[ $page.url.startsWith('/transactions') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">
                                Transactions
                            </Link>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <!-- Settings Dropdown -->
                        <div class="relative">
                            <!-- Invisible overlay to close dropdown -->
                            <div v-if="showProfileDropdown" @click="showProfileDropdown = false" class="fixed inset-0 z-40"></div>
                            
                            <button @click="showProfileDropdown = !showProfileDropdown" class="relative z-50 flex items-center gap-2 rounded-full border border-slate-200/70 bg-white/90 pl-1 pr-3 py-1 shadow-sm backdrop-blur-sm transition-all hover:border-indigo-200 hover:shadow-md focus:outline-none">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full border border-indigo-200 bg-gradient-to-br from-indigo-100 to-cyan-100 font-bold text-indigo-700">{{ $page.props.auth.user?.name?.charAt(0) }}</span>
                                <span class="text-sm font-medium text-slate-700">{{ $page.props.auth.user?.name }}</span>
                                <svg class="ml-1 h-4 w-4 text-slate-400 transition-transform duration-200" :class="{'rotate-180': showProfileDropdown}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <transition
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div v-if="showProfileDropdown" class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-black/5 z-50 overflow-hidden">
                                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                                        <p class="text-sm font-medium text-slate-900 truncate">{{ $page.props.auth.user?.name }}</p>
                                        <p class="text-xs text-slate-500 truncate">{{ $page.props.auth.user?.email }}</p>
                                    </div>
                                    <div class="py-1">
                                        <Link href="/profile" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">Profile Details</Link>
                                    </div>
                                    <div class="py-1 border-t border-slate-100">
                                        <Link href="/logout" method="post" as="button" class="block w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors">Logout</Link>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center rounded-xl p-2 text-slate-500 transition-all duration-200 ease-in-out hover:bg-indigo-50 hover:text-indigo-600 focus:bg-indigo-50 focus:text-indigo-600 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-4"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-4"
            >
                <div v-show="showingNavigationDropdown" class="sm:hidden bg-white/95 backdrop-blur-xl border-t border-slate-100 shadow-xl absolute w-full z-50">
                    <div class="space-y-1 px-3 py-3">
                        <Link href="/dashboard" class="block w-full rounded-xl px-4 py-3 text-left text-base font-medium transition duration-150 ease-in-out" :class="[ $page.url === '/dashboard' ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">
                            Dashboard
                        </Link>
                        <Link href="/customers" class="block w-full rounded-xl px-4 py-3 text-left text-base font-medium transition duration-150 ease-in-out" :class="[ $page.url.startsWith('/customers') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">Customers</Link>
                        <Link href="/proposals" class="block w-full rounded-xl px-4 py-3 text-left text-base font-medium transition duration-150 ease-in-out" :class="[ $page.url.startsWith('/proposals') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">Proposals</Link>
                        <Link href="/invoices" class="block w-full rounded-xl px-4 py-3 text-left text-base font-medium transition duration-150 ease-in-out" :class="[ $page.url.startsWith('/invoices') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">Invoices</Link>
                        <Link href="/transactions" class="block w-full rounded-xl px-4 py-3 text-left text-base font-medium transition duration-150 ease-in-out" :class="[ $page.url.startsWith('/transactions') ? 'bg-white text-slate-900 shadow-md ring-1 ring-slate-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' ]">Transactions</Link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-slate-100 px-3 py-4 bg-slate-50/50">
                        <div class="px-4 flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-indigo-200 bg-gradient-to-br from-indigo-100 to-cyan-100 font-bold text-indigo-700">
                                {{ $page.props.auth.user?.name?.charAt(0) }}
                            </div>
                            <div>
                                <div class="font-medium text-base text-slate-800">{{ $page.props.auth.user?.name }}</div>
                                <div class="font-medium text-sm text-slate-500">{{ $page.props.auth.user?.email }}</div>
                            </div>
                        </div>

                        <div class="mt-4 space-y-1 px-1">
                            <Link href="/logout" method="post" as="button" class="block w-full rounded-xl px-4 py-2.5 text-left text-base font-medium text-rose-600 transition duration-150 ease-in-out hover:bg-rose-50 hover:text-rose-700">
                                Log Out
                            </Link>
                        </div>
                    </div>
                </div>
            </transition>
        </nav>

        <!-- Page Heading -->
        <header class="relative z-10" v-if="$slots.header">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main class="relative z-10 flex-grow">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-200 bg-white py-8 mt-auto">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-500">
                &copy; {{ new Date().getFullYear() }} CRM. All rights reserved.
            </div>
        </footer>
    </div>
</template>
