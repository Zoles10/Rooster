<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden shadow-sm sm:rounded-lg">
                @if(!auth()->user())
                    @include("pdf.guestPDF")
                    <a href="{{ route('/pdf/guest') }}">Download PDF</a>
                @elseif (!auth()->user()->isAdmin())
                    @include("pdf.userPDF")
                    <a href="{{ route('/pdf/user') }}">Download PDF</a>
                @elseif (auth()->user()->isAdmin())
                    @include("pdf.adminPDF")
                    <a href="{{ url('/pdf/admin') }}">Download PDF</a>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
