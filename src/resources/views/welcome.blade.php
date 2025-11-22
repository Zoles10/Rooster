<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="imp_bg_white p-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.welcome') }}</h1>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Enter Access Code Section -->
                    @if (!Auth::id())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 text-gray-900">
                                <h2 class="text-2xl font-semibold mb-4">@lang('messages.guestWelcomeTitle', [], 'en')</h2>
                                <ul class="list-disc pl-5 space-y-2">
                                    <li>@lang('messages.guestRegisterToParticipate', [], 'en')</li>
                                    <li>@lang('messages.guestCreateOwnQuizzes', [], 'en')</li>
                                    <li>@lang('messages.guestAddQuestions', [], 'en')</li>
                                </ul>
                                <div class="mt-4">
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                        @svg('mdi-account-plus', 'w-5 h-5 mr-2')
                                        @lang('messages.registerNow', [], 'en')
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 text-gray-900">
                                <h2 class="text-2xl font-semibold mb-4">@lang('messages.enterAccessCode')</h2>
                                <div class="flex gap-2">
                                    <input type="text"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="@lang('messages.enterAccessCode')" id="access-code">
                                    <button type="button" id="submit-code"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                        @svg('mdi-login', 'w-5 h-5 mr-2')
                                        @lang('messages.enter')
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Scan QR Code Section -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <h2 class="text-2xl font-semibold mb-4">@lang('messages.scanQrCode')</h2>
                                <div id="qr-reader" class="w-full"></div>
                                <div id="qr-result"
                                    class="mt-3 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md"
                                    style="display: none;"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/welcome.js')
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
</x-app-layout>
