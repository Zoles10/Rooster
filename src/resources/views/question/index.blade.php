@section('title', __('messages.myQuestions'))
<x-app-layout>
    @push('scripts')
        @vite('resources/js/questions.js')
        @vite('resources/js/sortQuestions.js')
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.myQuestions') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-c</div>ol mt-5 w-full">
            <div>
                <label for="subjectSelect" class="block text-sm font-medium text-gray-700">@lang('messages.subject'):</label>
                <select id="subjectSelect" name="category"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="all"> @lang('messages.all')</option>
                    @php
                        $subjects = [];
                    @endphp
                    @foreach ($questions as $question)
                        @if (!in_array($question->subject->subject, $subjects))
                            @php
                                $subjects[] = $question->subject->subject;
                            @endphp
                            <option value="{{ $question->subject->subject }}">{{ $question->subject->subject }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="ml-1">
                <label for="statusSelect" class="block text-sm font-medium text-gray-700">@lang('messages.status'):</label>
                <select id="statusSelect" name="status"
                    class="mt-1 block w-28 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="newest" selected>@lang('messages.newest')</option>
                    <option value="oldest">@lang('messages.oldest')</option>
                </select>
            </div>
            <div class="ml-1">
                <label for="createQuestion" class="block text-sm font-medium text-gray-700 opacity-0">a</label>
                <a id="createQuestion" href="{{ route('question.create') }}"
                    class="mt-1 imp_bg_purple w-full py-2 px-3 border border-gray-30 text-m text-white uppercase hover:text-gray-300 hover:bg-purple-700 active:bg-purple-900 focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150 bg-purple-800 font-semibold rounded-md shadow-sm focus:outline-none sm:text-sm flex items-center justify-center">
                    @svg('mdi-plus', 'w-5 h-5 text-gray-100 mr-0.5')
                    @lang('messages.createQuestion')
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
                                    @lang('messages.question')
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                    @lang('messages.subject')
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                    @lang('messages.quiz')
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                    @lang('messages.createdAt')
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                    @lang('messages.results')
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
                            @foreach ($questions as $question)
                                <tr class="border">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('question.show', $question->id) }}"
                                            class="text-sm text-gray-900 ">
                                            {{ \Illuminate\Support\Str::limit($question->question, 10) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $question->subject->subject }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap center">
                                        {{ $question->quiz_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $question->created_at->format('d.m.Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('answers.show', $question->id) }}"
                                            class="text-sm text-gray-900">
                                            @lang('messages.goToResults')
                                        </a>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 justify-center items-center">
                                        <div class="flex justify-center items-center">
                                            <form method="POST" action="{{ route('question.update', $question) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex items-center">
                                                    <input type="hidden" name="active"
                                                        value="{{ $question->active ? '0' : '1' }}">
                                                    <input type="checkbox" name="active_checkbox"
                                                        class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded"
                                                        onchange="this.form.submit()" value="{{ $question->id }}"
                                                        {{ $question->active ? 'checked' : '' }}>
                                                    @if (!$question->active)
                                                        <div class="mt-2 ml-2">
                                                            <div>
                                                                {{ __('messages.lastClosed') }}:
                                                                {{ \Carbon\Carbon::parse($question->last_closed)->format('d.m.Y') }}
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
                        <a href="{{ route('question.edit', $question->id) }}" title="{{ __('messages.edit') }}"
                            class="inline-flex items-center justify-center p-2 h-9 w-9 text-white bg-emerald-500 hover:bg-emerald-600 rounded-md border border-transparent focus:outline-none">
                            @svg('mdi-pencil', 'w-5 h-5')
                            <span class="sr-only">@lang('messages.edit')</span>
                        </a>

                        <form action="{{ route('question.multiply', $question) }}" method="POST" class="inline-block">
                            @csrf
                            @method('POST')
                            <button type="submit" title="{{ __('messages.clone') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 text-white bg-blue-500 hover:bg-blue-700 rounded-md border border-transparent focus:outline-none">
                                @svg('mdi-content-copy', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.clone')</span>
                            </button>
                        </form>

                        <form action="{{ route('question.destroy', $question->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="{{ __('messages.delete') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 text-white bg-red-600 hover:bg-red-700 rounded-md border border-transparent focus:outline-none">
                                @svg('mdi-delete-forever-outline', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.delete')</span>
                            </button>
                        </form>

                        @if ($question->options()->whereHas('answers')->exists())
                            <a href="{{ route('answers.export', $question->id) }}" title="{{ __('messages.export') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 text-white bg-gray-600 hover:bg-gray-700 rounded-md border border-transparent focus:outline-none">
                                @svg('mdi-export-variant', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.export')</span>
                            </a>
                        @else
                            <button disabled title="{{ __('messages.export') }}"
                                class="inline-flex items-center justify-center p-2 h-9 w-9 opacity-40 bg-gray-600 rounded-md border border-transparent">
                                @svg('mdi-export-variant', 'w-5 h-5')<span class="sr-only">@lang('messages.export')</span>
                            </button>
                        @endif
                    </div>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>
                {{ $questions->links() }}
            </div>
        </div>
    </div>

    <!-- Mobile View -->
    <div id="mobileTable" class="grid grid-cols-1 gap-4 py-6 lg:px-8 lg:hidden">
        @foreach ($questions as $question)
            <div id="{{ $question->id }}-{{ $question->created_at->format('d.m.Y') }}-{{ $question->subject->subject }}"
                class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <div class="font-semibold text-lg text-purple-800">
                        <a href="{{ route('question.show', $question->id) }}"
                            class="text-purple-800 hover:text-purple-600">{{ $question->question }}</a>
                    </div>
                    <div class="text-sm text-gray-700 mt-2">@lang('messages.subject'): {{ $question->subject->subject }}</div>
                    <div class="text-sm text-gray-700">@lang('messages.createdAt'): {{ $question->created_at->format('d.m.Y') }}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('answers.show', $question->id) }}"
                            class="text-blue-500 hover:text-blue-700 text-sm">@lang('messages.goToResults')</a>
                    </div>
                    <div class="flex flex-row gap-2 mt-3 items-center">
                        <form method="POST" action="{{ route('question.update', $question) }}"
                            class="flex items-center">
                            @csrf
                            @method('PUT')
                            <input type="checkbox" name="active_checkbox"
                                class="form-checkbox h-5 w-5 text-indigo-600 rounded" onchange="this.form.submit()"
                                value="{{ $question->id }}" {{ $question->active ? 'checked' : '' }}>
                            <input type="hidden" name="active" value="{{ $question->active ? '0' : '1' }}">
                            @if ($question->active)
                                <span class="ml-2 text-sm text-gray-600">@lang('messages.active')</span>
                            @endif
                        </form>
                        @if (!$question->active)
                            <div class="text-xs text-gray-500 ml-1">
                                {{ __('messages.lastClosed') }}:
                                {{ \Carbon\Carbon::parse($question->last_closed)->format('d.m.Y') }}
                            </div>
                        @endif
                        <div class="flex flex-row gap-2 ml-auto items-center">
                            <a href="{{ route('question.edit', $question->id) }}"
                                class="inline-flex items-center justify-center h-9 w-9 text-white bg-emerald-500 hover:bg-emerald-600 rounded-md border border-transparent focus:outline-none"
                                title="{{ __('messages.edit') }}">
                                @svg('mdi-pencil', 'w-5 h-5')
                                <span class="sr-only">@lang('messages.edit')</span>
                            </a>
                            <form action="{{ route('question.multiply', $question) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    class="inline-flex items-center justify-center h-9 w-9 text-white bg-blue-500 hover:bg-blue-700 rounded-md border border-transparent focus:outline-none"
                                    title="{{ __('messages.clone') }}">
                                    @svg('mdi-content-copy', 'w-5 h-5')
                                    <span class="sr-only">@lang('messages.clone')</span>
                                </button>
                            </form>
                            <form action="{{ route('question.destroy', $question->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center h-9 w-9 text-white bg-red-600 hover:bg-red-700 rounded-md border border-transparent focus:outline-none"
                                    title="{{ __('messages.delete') }}">
                                    @svg('mdi-delete-forever-outline', 'w-5 h-5')
                                    <span class="sr-only">@lang('messages.delete')</span>
                                </button>
                            </form>
                            @if ($question->options()->whereHas('answers')->exists())
                                <a href="{{ route('answers.export', $question->id) }}"
                                    title="{{ __('messages.export') }}"
                                    class="inline-flex items-center justify-center h-9 w-9 text-white bg-gray-600 hover:bg-gray-700 rounded-md border border-transparent focus:outline-none">
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
</x-app-layout>
