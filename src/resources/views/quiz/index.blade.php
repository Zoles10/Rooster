@section('title', __('messages.myQuizzes'))
<x-app-layout>
    @vite('resources/js/quiz.js')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.myQuizzes') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-c</div>ol mt-5 w-full">
            <div class="ml-1">
                <label for="statusSelect" class="block text-sm font-medium text-gray-700">@lang('messages.status'):</label>
                <select id="statusSelect" name="status"
                    class="mt-1 block w-28 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="newest" selected>@lang('messages.newest')</option>
                    <option value="oldest">@lang('messages.oldest')</option>
                </select>
            </div>
            <div class="ml-1">
                <label for="createQuiz" class="block text-sm font-medium text-gray-700 opacity-0">a</label>
                <a id="createQuiz" href="{{ route('quiz.create') }}"
                    class="mt-1 imp_bg_purple w-full py-2 px-3 border border-gray-30 text-m text-white uppercase hover:text-gray-300 hover:bg-purple-700 active:bg-purple-900 focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150 bg-purple-800 font-semibold rounded-md shadow-sm focus:outline-none sm:text-sm flex items-center justify-center">
                    @svg('mdi-plus', 'w-5 h-5 mr-0.5 text-gray-100')
                    @lang('messages.createQuiz')
                </a>
            </div>
        </div>
        <div class="my-2 overflow-x-auto w-full hidden lg:block">
            <div class="py-2 align-middle inline-block min-w-full">
                <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 mb-2">
                        <thead class="imp_bg_white p-2">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                    @lang('messages.quizTitle')
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                    @lang('messages.quizDescription')
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                    @lang('messages.quizCode')
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                    @lang('messages.createdAt')
                                </th>
                                <th
                                    class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center ">
                                    @lang('messages.active')
                                </th>
                                <th
                                    class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center">
                                    @lang('messages.actions')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($quizzes as $quiz)
                                <tr class="border">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('quiz.show', $quiz->id) }}" class="text-sm text-gray-900 ">
                                            {{ \Illuminate\Support\Str::limit($quiz->title, 10) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Illuminate\Support\Str::limit($quiz->description, 10) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button id="{{ $quiz->id }}btn" class="text-blue-500 hover:text-blue-700">
                                            {{ $quiz->id }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $quiz->created_at->format('d.m.Y') }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 justify-center items-center">
                                        <div class="flex justify-center items-center">
                                            <form method="POST" action="{{ route('quiz.update', $quiz) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex items-center">
                                                    <input type="hidden" name="active"
                                                        value="{{ $quiz->active ? '0' : '1' }}">
                                                    <input type="checkbox" name="active_checkbox"
                                                        class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded"
                                                        onchange="this.form.submit()" value="{{ $quiz->id }}"
                                                        {{ $quiz->active ? 'checked' : '' }}>
                                                    @if (!$quiz->active)
                                                        <div class="mt-2 ml-2">
                                                            <div>
                                                                {{ __('messages.lastClosed') }}:
                                                                {{ \Carbon\Carbon::parse($quiz->last_closed)->format('d.m.Y') }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                </div>
                </td>
                <td class="pl-1 pr-3 py-4 whitespace-nowrap text-sm text-gray-500">
                    <div class="flex flex-row gap-1 items-center justify-center">
                        <a href="{{ route('quiz.edit', $quiz->id) }}" title="{{ __('messages.edit') }}"
                            class="inline-flex items-center justify-center p-2 h-9 w-9 bg-emerald-500 hover:bg-emerald-600 text-white rounded-md border border-transparent focus:outline-none">
                            @svg('mdi-pencil', 'w-5 h-5')
                            <span class="sr-only">@lang('messages.edit')</span>
                        </a>
                        <form action="{{ route('quiz.multiply', $quiz) }}" method="POST" class="inline-block">
                            @csrf
                            @method('POST')
                            <button type="submit" title="{{ __('messages.clone') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 bg-blue-500 hover:bg-blue-700 text-white rounded-md border border-transparent focus:outline-none">@svg('mdi-content-copy', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.clone')</span>
                            </button>
                        </form>
                        <form action="{{ route('quiz.destroy', $quiz->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="{{ __('messages.delete') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 bg-red-600 hover:bg-red-700 text-white rounded-md border border-transparent focus:outline-none">
                                @svg('mdi-delete-forever-outline', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.delete')</span>
                            </button>
                        </form>
                        @if (!$quiz->active)
                            <a href="{{ route('quiz.comparison', $quiz) }}" title="{{ __('messages.export') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 bg-gray-600 hover:bg-gray-700 text-white rounded-md border border-transparent focus:outline-none">@svg('mdi-export-variant', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.export')</span>
                            </a>
                        @else
                            <button disabled title="{{ __('messages.export') }}"
                                class="text-gray-300 bg-gray-600 p-2 h-9 w-9 rounded-md border border-transparent inline-flex items-center justify-center">@svg('mdi-export-variant', 'w-5 h-5')<span
                                    class="sr-only">@lang('messages.export')</span></button>
                        @endif
                    </div>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>
                {{ $quizzes->links() }}
            </div>
        </div>
    </div>
    <!-- Tailwind Modal -->
    <div id="codeModal" class="hidden fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white border border-indigo-300 rounded-lg p-8 flex flex-col justify-center">
            <div class="flex flex-col justify-center items-center">

                <h2 class="text-2xl font-bold mb-4">@lang('messages.scanMe')</h2>
                <div id="qr-code">

                </div>
                <hr class="mx-3 my-auto">
                <p class="mb-1 mt-3">@lang('messages.copyLink'): <span id="code"></span></p>
                <div class="mt-6 flex justify-center">
                    <button id="hideModalButton"
                        class="px-4 py-2 bg-red-600 text-white rounded-md mr-2">@lang('messages.cancel')</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile View -->
    <div id="mobileTable" class="grid grid-cols-1 gap-4 py-6 lg:px-8 lg:hidden">
        @foreach ($quizzes as $quiz)
            <div id="{{ $quiz->id }}-{{ $quiz->created_at->format('d.m.Y') }}"
                class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <div class="font-semibold text-lg text-purple-800">
                        <a href="{{ route('quiz.show', $quiz->id) }}"
                            class="text-purple-800 hover:text-purple-600">{{ $quiz->title }}</a>
                    </div>
                    <div class="text-sm text-gray-700 mt-2">@lang('messages.quizDescription'): {{ $quiz->description }}</div>
                    <div class="text-sm text-gray-700">@lang('messages.createdAt'): {{ $quiz->created_at->format('d.m.Y') }}
                    </div>
                    <div class="flex flex-row gap-2 mt-3 items-center">
                        <form method="POST" action="{{ route('quiz.update', $quiz) }}" class="flex items-center">
                            @csrf
                            @method('PUT')
                            <input type="checkbox" name="active_checkbox"
                                class="form-checkbox h-5 w-5 text-indigo-600 rounded" onchange="this.form.submit()"
                                value="{{ $quiz->id }}" {{ $quiz->active ? 'checked' : '' }}>
                            <input type="hidden" name="active" value="{{ $quiz->active ? '0' : '1' }}">
                        </form>
                        @if (!$quiz->active)
                            <div class="text-xs text-gray-500 ml-1">
                                {{ __('messages.lastClosed') }}:
                                {{ \Carbon\Carbon::parse($quiz->last_closed)->format('d.m.Y') }}
                            </div>
                        @endif
                        <div class="flex flex-row gap-2 ml-auto items-center">
                            <a href="{{ route('quiz.edit', $quiz->id) }}"
                                class="inline-flex items-center justify-center h-9 w-9 bg-emerald-500 hover:bg-emerald-600 text-white rounded-md border border-transparent focus:outline-none"
                                title="{{ __('messages.edit') }}">
                                @svg('mdi-pencil', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.edit')</span>
                            </a>
                            <form action="{{ route('quiz.multiply', $quiz) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    class="inline-flex items-center justify-center h-9 w-9 bg-blue-500 hover:bg-blue-700 text-white rounded-md border border-transparent focus:outline-none"
                                    title="{{ __('messages.clone') }}">
                                    @svg('mdi-content-copy', 'w-5 h-5')
                                    <span class="sr-only">@lang('messages.clone')</span>
                                </button>
                            </form>
                            <form action="{{ route('quiz.destroy', $quiz->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center h-9 w-9 bg-red-600 hover:bg-red-700 text-white rounded-md border border-transparent focus:outline-none"
                                    title="{{ __('messages.delete') }}">
                                    @svg('mdi-delete-forever-outline', 'w-5 h-5')
                                    <span class="sr-only">@lang('messages.delete')</span>
                                </button>
                            </form>
                            @if (!$quiz->active)
                                <a href="{{ route('quiz.comparison', $quiz) }}" title="{{ __('messages.export') }}"
                                    class="inline-flex items-center justify-center h-9 w-9 bg-gray-600 hover:bg-gray-700 text-white rounded-md border border-transparent focus:outline-none">
                                    @svg('mdi-export-variant', 'w-5 h-5')
                                    <span class="sr-only">@lang('messages.export')</span>
                                </a>
                            @else
                                <button disabled
                                    class="inline-flex items-center justify-center h-9 w-9 opacity-40 bg-gray-600 rounded-md border border-transparent">
                                    @svg('mdi-export-variant', 'w-5 h-5')
                                    <span class="sr-only">@lang('messages.export')</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
</x-app-layout>
