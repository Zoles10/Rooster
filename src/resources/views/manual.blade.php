<x-app-layout>
    @section("title", __('messages.manual'))
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.manual') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col justify-center items-center">
            <div class="bg-white p-3 shadow-sm sm:rounded-lg flex flex-col justify-center items-center min-w-fit">
                @include("pdf.guestPDF")
                @include("pdf.userPDF")
                @include("pdf.adminPDF")
                <a href="{{ url('/pdf/manual') }}" class="px-4 py-2 w-fit bg-blue-500 rounded-md text-white hover:bg-blue-600">{{ __('messages.downloadPDF') }}</a>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
