<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-3 shadow-sm sm:rounded-lg flex flex-col justify-center items-center">
                @if(!auth()->user())
                    @include("pdf.guestPDF")
                    <a href="{{ url('/pdf/guest') }}" class="px-4 py-2 m-2 w-fit bg-blue-500 rounded-md text-white hover:bg-blue-600">Download PDF</a>
                @elseif (!auth()->user()->isAdmin())
                    @include("pdf.userPDF")
                    <a href="{{ url('/pdf/user') }}" class="px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">Download PDF</a>
                @elseif (auth()->user()->isAdmin())
                    @include("pdf.adminPDF")
                    <a href="{{ url('/pdf/admin') }}" class="px-4 py-2 bg-blue-500 rounded-md text-white hover:bg-blue-600">Download PDF</a>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
