@section('title', __('messages.quizOwnerShow'))
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
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $userStat['correct'] . '/' . $userStat['max'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $userStat['submitted_at']->format('d.m.Y') }}
                                        </td>
                                        <td class="pl-1 pr-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="grid grid-cols-2 gap-2">
                                                <form
                                                    action="{{ route('quiz.entry', ['quiz' => $quiz, 'user_name' => $userStat['user_name']]) }}"
                                                    method="GET"
                                                    class="w-full h-full flex items-center justify-center">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 py-2 px-4 hover:bg-red-700 border border-transparent rounded-md font-semibold text-xs text-center w-full h-full flex items-center justify-center">@lang('messages.delete')</button>
                                                </form>
                                                <form action="{{ route('quiz.export', [$quiz, $userStat['user']]) }}"
                                                    method="GET"
                                                    class="w-full h-full flex items-center justify-center">
                                                    <button type="submit"
                                                        class="text-white bg-blue-500 py-2 px-4 hover:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-center w-full h-full flex items-center justify-center">@lang('messages.export')</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form action="{{ route('quiz.export_all', $quiz) }}" method="GET"
                            class="w-full h-full flex items-center justify-center">
                            <button type="submit"
                                class="text-white bg-gray-500 py-2 px-4 hover:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-center w-full h-full flex items-center justify-center">@lang('messages.export_all')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>
