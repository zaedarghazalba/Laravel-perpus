<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 animate-fade-in">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold font-display text-gray-900">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                        <p class="mt-1 text-gray-500">Here's what's happening in your library today.</p>
                    </div>
                    <div class="hidden sm:block">
                        <span class="inline-flex items-center px-4 py-2 rounded-lg bg-brand-50 text-brand-700 text-sm font-medium">
                            {{ now()->format('l, d F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Books</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2 font-display">1,248</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                            <x-icon name="book" class="w-6 h-6" />
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Members</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2 font-display">856</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                            <x-icon name="users" class="w-6 h-6" />
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending Loans</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2 font-display">24</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                            <x-icon name="bell" class="w-6 h-6" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
