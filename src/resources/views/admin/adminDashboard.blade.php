@if (auth()->user()->isAdmin())
    @section('title', __('messages.admin_dashboard'))
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('messages.admin_dashboard') }}
            </h2>
        </x-slot>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 m-4">
            @include('admin.partials.admin-nav')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">{{ __('messages.admin_dashboard') }}</h3>
                    <p class="text-gray-600">{{ __('messages.admin_manual_intro') }}</p>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
