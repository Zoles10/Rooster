@section('title', __('messages.myQuestions'))
<x-app-layout>
    @push('scripts')
        @vite('resources/js/dashboard.js')
        @vite('resources/js/sortQuestions.js')
    @endpush
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center">
            <a href="{{ route('question.create') }}"
            class="imp_bg_purple inline-flex items-center px-4 py-2 hover:text-gray-300 bg-purple-800 border border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
            @lang('messages.createQuestion')
        </a>
    </div>

    <div class="flex flex-c</div>ol mt-5 w-full">
        <div>
            <label for="subjectSelect" class="block text-sm font-medium text-gray-700">@lang('messages.subject'):</label>
            <select id="subjectSelect" name="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="all"> @lang('messages.all')</option>
                @php
                    $subjects = [];
                @endphp
                @foreach($questions as $question)
                    @if(!in_array($question->subject->subject, $subjects))
                        @php
                            $subjects[] = $question->subject->subject;
                        @endphp
                        <option value="{{ $question->subject->subject }}">{{ $question->subject->subject }}</option>
                    @endif
                @endforeach
            </select>
            </select>
        </div>
        <div>
            <label for="statusSelect" class="block text-sm font-medium text-gray-700">@lang('messages.status'):</label>
            <select id="statusSelect" name="status" class="mt-1 block w-28 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="newest" selected>@lang('messages.newest')</option>
                <option value="oldest">@lang('messages.oldest')</option>
            </select>
        </div>
    </div>
        <div class="flex flex-c</div>ol mt-5 w-full">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-full hidden lg:block">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
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
                                        @lang('messages.createdAt')
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        @lang('messages.results')
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                                        @lang('messages.code')
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
                                                class="text-sm text-gray-900">
                                                {{ $question->question }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $question->subject->subject }}
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
                                        <td class="px-4 py-2">
                                            <button id="{{ $question->id }}btn"
                                                class="text-blue-500 hover:text-blue-700">
                                                {{ $question->id }}
                                            </button>
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
                                                        @if ($question->active)
                                                            <div class="mt-2 ml-2">
                                                                <input type="text" name="note" class="px-2 py-1 border border-gray-300 rounded-md" placeholder="@lang('messages.note')">
                                                            </div>
                                                        @else
                                                            <div class="mt-2 ml-2">
                                                                <div>
                                                                    {{__('messages.lastClosed')}}: {{ \Carbon\Carbon::parse($question->last_closed)->format('d.m.Y') }}
                                                                </div>
                                                                <div>
                                                                    {{__('messages.lastNote')}}: {{ $question->last_note }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="grid grid-cols-2 gap-2">
                                                <a href="{{ route('question.edit', $question->id) }}"
                                                    class="text-white bg-purple-600 py-2 px-4 hover:bg-purple-700 border border-transparent rounded-md font-semibold text-xs text-center min-w-[75px]">
                                                    @lang('messages.edit')
                                                </a>
                                                <form action="{{ route('question.multiply', $question) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit"
                                                        class="text-white bg-blue-500 py-2 px-4 hover:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-center min-w-[75px]">
                                                        @lang('messages.clone')
                                                    </button>
                                                </form>
                                                <form action="{{ route('question.destroy', $question->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 py-2 px-4 hover:bg-red-700 border border-transparent rounded-md font-semibold text-xs text-center min-w-[75px]">
                                                        @lang('messages.delete')
                                                    </button>
                                                </form>
                                                <a href="{{ route('answers.comparison', $question->id) }}"
                                                    class="text-white bg-gray-600 py-2 px-4 hover:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-center min-w-[75px]">
                                                    @lang('messages.archive')
                                                </a>
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
    </div>
    </div>

    <!-- Mobile View -->
    <div id="mobileTable" class="grid grid-cols-1 gap-4 px-4 py-6 sm:px-6 lg:px-8 lg:hidden">
        @foreach ($questions as $question)
            <div id="{{ $question->id }}-{{ $question->created_at->format('d.m.Y') }}-{{ $question->subject->subject }}" class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <div class="font-semibold text-lg text-purple-800">
                        <a href="{{ route('question.show', $question->id) }}" class="text-purple-800 hover:text-purple-600">{{ $question->question }}</a>
                    </div>
                    <div class="text-sm text-gray-700 mt-2">@lang('messages.subject'): {{ $question->subject->subject }}</div>
                    <div class="text-sm text-gray-700">@lang('messages.createdAt'): {{ $question->created_at->format('d.m.Y') }}</div>
                    <div class="mt-4">
                        <a href="{{ route('answers.show', $question->id) }}" class="text-blue-500 hover:text-blue-700 text-sm">@lang('messages.goToResults')</a>
                    </div>
                    <div class="mt-2">
                        <form method="POST" action="{{ route('question.update', $question) }}">
                            @csrf
                            @method('PUT')
                            <label class="flex items-center">
                                <input type="checkbox" name="active_checkbox" class="form-checkbox h-5 w-5 text-indigo-600 rounded" onchange="this.form.submit()" value="{{ $question->id }}" {{ $question->active ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">@lang('messages.active')</span>
                            </label>
                            <input type="hidden" name="active" value="{{ $question->active ? '0' : '1' }}">
                            @if ($question->active)
                                <div class="mt-2">
                                    <input type="text" name="note" class="px-2 py-1 border border-gray-300 rounded-md" placeholder="@lang('messages.note')">
                                </div>
                            @else
                                <div class="mt-2">
                                    <div>{{ __('messages.lastClosed') }}: {{ \Carbon\Carbon::parse($question->last_closed)->format('d.m.Y') }}</div>
                                    <div>{{ __('messages.lastNote') }}: {{ $question->last_note }}</div>
                                </div>
                            @endif
                        </form>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <a href="{{ route('question.edit', $question->id) }}" class="text-sm bg-purple-600 text-white p-2 rounded hover:bg-purple-700 text-center w-full">@lang('messages.edit')</a>
                        <form action="{{ route('question.multiply', $question) }}" method="POST" class="w-full">
                            @csrf
                            @method('POST')
                            <button type="submit" class="text-sm bg-blue-500 text-white p-2 rounded hover:bg-blue-700 text-center w-full">@lang('messages.clone')</button>
                        </form>
                        <form action="{{ route('question.destroy', $question->id) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm bg-red-600 text-white p-2 rounded hover:bg-red-700 text-center w-full">@lang('messages.delete')</button>
                        </form>
                        <a href="{{ route('answers.comparison', $question->id) }}" class="text-sm bg-gray-600 text-white p-2 rounded hover:bg-gray-700 text-center w-full">@lang('messages.archive')</a>
                    </div>
                </div>
            </div>
        @endforeach
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
                    <button id="hideModalButton" class="px-4 py-2 bg-red-600 text-white rounded-md mr-2">@lang('messages.cancel')</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
</x-app-layout>
