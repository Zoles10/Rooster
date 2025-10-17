<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.welcome') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Enter Access Code Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-4">@lang('messages.enterAccessCode')</h2>
                    <div class="flex gap-2">
                        <input type="text"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="@lang('messages.enterAccessCode')"
                               id="access-code">
                        <button type="button"
                                id="submit-code"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @lang('messages.submit')
                        </button>
                    </div>
                </div>
            </div>

            <!-- Scan QR Code Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-4">@lang('messages.scanQrCode')</h2>
                    <div id="qr-reader" class="w-full"></div>
                    <div id="qr-result" class="mt-3 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/welcome.js')
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
</x-app-layout>
