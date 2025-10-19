<x-app-layout>
    <div class="flex flex-wrap -mx-4">
        <div class="w-full md:w-1/2 px-4">
            <h1 class="text-2xl font-semibold mb-4">{{ __('messages.actualAnswers') }}</h1>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.option_text') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.timesAnswered') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-full md:w-1/2 px-4">
            <h1 class="text-2xl font-semibold mb-4">{{ __('messages.archivedAnswers') }}</h1>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.option_text') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.timesAnswered') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- Back Button -->
    <div class="flex justify-center mt-4">
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            @lang('messages.backToQuestions')
        </a>
    </div>
</x-app-layout>
