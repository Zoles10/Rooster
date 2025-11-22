<div class="my-2 overflow-x-auto w-full hidden custom:block">
    <input type="text" id="search" class="rounded" placeholder='{{ __('messages.searchUsername') }}'>
    <div class="py-2 align-middle inline-block min-w-full">
        <div class="shadow-lg overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="table min-w-full divide-y divide-gray-200 mb-2">
                <thead class="imp_bg_white p-2">
                    <tr>
                        <th class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                            {{ __('messages.quiz_title') }}
                        </th>
                        <th class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                            {{ __('messages.quizCode') }}
                        </th>
                        <th class="px-6 py-4 text-left text-m font-medium text-gray-800 uppercase tracking-wider">
                            {{ __('messages.owner') }}
                        </th>
                        <th class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center">
                            {{ __('messages.active') }}
                        </th>
                        <th class="px-6 py-4 text-m font-medium text-gray-800 uppercase tracking-wider text-center">
                            {{ __('messages.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($quizzes as $quiz)
                        <tr class="border">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $quiz['title'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $quiz['id'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $quiz['owner_name'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <form method="POST" action="{{ route('quiz.update', $quiz) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="active" value="{{ $quiz->active ? '0' : '1' }}">
                                    <input type="checkbox" name="active_checkbox"
                                        class="form-checkbox h-5 w-5 text-indigo-600 mt-3 ml-1 p-2 rounded cursor-pointer hover:bg-indigo-100"
                                        onchange="this.form.submit()" value="{{ $quiz->id }}"
                                        {{ $quiz->active ? 'checked' : '' }}>
                                </form>
                            </td>
                            <td class="pl-1 pr-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-row gap-1 items-center justify-center">
                                    <a href="{{ route('quiz.edit', $quiz['id']) }}"
                                        class="inline-flex items-center justify-center p-2 h-9 w-9 bg-emerald-500 hover:bg-emerald-600 text-white rounded-md border border-transparent focus:outline-none"
                                        title="Edit">
                                        @svg('mdi-pencil', 'w-5 h-5')
                                        <span class="sr-only">@lang('messages.edit')</span>
                                    </a>
                                    <form action="{{ route('quiz.destroyAdmin', $quiz['id']) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center p-2 h-9 w-9 bg-rose-500 hover:bg-rose-600 text-white rounded-md border border-transparent focus:outline-none"
                                            title="Delete">
                                            @svg('mdi-delete-forever-outline', 'w-5 h-5')
                                            <span class="sr-only">@lang('messages.delete')</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mobileview -->
<div id="mobileTable" class="grid grid-cols-1 gap-4 px-4 py-6 sm:px-6 lg:px-8 custom:hidden">
    @foreach ($quizzes as $quiz)
        <div id="{{ $quiz['id'] }}-{{ $quiz['owner_name'] }}" class="bg-zinc-100 rounded-lg shadow overflow-hidden">
            <div class="p-4">
                <div class="font-semibold text-lg text-purple-800">
                    {{ __('messages.quiz') }}: {{ $quiz['title'] }}
                </div>
                <div class="text-sm text-gray-700">
                    {{ __('messages.code') }}: {{ $quiz['id'] }}
                </div>
                <div class="text-sm text-gray-700">
                    {{ __('messages.owner') }}: {{ $quiz['owner_name'] }}
                </div>
                <div class="flex items-center justify-between mt-2">
                    <div>
                        <strong>{{ __('messages.active') }}:</strong>
                        <input type="checkbox"
                            class="form-checkbox h-5 w-5 text-indigo-600 cursor-pointer hover:bg-indigo-100"
                            {{ $quiz['active'] == 1 ? 'checked' : '' }}
                            onchange="event.preventDefault(); document.getElementById('active-toggle-{{ $quiz['id'] }}').submit();">
                        <form id="active-toggle-{{ $quiz['id'] }}" action="{{ route('quiz.update', $quiz['id']) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="active" value="{{ $quiz['active'] == 1 ? 0 : 1 }}">
                        </form>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('quiz.edit', $quiz['id']) }}"
                            class="inline-flex items-center justify-center h-9 w-9 bg-emerald-500 rounded hover:bg-emerald-600"
                            title="Edit">
                            @svg('mdi-pencil', 'w-5 h-5 text-white')
                        </a>
                        <form action="{{ route('quiz.destroyAdmin', $quiz['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center h-9 w-9 bg-rose-500 text-white rounded-md hover:bg-rose-600"
                                title="Delete">
                                @svg('mdi-delete', 'w-5 h-5 text-white')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@push('scripts')
    @vite('resources/js/adminFilterByUsername.js')
@endpush

{{-- {{ $quizzes->links() }} --}}
