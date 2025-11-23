@section('title', $quiz->id . ' - ' . __('messages.answer_text'))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $quiz->title . ' | ' . $quiz->id }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-c</div>ol mt-5 w-full">
            <div class="my-2 overflow-x-auto w-full hidden lg:block">
                <div class="py-2 align-middle inline-block min-w-full">
                    <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 mb-2">
                            <thead class="imp_bg_white p-2">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        @lang('messages.userName')
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        @lang('messages.userPoints')
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        @lang('messages.submittedAt')
                                    </th>
                                    <th
                                        class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center">
                                        @lang('messages.actions')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($userStats as $userStat)
                                    <tr class="border">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $userStat['user_name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $userStat['correct'] . '/' . $userStat['max'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $userStat['submitted_at']->format('d.m.Y') }}
                                        </td>
                                        <td class="pl-1 pr-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex gap-1 items-center justify-center">
                                                <form
                                                    action="{{ route('quiz.entry', ['quiz' => $quiz, 'user_name' => $userStat['user_name']]) }}"
                                                    method="GET" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="{{ __('messages.delete') }}"
                                                        class="inline-flex items-center justify-center p-2 h-9 w-9 bg-rose-500 hover:bg-rose-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                                        @svg('mdi-delete-forever-outline', 'w-5 h-5')
                                                        <span class="sr-only">@lang('messages.delete')</span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('quiz.export', [$quiz, $userStat['user']]) }}"
                                                    method="GET" class="inline-block">
                                                    <button type="submit" title="{{ __('messages.export') }}"
                                                        class="inline-flex items-center justify-center p-2 h-9 w-9 bg-teal-400 hover:bg-teal-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                                        @svg('mdi-file-export', 'w-5 h-5')
                                                        <span class="sr-only">@lang('messages.export')</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Export All Button -->
                        <div class="flex justify-center mt-4 pb-4">
                            <form action="{{ route('quiz.export_all', $quiz) }}" method="GET" class="inline-block">
                                <button type="submit" title="{{ __('messages.export_all') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-teal-400 hover:bg-teal-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                    @svg('mdi-file-export-outline', 'w-5 h-5 mr-2')
                                    @lang('messages.export_all')
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile View -->
    <div id="mobileTable" class="grid grid-cols-1 gap-4 lg:hidden">
        @foreach ($userStats as $userStat)
            <div id="{{ $quiz->id }}-{{ $userStat['user_name'] }}"
                class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <div class="font-semibold text-lg text-purple-800">
                        {{ $userStat['user_name'] }}
                    </div>
                    <div class="text-sm text-gray-700 mt-2">
                        @lang('messages.userPoints'): {{ $userStat['correct'] . '/' . $userStat['max'] }}
                    </div>
                    <div class="text-sm text-gray-700 mt-1">
                        @lang('messages.submittedAt'): {{ $userStat['submitted_at']->format('d.m.Y') }}
                    </div>

                    <div class="mt-4 flex gap-1 items-center ">
                        <form
                            action="{{ route('quiz.entry', ['quiz' => $quiz, 'user_name' => $userStat['user_name']]) }}"
                            method="GET" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="{{ __('messages.delete') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 bg-rose-500 hover:bg-rose-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                @svg('mdi-delete-forever-outline', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.delete')</span>
                            </button>
                        </form>

                        <form action="{{ route('quiz.export', [$quiz, $userStat['user']]) }}" method="GET"
                            class="inline-block">
                            <button type="submit" title="{{ __('messages.export') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 bg-teal-400 hover:bg-teal-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                                @svg('mdi-file-export', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.export')</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- export all button for mobile -->
        <div class="flex justify-center mt-4">
            <form action="{{ route('quiz.export_all', parameters: $quiz) }}" method="GET" class="inline-block">
                <button type="submit" title="{{ __('messages.export_all') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-teal-400 hover:bg-teal-600 text-white rounded-md border border-transparent focus:outline-none transition ease-in-out duration-150">
                    @svg('mdi-file-export-outline', 'w-5 h-5 mr-2')
                    @lang('messages.export_all')
                </button>
            </form>
        </div>
</x-app-layout>
